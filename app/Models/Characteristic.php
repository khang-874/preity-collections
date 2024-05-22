<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Characteristic extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function detail(): BelongsToMany{
        return $this -> belongsToMany(Detail::class, 'characteristics_value', 'characteristic_id', 'detail_id');
    }
    public function characteristicsValues(): HasMany{
        return $this -> hasMany(CharacteristicValue::class);
    }
}
