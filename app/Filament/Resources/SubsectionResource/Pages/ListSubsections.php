<?php

namespace App\Filament\Resources\SubsectionResource\Pages;

use App\Filament\Resources\SubsectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubsections extends ListRecords
{
    protected static string $resource = SubsectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
