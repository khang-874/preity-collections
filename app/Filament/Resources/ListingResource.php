<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ListingResource\Pages;
use App\Filament\Resources\ListingResource\RelationManagers;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Section;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint\Operators\EqualsOperator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class ListingResource extends Resource
{
    protected static ?string $model = Listing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Product name')->required(),
                TextInput::make('init_price') 
                    -> label('Price(INR)') 
                    -> numeric() 
                    -> live(onBlur:true) 
                    -> required(), 
                TextInput::make('sale_percentage') -> numeric() -> default(0) -> required() -> live(onBlur:true), 
                Checkbox::make('is_clearance') -> inline() -> label('On clearance'),
                Placeholder::make('sellingPrice') 
                        -> content(function(Get $get) : string{
                            return Listing::sellingPrice($get('init_price') == null ? 0 : $get('init_price'), $get('sale_percentage') == null ? 0 : $get('sale_percentage'));
                        }),
                Placeholder::make('priceCode')
                        -> content(function(Get $get) : string{
                            return Listing::priceCode($get('init_price') == null ? 0 : $get('init_price'));
                        }),
                TextInput::make('serial_number') -> hidden(fn(string $operation) : bool => $operation === 'create') -> disabled(),
                TextInput::make('weight') -> label('Weight (KG)') -> numeric() -> default(1.0),
                TextInput::make('inventory') -> numeric() -> default(1) -> disabled(),
                Select::make('vendor_id') -> relationship(name:'vendor', titleAttribute:'name') -> required(), 
                Select::make('subsection_id') -> relationship(name:'subsection', titleAttribute:'name') -> required(),
                Textarea::make('description') -> autosize() -> columnSpanFull(),
                FileUpload::make('images') 
                            -> image() 
                            -> multiple()
                            -> disk('public')
                            -> directory('photos')
                            -> visibility('public')
                            -> downloadable()
                            -> columnSpanFull(),
                Repeater::make('details') 
                            -> relationship('details')
                            -> schema([
                                TextInput::make('size') -> required(),
                                TextInput::make('color') -> required(),
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
                                    })
                                    -> afterStateHydrated(function(Get $get, Set $set){
                                        $details = $get('../../details');
                                        $inventory = 0;
                                        foreach($details as $item){
                                            $inventory += $item['inventory'];
                                        }
                                        $set('../../inventory', $inventory);
                                    }),
                                TextInput::make('sold') -> numeric() -> default(0),
                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('print tag')
                                        -> disabled(function(?Model $record){
                                            if(!$record)
                                                return true;
                                            return false;
                                        }) 
                                        -> url(fn(?Model $record) : string => route('print', ['detailId' => $record -> id ?? '' ]))
                                        -> openUrlInNewTab(),
                                ])
                            ]) 
                            -> deleteAction(fn(Action $action) => $action -> requiresConfirmation(),)
                            -> columns(4) 
                            -> grid(2) 
                            -> columnSpanFull() 
                            -> collapsible() 
                            -> cloneable()
                            -> live(onBlur:true)
                            -> afterStateUpdated(function(Set $set, array $state){
                                $inventory = 0;
                                foreach($state as $detail){
                                    $inventory += $detail['inventory'];
                                }
                                
                                $set('inventory', $inventory);
                            }),
                    
            ]) -> columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('serial_number') -> searchable(),
                TextColumn::make('name') -> label('Listing name') -> searchable(),
                TextColumn::make('vendor.name'),
                TextColumn::make('sellingPrice'),
                TextColumn::make('details_sum_sold') -> label('Sold') -> sum('details', 'sold') -> sortable(),
                TextColumn::make('details_sum_inventory') -> label('Inventory') -> sum('details', 'inventory') -> sortable(),
                TextColumn::make('subsection.section.name') -> searchable()
            ])
            ->filters([
                //
                Filter::make('on_clearance') -> query(function(Builder $query) : Builder {
                    $query -> where('is_clearance' , true);
                    return $query;
                }),
                Filter::make('on_sale') -> query(fn(Builder $query) : Builder => $query -> where('sale_percentage', '>' ,'0')),
                Filter::make('sell_out') -> query(function(Builder $query) : Builder{
                    $tmpQuery = clone $query;
                    $queryData = $tmpQuery -> join('details', 'details.listing_id', '=', 'listings.id')
                                        -> selectRAW('sum(details.inventory) as inventory, listings.*')
                                        -> groupBy('listings.id')
                                        -> having('inventory', '=', '0')
                                        -> get(); 
                    $query -> whereIn('id', $queryData -> pluck('id') -> toArray());
                    return $query;
                }), 
                Filter::make('on_inventory') -> query(function(Builder $query) : Builder{
                    $tmpQuery = clone $query;
                    $queryData = $tmpQuery -> join('details', 'details.listing_id', '=', 'listings.id')
                                        -> selectRAW('sum(details.inventory) as inventory, listings.*')
                                        -> groupBy('listings.id')
                                        -> having('inventory', '>', '0')
                                        -> get(); 
                    $query -> whereIn('id', $queryData -> pluck('id') -> toArray());
                    return $query;
                }),
                Filter::make('section')
                    -> form([
                        Select::make('section'),
                    ])
                    -> query(function (Builder $query, array $data) : Builder{
                        return $query -> when(
                            $data['section'],
                            fn (Builder $query, string $name) : Builder => $query -> where('name', '=', $name)
                        );
                    })
            ])
            ->actions([
                Tables\Actions\Action::make('View')
                    -> icon('heroicon-m-eye')
                    -> url(fn(Listing $listing) : string => '/listings/' . $listing -> id)
                    -> openUrlInNewTab(),
                Tables\Actions\Action::make('print tag')
                    -> icon('heroicon-m-printer')
                    -> url(fn(Listing $record) : string => route('print', ['listingId' => $record->id]))
                    -> openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
