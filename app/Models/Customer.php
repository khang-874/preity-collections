<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    protected $with = ['orders'];
    protected $fillable = ['firstName', 'lastName', 'phoneNumber', 'amountOwed'];
    public function orders() : HasMany{
        return $this -> hasMany(Order::class);
    }
}