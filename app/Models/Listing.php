<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
