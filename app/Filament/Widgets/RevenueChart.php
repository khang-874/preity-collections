<?php

namespace App\Filament\Widgets;

use App\Models\Detail;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue';
    public ?string $filter = 'total';
    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
        $activeFilter = $this -> filter;
        $query = null;
        if($activeFilter == 'month'){
            $query = Order::query() -> where('payment_type', '!=', 'pending');
            $data = Trend::query($query)
            -> between(
                start: now()->startOfMonth(),
                end: now(),
            ) -> perDay() -> sum('amount_paid'); 
        }else{
            if($activeFilter == 'total'){
                    $query = Order::query() -> where('payment_type', '!=', 'pending');
            }else{
                $query = Order::query() -> where('payment_type', '=', $activeFilter); 
            } 
            $data = Trend::query($query)
                -> between(
                    start: now()->startOfYear(),
                    end: now(),
                ) -> perMonth() -> sum('amount_paid');
        }
        return [
                'datasets' => [
                    [
                        'label' => 'Revenue',
                        'data' => $data -> map(fn (TrendValue $value) => $value -> aggregate),
                        'backgroundColor' => '#F6E96B',
                        'borderColor' => '#387F39',
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
        return 'line';
    }

    protected function getFilters(): ?array
    {
       return [
            'credit' => 'Credit',
            'cash' => 'Cash',
            'debit' => 'Debit',
            'total' => 'Total',
            'month' => 'This month'
       ]; 
    }
}

