<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Detail;
use App\Models\Listing;
use App\Models\OrderListing;
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
                Select::make('listing_id') -> relationship('listing', 'name') -> live() -> required(),
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
                TextInput::make('quantity') -> numeric() -> required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('listing.name') -> label('Listing name'),
                Tables\Columns\TextColumn::make('detail.size') -> label('Size'),
                TextColumn::make('detail.color') -> label('color'),
                TextColumn::make('quantity'),
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
