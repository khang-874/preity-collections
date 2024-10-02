<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subsection extends Model
{
    use HasFactory;
    protected $fillable=['name', 'section_id'];
    protected $casts = [
        'images' => 'array',
    ];
 
    public function section() : BelongsTo{
        return $this->belongsTo(Section::class);
    } 
    public function listings() : HasMany{
        return $this -> hasMany(Listing::class);
    }

    public function availableListings(){
        $listings = $this -> listings;
        $result = collect();
        foreach($listings as $listing){
            if($listing -> available){
                $result -> add($listing);
            }
        }
        return $result;
    }

    public function randomAvailableListings(int $number){
        $listing = $this -> availableListings();
        if($listing -> count() == 0)
            return null;
        return $listing -> random(min($number, $listing -> count()));
    }

    public function randomListing(): ?Listing{
       $randomListing = $this -> randomAvailableListings(1);
		if($randomListing == null)
			return null;
        return $randomListing -> get(0); 
    }
}
