<?php

namespace App\Filament\Widgets;

use App\Models\Detail;
use App\Models\Listing;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class ListingChart extends ChartWidget
{
    protected static ?string $heading = 'Inventory in each month';

    protected function getData(): array
    { 
        $data = Trend::query(
                Detail::query()
            )
            -> between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            -> perMonth()
            -> sum('inventory');
 
        return [
                //
                'datasets' => [
                    [
                        'label' => 'Inventory',
                        'data' => $data -> map(fn (TrendValue $value) => $value -> aggregate),
                        'backgroundColor' => '#36A2EB',
                        'borderColor' => '#9BD0F5',
                    ],
                ],
                'labels' => $data -> map(fn (TrendValue $value) => $value -> date),
            ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
