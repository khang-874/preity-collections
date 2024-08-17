<?php

namespace App\Filament\Widgets;

use App\Models\Listing;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon as SupportCarbon;

class CostOfGoodsSoldChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Cost of goods sold';
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 2;
    protected static string $color = 'info';

    protected function getData(): array
    {
        $startDate = $this -> filters['startDate'] ?? now() -> startOfYear();
        $endDate = $this -> filters['endDate'] ?? now();
        if($startDate != now() -> startOfYear()){
            $startDate = SupportCarbon::createFromFormat('Y-m-d', $startDate);
        }
        if(gettype($endDate) == 'string'){
            $endDate = SupportCarbon::createFromFormat('Y-m-d', $endDate);
        }

        $inventories = Trend::query(
                Listing::query()
                    -> selectRAW('listings.id')
                    -> join('details', 'details.listing_id', '=', 'listings.id')
                    -> groupBy('listings.id')
            )
            -> between(
                start: $startDate,
                end: $endDate,
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
