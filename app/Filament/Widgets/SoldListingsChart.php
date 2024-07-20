<?php

namespace App\Filament\Widgets;

use App\Models\Detail;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class SoldListingsChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue each month';
    public ?string $filter = 'total';
    protected function getData(): array
    {
        $activeFilter = $this -> filter;
        $query = null;
        if($activeFilter === 'total'){
            $query = Order::query() -> where('payment_type', '!=', 'pending');
        }else{
            $query = Order::query() -> where('payment_type', '=', $activeFilter);
        }
        $data = Trend::query($query)
        -> between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        -> perMonth()
        -> sum('amount_paid');
 
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

    protected function getFilters(): ?array
    {
       return [
            'credit' => 'Credit',
            'cash' => 'Cash',
            'debit' => 'Debit',
            'total' => 'Total',
       ]; 
    }
}
