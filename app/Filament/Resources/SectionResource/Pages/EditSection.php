<?php

namespace App\Filament\Resources\SectionResource\Pages;

use App\Filament\Resources\SectionResource;
use App\Filament\Resources\SectionResource\Widgets\CostOfGoodsSoldChart;
use App\Filament\Resources\SectionResource\Widgets\InventoryOverview;
use App\Filament\Resources\SectionResource\Widgets\RevenueChart;
use App\Filament\Resources\SectionResource\Widgets\SoldOverview;
use App\Models\Section;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSection extends EditRecord
{
    protected static string $resource = SectionResource::class;
    public ?Section $section = null;

    protected function getHeaderWidgets(): array
    {
        return[
            RevenueChart::class,
            CostOfGoodsSoldChart::class,
            InventoryOverview::class,
            SoldOverview::class,
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
