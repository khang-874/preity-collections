<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subsection extends Model
{
    use HasFactory;
    public function section() : BelongsTo{
        return $this->belongsTo(Section::class);
    } 
    public function listings() : BelongsToMany{
        return $this->belongsToMany(Listing::class, 'listings_subsections', 'section_id', 'listing_id');
    }
}
