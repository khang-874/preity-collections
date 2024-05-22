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
    
    protected $fillable = ['inventory', 'sold'];

    public function images() : HasMany{
        return $this->hasMany(Image::class);
    }
    public function listing(): BelongsTo{
        return $this -> belongsTo(Listing::class);
    }
    
    public function characteristics(): BelongsToMany{
        return $this -> belongsToMany(Characteristic::class, 'characteristics_value', 'detail_id', 'characteristic_id');
    }
}
