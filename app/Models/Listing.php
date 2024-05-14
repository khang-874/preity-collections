<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\HigherOrderWhenProxy;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','brand','vendor', 'initPrice'];

    public function details(): HasMany
    {
        return $this->hasMany(Detail::class);
    }
    public function subsections(): BelongsToMany{
        return $this -> belongsToMany(Subsection::class,'listings_subsections', 'listing_id', 'subsection_id');
    }
    public function getSellingPriceAttribute(){
        return ($this -> initPrice / 5) * 2.5;
    }
    public function scopeFilter($query, array $filters){
        if($filters['category'] ?? false){
            $query -> join('listings_subsections', 'listings.id', '=', 'listings_subsections.listing_id')
                    -> join('subsections', 'listings_subsections.subsection_id', '=', 'subsections.id')
                    -> join('sections', 'subsections.section_id', '=', 'sections.id')
                    -> join('categories', 'sections.category_id', '=', 'categories.id')
                    -> select('listings.*')
                    -> where('categories.id', '=', request('category'));
        }
        if($filters['section'] ?? false){
            $query -> join('listings_subsections', 'listings.id', '=','listings_subsections.listing_id')
                    -> join('subsections', 'listings_subsections.subsection_id', '=', 'subsections.id')
                    -> join('sections', 'subsections.section_id', '=', 'sections.id')
                    -> select('listings.*')
                    -> where('sections.id', '=', request('section'));
        }
        if($filters['subsection'] ?? false){
            $query -> join('listings_subsections', 'listings.id', '=', 'listings_subsections.listing_id')            
            -> select('listings.*')
            -> where('listings_subsections.subsection_id', '=', request('subsection'));
        }
        if($filters['search'] ?? false){
            $query -> join('listings_subsections', 'listings.id', '=', 'listings_subsections.listing_id')
                    -> join('subsections', 'listings_subsections.subsection_id', '=', 'subsections.id')
                    -> join('sections', 'subsections.section_id', '=', 'sections.id')
                    -> join('categories', 'sections.category_id', '=', 'categories.id')
                    -> select('listings.*')
                    -> where('listings.name', 'like', '%' . request('search') . '%')
                    -> orWhere('listings.description', 'like', '%' . request('search') . '%')
                    -> orWhere('subsections.name', 'like', '%' . request('search'). '%')
                    -> orWhere('sections.name' , 'like', '%' . request('search') . '%')
                    -> orWhere('categories.name', 'like', '%' . request('search') . '%');
        }
    }
}
