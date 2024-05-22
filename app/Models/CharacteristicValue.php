<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CharacteristicValue extends Model
{
    use HasFactory;
    public function characteristic() : BelongsTo{
        return $this -> belongsTo(Characteristic::class);
    }
}
