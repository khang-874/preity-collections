<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Detail extends Model
{
    use HasFactory;
    
    protected $fillable = ['inventory', 'sold', 'color', 'size', 'weight', 'listing_id'];

    public function images() : HasMany{
        return $this->hasMany(Image::class);
    }
    public function listing(): BelongsTo{
        return $this -> belongsTo(Listing::class);
    } 
    
}
