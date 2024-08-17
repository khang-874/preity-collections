<?php

namespace App\Filament\Widgets;

use App\Models\Detail;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RevenueChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Revenue';
    public ?string $filter = 'total';
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 1;
    protected static string $color = 'success';

    protected function getData(): array
    {
        $startDate = $this -> filters['startDate'] ?? now() -> startOfYear();
        $endDate = $this -> filters['endDate'] ?? now(); 
        if($startDate != now() -> startOfYear()){
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
        } 
        if(gettype($endDate) == 'string'){
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate);
        }

        $activeFilter = $this -> filter;
        $query = null;
        
        if($activeFilter == 'total'){
                $query = Order::query() -> where('payment_type', '!=', 'pending');
        }else{
            $query = Order::query() -> where('payment_type', '=', $activeFilter); 
        } 
        $data = Trend::query($query)
            -> between(
                start: $startDate,
                end: $endDate,
            ) -> perMonth() -> sum('amount_paid');
        foreach($data as $key => $value){
            if($key != 0)
                $value -> aggregate += $data[$key - 1] -> aggregate;
        }
        return [
                'datasets' => [
                    [
                        'label' => 'Revenue ($CAD)',
                        'data' => $data -> map(fn (TrendValue $value) => $value -> aggregate), 
                        'maxBarThickness' => 40,
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
            'total' => 'Total',
       ]; 
    }
}

