<?php

namespace App\Filament\Widgets;

use App\Models\Detail;
use App\Models\Listing;
use App\Models\Order;
use App\Models\OrderListing;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class InventoryChart extends ChartWidget
{
    protected static ?string $heading = 'Inventory';
    protected static ?string $pollingInterval = null;
    protected static string $color = 'gray';
    protected static ?int $sort = 3;

    protected function getData(): array
    { 
        $inventories = Trend::query(
                Detail::query()
            )
            -> between(
                start: now()->startOfYear(),
                end: now(),
            )
            -> perMonth()
            -> sum('inventory');
        
        $sold = Trend::query(OrderListing::query() -> join('details', 'details.id', '=', 'orders_listings.order_id'))
            -> between(
                start: now() -> startOfYear(),
                end: now(),
            )
            -> dateColumn('orders_listings.created_at')
            -> perMonth()
            -> sum('sold'); 
        foreach($inventories as $key => $value){
            if($key != 0){
                $value -> aggregate += $inventories[$key - 1] -> aggregate;
            }
            $value -> aggregate -= $sold[$key] -> aggregate;
        }
        return [
                //
                'datasets' => [
                    [
                        'label' => 'Inventory',
                        'data' => $inventories -> map(fn (TrendValue $value) => $value -> aggregate), 
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
