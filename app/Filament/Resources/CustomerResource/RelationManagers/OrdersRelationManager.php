<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use App\Models\Detail;
use App\Models\Listing;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
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
                Repeater::make('orderListings')
                        -> label('Listings')
                        -> relationship('orderListings')
                        -> schema([
                            Select::make('listing_id') -> relationship('listing', 'name') 
                                -> searchable(['serial_number', 'name'])
                                -> getSearchResultsUsing(fn (string $search) : array => Listing::where('serial_number', '=', $search)
                                                        -> orWhere('name', 'like', "%{$search}%")
                                                        -> pluck('name', 'id') -> toArray()) 
                                -> getOptionLabelUsing(fn ($value): ?string => Listing::find($value)?->name)
                                -> live(),
                            Select::make('size') -> options(function (Get $get){
                                if(!$get('listing_id'))
                                    return [];
                                $sizes = Detail::query() -> select('id', 'size')
                                                -> where('listing_id', '=', $get('listing_id')) 
                                                -> pluck('size', 'id') -> unique();
                                
                                return $sizes;
                            }) -> live(),

                            Select::make('color') -> options(function (Get $get){
                                if(!$get('size'))
                                    return [];
                                $size = Detail::query() -> where('id', $get('size')) -> select('size') -> get()[0] -> size;
                                $colors = Detail::query() -> where('listing_id', '=', $get('listing_id'))
                                                        -> where('size', '=', $size) -> pluck('color', 'id');
                                return $colors;
                            }),
                            TextInput::make('quantity') -> numeric() -> required()
                        ]) -> grid(3) 
                        -> columnSpanFull()
                        -> addActionLabel('Add listing')
                        -> mutateRelationshipDataBeforeCreateUsing(function (array $data) : array{
                            $detail_id = $data['color'];
                            unset($data['color']);
                            unset($data['size']);
                            $data['detail_id'] = $detail_id;
                            // dd($data);
                            return $data;
                        })

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
                Tables\Actions\Action::make('View and edit')
                    -> icon('heroicon-o-eye')
                    -> url(function(Order $record) : string{
                        return '/admin/orders/' . $record -> id . '/edit';
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
