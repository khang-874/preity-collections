<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('print receipt')
                -> icon('heroicon-m-printer')
                -> url(fn(Order $record) : string => route('printReceipt', ['orderId' => $record->id]))
                -> openUrlInNewTab(),
        ];
    }
}
