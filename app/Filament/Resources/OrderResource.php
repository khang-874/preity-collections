<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\ListingsRelationManager;
use App\Filament\Resources\OrderResource\RelationManagers\OrderListingsRelationManager;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('phone_number') -> relationship(name:'customer', titleAttribute:'phone_number') -> searchable() -> required() -> disabled(),
                // Repeater::make('listings') -> relationship('listings')
                //             -> schema([
                //                 // Select::make('name') -> relationship(name:'listings', titleAttribute:'name') -> searchable() -> required(),
                //             ])
                TextInput::make('amount_paid'),
                Select::make('payment_type') 
                        -> options([
                            'pending' => 'Pending',
                            'credit' => 'Credit',
                            'debit' => 'Debit',
                            'cash' => 'Cash',
                        ]),
                TextInput::make('subtotal') -> disabled(),
                TextInput::make('total') -> disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('customer.first_name') -> label("Customer's name"),
                TextColumn::make('created_at') -> date(),
                TextColumn::make('payment_type'),
                TextColumn::make('subtotal'),
                TextColumn::make('total') -> numeric(),
            ])
            ->filters([
                //
                // Filter::make('pending') -> query(fn (Builder $query) : Builder => $query -> where('paymentType', 'pending')),
                SelectFilter::make('payment_type') 
                        -> options([
                            'pending' => 'Pending',
                            'credit' => 'Credit',
                            'debit' => 'Debit',
                            'cash' => 'Cash',
                        ])

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
            // ListingsRelationManager::class
            OrderListingsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
