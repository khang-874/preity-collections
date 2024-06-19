<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ListingResource\Pages;
use App\Filament\Resources\ListingResource\RelationManagers;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ListingResource extends Resource
{
    protected static ?string $model = Listing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Product name')->required(),
                TextInput::make('initPrice') 
                    -> label('Price(INR)') 
                    -> numeric() 
                    -> live(onBlur:true) 
                    -> afterStateUpdated(function($state, Set $set){
                        $set('sellingPrice', Listing::sellingPrice($state));
                        $set('priceCode', Listing::priceCode($state));
                    }) 
                    -> afterStateHydrated(function($state, Set $set){
                        if(!$state){
                            return;
                        }
                        $set('sellingPrice', Listing::sellingPrice($state));
                        $set('priceCode', Listing::priceCode($state)); 
                    })
                    -> required(),
                TextInput::make('sellingPrice') 
                        -> label('Selling price') 
                        -> disabled(),
                TextInput::make('priceCode') -> disabled(),
                TextInput::make('weight') -> label('Weight (KG)') -> numeric() -> default(1.0),
                TextInput::make('inventory') -> numeric() -> default(1) -> disabled(),
                Select::make('vendor_id') -> relationship(name:'vendor', titleAttribute:'name') -> required(),
                // Select::make('category_id') 
                //         -> label('Category') 
                //         -> options(Category::query() -> pluck('name', 'id')) 
                //         -> required()
                //         -> live(),
                // Select::make('section_id')  
                //         -> label('Section')    
                //         -> options(function(Get $get){
                //            return Section::query() -> where('category_id', $get('category_id')) -> pluck('name', 'id'); 
                //         }) 
                //         -> required(),
                Select::make('subsection_id') -> relationship(name:'subsection', titleAttribute:'name') -> required(),
                Textarea::make('description') -> autosize() -> columnSpanFull(),
                FileUpload::make('images') -> multiple() -> image() -> columnSpanFull(),
                Repeater::make('details') 
                            -> relationship('details')
                            -> schema([
                                TextInput::make('size'),
                                TextInput::make('color'),
                                TextInput::make('inventory') 
                                    -> numeric() 
                                    -> default(1)
                                    -> live(onBlur:true)
                                    -> afterStateUpdated(function(Get $get, Set $set){
                                        $details = $get('../../details');
                                        $inventory = 0;
                                        foreach($details as $item){
                                            $inventory += $item['inventory'];
                                        }
                                        $set('../../inventory', $inventory);
                                    }),
                                TextInput::make('sold') -> numeric() -> default(0),
                            ]) 
                            -> columns(4) 
                            -> grid(2) 
                            -> columnSpanFull() 
                            -> collapsible() 
                            -> cloneable()
                            -> live(onBlur:true)
                            -> afterStateUpdated(function(Set $set, array $state){
                                $inventory = 0;
                                foreach($state as $item){
                                    $inventory += $item['inventory'];
                                }
                                
                                $set('inventory', $inventory);
                            }),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListListings::route('/'),
            'create' => Pages\CreateListing::route('/create'),
            'edit' => Pages\EditListing::route('/{record}/edit'),
        ];
    }
}
