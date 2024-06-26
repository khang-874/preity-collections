<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubsectionResource\Pages;
use App\Filament\Resources\SubsectionResource\RelationManagers;
use App\Filament\Resources\SubsectionResource\RelationManagers\ListingsRelationManager;
use App\Models\Subsection;
use Faker\Guesser\Name;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubsectionResource extends Resource
{
    protected static ?string $model = Subsection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('section_id') -> relationship(name:'section', titleAttribute:'name') -> required(),
                TextInput::make('name') -> required(),
            ]) -> columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name'),
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
            ListingsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubsections::route('/'),
            'create' => Pages\CreateSubsection::route('/create'),
            'edit' => Pages\EditSubsection::route('/{record}/edit'),
        ];
    }
}
