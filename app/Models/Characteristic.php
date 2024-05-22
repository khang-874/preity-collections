<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Characteristic extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function detail(): BelongsTo{
        return $this -> belongsTo(Detail::class);
    }
    public function characteristicsValues(): HasMany{
        return $this -> hasMany(CharacteristicValue::class);
    }
}
