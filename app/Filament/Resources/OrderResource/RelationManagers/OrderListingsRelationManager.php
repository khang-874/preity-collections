<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Detail;
use App\Models\Listing;
use App\Models\OrderListing;
use Closure;
use Filament\Forms;
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
use Illuminate\Support\Collection;

class OrderListingsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderListings';
    protected static ?string $title = 'Listings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([ 
                Select::make('listing_id') -> relationship('listing', 'name') -> searchable(['serial_number', 'name'])
                        -> live() -> required(),
                Select::make('detail.size')  
                        -> options(function(Get $get) : array {
                            if(!$get('listing_id'))
                                return [];
                            return array_unique(Detail::query() -> where('listing_id', $get('listing_id')) -> pluck('size', 'id') -> toArray());
                        })
                        -> live() -> required(),
                Select::make('detail.color')  -> options(function(Get $get) : array{
                            if(!$get('listing_id') || !$get('detail.size'))
                                return [];
                            $detail = Detail::find($get('detail.size'));
                            $result = Detail::query() 
                                -> where('listing_id', $get('listing_id')) 
                                -> where('size', $detail -> size) -> pluck('color', 'id') -> toArray();
                            return $result;
                        }) -> required(),
                TextInput::make('quantity') -> numeric() -> required() -> rules([
                    fn (Get $get, OrderListing $orderListing) : Closure => function(string $attribute,  $value, Closure $fail) use ($get, $orderListing){
                        $detail = Detail::find($get('detail.color'));
                        $oldValue = $orderListing -> quantity;
                        if($value <= 0)
                            $fail('Enter number more than 0');
                        if($detail -> inventory + $oldValue < $value)
                            $fail('Not enough inventory, maximum inventory is: ' . ($detail -> inventory + $oldValue));
                    }
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make("listing.serial_number") -> label('Serial number'),
                Tables\Columns\TextColumn::make('listing.name') -> label('Name'),
                Tables\Columns\TextColumn::make('detail.size') -> label('Size'),
                TextColumn::make('detail.color') -> label('color'),
                TextColumn::make('quantity'),
                TextColumn::make('listing.sellingPrice') -> label('Selling price'),
                TextColumn::make('subtotal')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                        -> mutateFormDataUsing(function(array $data){
                            $detailId = $data['detail']['color'];
                            unset($data['detail']);
                            $data['detail_id'] = $detailId;
                            return $data;
                        }) -> label('Add listing'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                        -> mutateRecordDataUsing(function(array $data){
                            unset($data['order_id']);
                            unset($data['created_at']);
                            unset($data['updated_at']);
                            $data['detail']['color'] = $data['detail_id'];
                            $data['detail']['size'] = $data['detail_id'];
                            return $data;
                        })
                        -> mutateFormDataUsing(function(array $data){
                            $detailId = $data['detail']['color'];
                            unset($data['detail']);
                            $data['detail_id'] = $detailId;
                            return $data;
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
