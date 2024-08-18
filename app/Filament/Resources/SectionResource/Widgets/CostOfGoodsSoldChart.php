<?php

namespace App\Filament\Resources\SectionResource\Widgets;

use App\Models\Listing;
use App\Models\Section;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CostOfGoodsSoldChart extends ChartWidget
{ 
    protected static ?string $heading = 'Cost of goods sold';
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 2;
    protected static string $color = 'info';
    public ?Section $record = null;

    protected function getData(): array
    { 
        $inventories = Trend::query(
                Listing::query()
                    -> selectRAW('listings.id')
                    -> join('details', 'details.listing_id', '=', 'listings.id')
                    -> join('subsections', 'subsections.id', '=', 'listings.subsection_id')
                    -> join('sections', 'sections.id', '=', 'subsections.section_id')
                    -> groupBy('listings.id')
                    -> where('sections.id', '=', $this -> record ?-> id)
            )
            -> between(
                start: now() -> startOfYear(),
                end: now(),
            )
            -> dateColumn('listings.created_at')
            -> perMonth()
            -> sum('listings.init_price * details.inventory + listings.init_price * details.sold'); 
        return [
                //
                'datasets' => [
                    [
                        'label' => 'Cost of good sold ($INR)',
                        'data' => $inventories -> map(fn (TrendValue $value) => $value -> aggregate), 
                        'maxBarThickness' => 40,
                        'minBarLength' => 5,
                    ],
                ],
                'labels' => $inventories -> map(fn (TrendValue $value) => $value -> date),
            ];
    }
    protected function getType(): string
    {
        return 'bar';
    }
}
