<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HigherOrderWhenProxy;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','vendor_id', 'weight', 'init_price', 'subsection_id'];
    protected $casts = [
        'images' => 'array',
        'is_clearance' => 'boolean',
    ];
    
    protected $with = ['details'];
    public function details(): HasMany
    {
        return $this->hasMany(Detail::class);
    } 

    public function promotion(): HasOne
    {
        return $this -> hasOne(Promotion::class);
    }
    public function vendor() : BelongsTo
    {
        return $this -> belongsTo(Vendor::class);
    }
    public function subsection(): BelongsTo{
        return $this -> belongsTo(Subsection::class);
    }
    public function orderListings() : HasMany{
        return $this -> hasMany(OrderListing::class);
    }
    static function roundToNearest($x):float{
        return round($x / 5) * 5;
    }
    static function sellingPrice(float $price, float $sale_percentage) : float{
        return Listing::roundToNearest(Listing::roundToNearest(($price / 55) * 2.5) * ((100 - $sale_percentage) / 100))- 0.01; 
    }
    public function getBasePriceAttribute(){
        return Listing::roundToNearest($this -> init_price / 55 * 2.5) - 0.01;
    } 
    public function getSellingPriceAttribute(){
        return Listing::sellingPrice($this -> init_price, $this -> sale_percentage);
    }
    public function getAvailableAttribute(){
        $total = 0;
        foreach($this -> details as $detail){
            $total += $detail -> inventory;
        }
        return $total != 0;
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
        return Listing::priceCode($this -> init_price);
    }
    public function getLinkAttribute(){
        return  '/listings/' . $this -> id;
    }
    public function getInventoryAttribute(){
        $inventory = 0;
        foreach($this -> details as $detail){
            $inventory += $detail -> inventory;
        }
        return $inventory;
    }
    public function getDisplayImageAt($index){
        if($index >= count($this -> images))
            return '';
        if(Storage::exists($this -> images[$index]))
            return Storage::url($this -> images[$index]);
        return $this -> images[$index];
    }
    public function scopeSize($query, $size){
        //Filter based on size 
        $query -> join('details', 'listings.id', '=', 'details.listing_id');
        if($size != null){
            // dd($query -> joins);
            $query -> whereIn('details.size', $size);
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
            // dd($query -> joins);
            $query -> whereIn('details.color', $color);
        }
    }
    public function scopeAllColor($query){
        $query -> join('details', 'listings.id', '=', 'details.listing_id')
                -> select('details.color')
                -> distinct();
    }
    
    public function scopeClearance($query){
        $query -> where('listings.is_clearance', '=', true);
    }
    public function scopeAvailable($query){
        $query  -> select(DB::raw('sum(details.inventory) as inventory, listings.*'))
                -> groupBy('listings.id')
                -> having('inventory', '>', '0');
    }
    public function scopeFilter($query, array $filters){
        if($filters['category'] ?? false){
            $query  -> join('subsections', 'listings.subsection_id', '=', 'subsections.id')
                    -> join('sections', 'subsections.section_id', '=', 'sections.id')
                    -> join('categories', 'sections.category_id', '=', 'categories.id')
                    -> where('categories.id', '=', request('category'));
        }
        if($filters['section'] ?? false){
            $query  -> join('subsections', 'listings.subsection_id', '=', 'subsections.id')
                    -> join('sections', 'subsections.section_id', '=', 'sections.id')
                    -> where('sections.id', '=', request('section'));
        }
        if($filters['subsection'] ?? false){
            $query -> join('subsections', 'listings.subsection_id', '=', 'subsections.id')            
            -> where('subsections.id', '=', request('subsection'));
        }
        if($filters['search'] ?? false){
            $query -> where('listings.name', 'like', '%' . request('search') . '%');
        }

        if($filters['order'] ?? false){
            $order = request('order');
            match($order){
                'newtoold' => $query -> orderBy('listings.created_at', 'DESC'),
                'oldtonew' => $query -> orderBy('listings.created_at', 'ASC'),
                'hightolow' => $query -> orderBy('listings.init_price', 'DESC'),
                'lowtohigh' => $query -> orderBy('listings.init_price', 'ASC'),
                'highestdiscount' => $query -> orderBy('listings.sale_percentage', 'DESC'),
            };
        }
        
    }
}
