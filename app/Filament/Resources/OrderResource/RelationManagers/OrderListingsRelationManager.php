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
                Select::make('listing_id') -> relationship('listing', titleAttribute:'serial_number') -> live() -> searchable() 
                -> getSearchResultsUsing(fn (string $search): array => Listing::where('serial_number', '=', "{$search}")->pluck('name', 'id')->toArray())
                -> required(),
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
                            // dd(Listing::find($get('listing.name')), $get('detail.size'));
                            $result = Detail::query() 
                                -> where('listing_id', $get('listing_id')) 
                                -> where('size', $detail -> size) -> pluck('color', 'id') -> toArray();
                            // dd($detail, $result);
                            return $result;
                        }) -> required(),
                TextInput::make('quantity') -> numeric() -> required() -> rules([
                    fn (Get $get) : Closure => function(string $attribute, $value, Closure $fail) use ($get){
                        $detail = Detail::find($get('detail.color'));
                        if($value <= 0)
                            $fail('Enter number more than 0');
                        if($detail -> inventory < $value)
                            $fail('Not enough inventory');
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
                            // dd($data);
                            return $data;
                        }),
            ])
            ->actions([
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
