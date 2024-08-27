<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'Orders';

    protected static ?string $modelLabel = 'Sale';
    protected static ?string $pluralModelLabel = 'Sales';
    protected static ?string $pluralLabel = 'Sales';
    protected static ?string $title = "Sales";

    public function form(Form $form): Form
    {
        return $form
            ->schema([ 
                Hidden::make('payment_type') -> default('pending'),
                Hidden::make('amount_paid') -> default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('created_at')
            ->columns([
                Tables\Columns\TextColumn::make('created_at') -> dateTime(),
                TextColumn::make('total'),
                TextColumn::make('amount_paid'),
                TextColumn::make('remaining'),
                TextColumn::make('payment_type')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                        ->successRedirectUrl(function(Order $record) : string{
                            return '/admin/orders/' . $record -> id . '/edit';
                        }),
            ])
            ->actions([
                Tables\Actions\Action::make('View')
                    -> icon('heroicon-o-eye')
                    -> url(function(Order $record) : string{
                        return '/admin/orders/' . $record -> id . '/edit';
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
