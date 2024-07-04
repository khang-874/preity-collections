<?php

namespace App\Filament\Widgets;

use App\Models\Detail;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SoldListingsChart extends ChartWidget
{
    protected static ?string $heading = 'Listings sold each month';

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
            -> sum('sold');
 
        return [
                //
                'datasets' => [
                    [
                        'label' => 'sold',
                        'data' => $data -> map(fn (TrendValue $value) => $value -> aggregate),
                        'backgroundColor' => '#36A2EB',
                        'borderColor' => '#9BD0F5',
                    ],
                ],
                'labels' => $data -> map(fn (TrendValue $value) => $value -> date),
            ];

        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
