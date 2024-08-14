<?php

namespace App\Filament\Widgets;

use App\Models\Detail;
use App\Models\Order;
use App\Models\OrderListing;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class SoldListingsChart extends ChartWidget
{
    protected static ?string $heading = 'Sold';
    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
        $sold = Trend::query(OrderListing::query() -> join('details', 'details.id', '=', 'orders_listings.order_id'))
            -> between(
                start: now() -> startOfYear(),
                end: now(),
            )
            -> dateColumn('orders_listings.created_at')
            -> perMonth()
            -> sum('sold');
 
        return [
                //
                'datasets' => [
                    [
                        'label' => 'Sold',
                        'data' => $sold -> map(fn (TrendValue $value) => $value -> aggregate),
                        'backgroundColor' => '#36A2EB',
                        'borderColor' => '#9BD0F5',
                    ],
                ],
                'labels' => $sold -> map(fn (TrendValue $value) => $value -> date),
            ];

        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    } 
}
