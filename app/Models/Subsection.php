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

    public function section() : BelongsTo{
        return $this->belongsTo(Section::class);
    } 
    public function listings() : HasMany{
        return $this -> hasMany(Listing::class);
    }
}
