<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\HigherOrderWhenProxy;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','vendor_id', 'weight', 'initPrice', 'subsection_id'];
    protected $casts = [
        'images' => 'array',
    ];
    
    protected $with = ['details'];
    public function details(): HasMany
    {
        return $this->hasMany(Detail::class);
    } 

    public function vendor() : BelongsTo
    {
        return $this -> belongsTo(Vendor::class);
    }
    public function subsection(): BelongsTo{
        return $this -> belongsTo(Subsection::class);
    }
    public function orders() : BelongsToMany{
        return $this -> belongsToMany(Order::class, 'orders_listings', 'listing_id', 'order_id') -> withTimestamps() -> withPivot('detail_id');
    }
    static function roundToNearest($x):float{
        return round($x / 5) * 5;
    }
    static function sellingPrice(float $price) : float{
        return Listing::roundToNearest(($price / 55) * 2.5) - 0.01; 
    }
    
    public function getSellingPriceAttribute(){
        return Listing::sellingPrice($this -> initPrice);
    }
    public function getAvailableAttribute(){
        $total = 0;
        foreach($this -> details as $detail){
            $total += $detail -> inventory;
        }
        if($total == 0)
            return false;
        return true;
    }
    public function getProductIdAttribute(){
       $words = explode(' ', $this -> subsection -> name); 
       $acronym = "";
       foreach($words as $word){
            $acronym .= mb_substr($word, 0, 1);
       }
       $acronym .= $this -> id;
       return $acronym;
    } 
    static function priceCode(float $initPrice) : string{
        $price = round($initPrice / 5);
        $code = [
            0 => 'C',
            1 => 'M',
            2 => 'N',
            3 => 'O',
            4 => 'R',
            5 => 'S',
            6 => 'T',
            7 => 'W',
            8 => 'X',
            9 => 'Y',
        ];
        $productCode = '';
        while($price > 0){
            $productCode = $code[$price % 10] . $productCode;
            $price = intdiv($price, 10);
        }
        return $productCode;
    }
    public function getProductPriceCodeAttribute(){
        return Listing::priceCode($this -> initPrice);
    }
    public function getStockAttribute(){
        $stock = 0;
        foreach($this -> details as $detail){
            $stock += $detail -> inventory;
        }
        return $stock;
    }
    public function scopeSize($query, $size){
       //Filter based on size 
        if($size != null){
            $query -> join('details', 'listings.id', '=', 'details.listing_id')
                    -> where('details.size', '=', $size);
        }
    }
    public function scopeAllSize($query){
        $query -> join('details', 'listings.id', '=', 'details.listing_id')
                -> select('details.size')
                -> distinct();
    }
    public function scopeColor($query, $color){
       //Filter based on color
        if($color != null){
            $query -> join('details', 'listings.id', '=', 'details.listing_id')
                    -> where('details.color', '=', $color);
        }
    }
    public function scopeAllColor($query){
        $query -> join('details', 'listings.id', '=', 'details.listing_id')
                -> select('details.color')
                -> distinct();
    }
    
    public function scopeFilter($query, array $filters){
        if($filters['category'] ?? false){
            $query  -> join('subsections', 'listings.subsection_id', '=', 'subsections.id')
                    -> join('sections', 'subsections.section_id', '=', 'sections.id')
                    -> join('categories', 'sections.category_id', '=', 'categories.id')
                    -> select('listings.*')
                    -> where('categories.id', '=', request('category'));
        }
        if($filters['section'] ?? false){
            $query  -> join('subsections', 'listings.subsection_id', '=', 'subsections.id')
                    -> join('sections', 'subsections.section_id', '=', 'sections.id')
                    -> select('listings.*')
                    -> where('sections.id', '=', request('section'));
        }
        if($filters['subsection'] ?? false){
            $query -> join('subsections', 'listings.subsection_id', '=', 'subsections.id')            
            -> select('listings.*')
            -> where('subsections.id', '=', request('subsection'));
        }
        if($filters['search'] ?? false){
            $query -> where('listings.name', 'like', '%' . request('search') . '%');
        }
    }
}
