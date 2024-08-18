<?php

namespace App\Filament\Resources\SectionResource\Widgets;

use App\Models\Order;
use App\Models\OrderListing;
use App\Models\Section;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Model;

class SoldOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    public ?Model $record = null;
    protected int | string | array $columnSpan = 1;

    protected function getStats(): array
    {
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
        return [
            //
            Stat::make('Sold', $sold -> last() -> aggregate)
                -> chart($sold -> map(fn (TrendValue $value) => $value -> aggregate) -> all())
                -> color('primary')
        ];
    }
}
