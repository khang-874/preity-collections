<?php

namespace App\Filament\Resources\ListingResource\Pages;

use App\Filament\Resources\ListingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateListing extends CreateRecord
{
    protected static string $resource = ListingResource::class;
    // protected function handleRecordCreation(array $data): Model
    // {
    //     dd($data);
    //     return $data;
    // }
}
