<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'category_id'];

    public function subsections(): HasMany{
        return $this->hasMany(Subsection::class);
    }
    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }
}
