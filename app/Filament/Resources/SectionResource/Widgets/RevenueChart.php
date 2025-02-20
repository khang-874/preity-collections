<?php

namespace App\Filament\Resources\SectionResource\Widgets;

use App\Models\Order;
use App\Models\Section;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue';
    public ?string $filter = 'total';
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 1;
    protected static string $color = 'success';
    public ?Section $record = null;

    protected function getData(): array
    { 
        $activeFilter = $this -> filter;
        $query = Order::query() 
                        -> join('orders_listings', 'orders.id', '=', 'orders_listings.order_id')
                        -> join('payments', 'payments.order_id', '=', 'orders.id')
                        -> join('listings', 'listings.id', '=', 'orders_listings.listing_id')
                        -> join('subsections', 'listings.subsection_id', '=', 'subsections.id')
                        -> join('sections', 'sections.id', '=', 'subsections.section_id');
        // dd($query -> toSql());
        if($activeFilter == 'total'){
                $query = $query -> where('payment_type', '!=', 'pending');
        }else{
            $query = $query -> where('payment_type', '=', $activeFilter); 
        } 
        
        $query -> where('sections.id', '=', $this -> record -> id);

        $data = Trend::query($query)
            -> between(
                start: now() -> startOfYear(),
                end: now(),
            ) -> perMonth() -> dateColumn('orders.created_at')-> sum('amount_paid');
        // foreach($data as $key => $value){
        //     if($key != 0)
        //         $value -> aggregate += $data[$key - 1] -> aggregate;
        // }
        return [
                'datasets' => [
                    [
                        'label' => 'Revenue ($CAD)',
                        'data' => $data -> map(fn (TrendValue $value) => $value -> aggregate), 
                        'maxBarThickness' => 40,
                        'minBarLength' => 5,
                    ],
                ],
                'labels' => $data -> map(fn (TrendValue $value) => $value -> date),
            ]; 
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getFilters(): ?array
    {
       return [
            'credit' => 'Credit',
            'cash' => 'Cash',
            'debit' => 'Debit',
            'online' => 'Online',
            'total' => 'Total',
       ]; 
    }
}
