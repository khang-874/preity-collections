<?php

namespace App\Filament\Resources\ListingResource\Pages;

use App\Filament\Resources\ListingResource;
use App\Models\Listing;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditListing extends EditRecord
{
    protected static string $resource = ListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('View listing')
            -> url(fn(Listing $listing) : string => '/listings/' . $listing -> id)
            -> openUrlInNewTab(),
            Actions\Action::make('print tag')
                -> icon('heroicon-m-printer')
                -> url(fn(Listing $record) : string => route('print', ['listingId' => $record->id]))
                -> openUrlInNewTab(),
            Actions\DeleteAction::make(),
            
        ];
    }
}
