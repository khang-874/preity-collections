<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['imageURL', 'listing_id'];

    public function listing(): BelongsTo{
        return $this->belongsTo(Listing::class);
    }
}
