<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['imageURL', 'detail_id'];

    public function detail(): BelongsTo{
        return $this->belongsTo(Detail::class);
    }
}
