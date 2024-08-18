<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
use App\Filament\Resources\SectionResource\RelationManagers;
use App\Filament\Resources\SectionResource\RelationManagers\SubsectionsRelationManager;
use App\Filament\Resources\SectionResource\Widgets\CostOfGoodsSoldChart;
use App\Filament\Resources\SectionResource\Widgets\InventoryOverview;
use App\Filament\Resources\SectionResource\Widgets\RevenueChart;
use App\Filament\Resources\SectionResource\Widgets\SoldOverview;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('category_id') -> relationship(name:'category', titleAttribute:'name') -> required(),
                TextInput::make('name') -> required(),
                FileUpload::make('images') 
                            -> image() 
                            -> multiple()
                            -> disk('public')
                            -> directory('photos')
                            -> visibility('public')
                            -> downloadable()
                            -> columnSpanFull(),

                TextInput::make('serial_number') -> disabled(),

            ]) -> columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name'),
                TextColumn::make('serial_number'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            SubsectionsRelationManager::class
        ];
    }

    public static function getWidgets(): array
    {
        return [
            RevenueChart::class,
            CostOfGoodsSoldChart::class,
            InventoryOverview::class,
            SoldOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
