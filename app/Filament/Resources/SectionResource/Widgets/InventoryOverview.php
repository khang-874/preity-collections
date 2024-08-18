<?php

namespace App\Filament\Resources\SectionResource\Widgets;

use App\Models\Detail;
use App\Models\Order;
use App\Models\OrderListing;
use App\Models\Section;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class InventoryOverview extends BaseWidget
{

    protected static ?string $pollingInterval = null;
    public ?Section $record = null;
    protected int | string | array $columnSpan = 1;

    protected function getStats(): array
    {
        $inventories = Trend::query(
                Detail::query()
                        -> join('listings', 'listings.id', '=', 'details.listing_id')
                        -> join('subsections', 'listings.subsection_id', '=', 'subsections.id')
                        -> join('sections', 'subsections.section_id', '=', 'sections.id')
                        -> where('sections.id', '=', $this -> record ?-> id)
            )
            -> between(
                start: now()->startOfYear(),
                end: now(),
            )
            -> dateColumn('listings.created_at')
            -> perMonth()
            -> sum('inventory');
        
        $sold = Trend::query(
                Order::query() -> join('orders_listings', 'orders.id', '=', 'orders_listings.order_id')
                        -> join('listings', 'listings.id', '=', 'orders_listings.listing_id')
                        -> join('details', 'details.listing_id', '=', 'listings.id')
                        -> join('subsections', 'listings.subsection_id', '=', 'subsections.id')
                        -> join('sections', 'sections.id', '=', 'subsections.section_id')
                        -> where('sections.id', '=', $this -> record ?-> id)
            )
            -> between(
                start: now() -> startOfYear(),
                end: now(),
            )
            -> dateColumn('orders_listings.created_at')
            -> perMonth()
            -> sum('sold'); 
            
        // dd($inventories, $sold, $this -> record);
        $totalInventory = 0;
        foreach($inventories as $key => $value){
            if($key != 0){
                $value -> aggregate += $inventories[$key - 1] -> aggregate;
            }
            $value -> aggregate -= $sold[$key] -> aggregate;
            $totalInventory += $value -> aggregate;
        }
        return [
            //
            Stat::make('Inventory', $totalInventory)
                -> chart($inventories -> map(fn (TrendValue $value) => $value -> aggregate) -> all())
                -> color('gray')
        ];
    }
}
