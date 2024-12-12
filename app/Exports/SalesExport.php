<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SalesExport implements FromQuery, ShouldAutoSize, WithHeadings, WithColumnFormatting
{
    public function query(){
        return Order::query() -> join('customers', 'customers.id', '=', 'orders.customer_id')
                            -> select('customers.first_name', 'customers.last_name', 'payment_type', 'amount_paid', 'address', 'orders.updated_at');
    } 

    public function map($order){
        return [
            $order -> customer -> first_name,
            $order -> customer -> last_name,
            $order -> payment_type,
            $order -> amount_paid,
            $order -> address,
            Date::dateTimeToExcel($order -> updated_at),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DATETIME
        ];
    }
    public function headings(): array{
        return [
            'First name',
            'Last name',
            'Payment type',
            'Amount paid',
            'Shipping address',
            'Date'
        ];
    }
}
