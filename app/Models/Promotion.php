<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotion extends Model
{
    use HasFactory;

    protected $with = ['listing'];

    public function listing() : BelongsTo
    {
        return  $this -> belongsTo(Listing::class); 
    }
}
