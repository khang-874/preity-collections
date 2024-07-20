<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;
    protected $with = ['orders'];
    protected $fillable = ['first_name', 'last_name', 'phone_number', 'amount_owe'];
    public function orders() : HasMany{
        return $this -> hasMany(Order::class);
    } 
    // public function scopeFilter($query , array $filters){
    //     if($filters['search'] ?? false){
    //         $query  -> select('customers.*')
    //                 -> whereRaw("CONCAT(customers.firstName, ' ', customers.lastName) like ?", '%' . request('search') . '%')
    //                 -> orWhere('customers.phoneNumber', 'like', '%' . request('search') . '%');
    //     }
    // }
    
    // public function scopeNewOrder($query){
    //     $query -> join('orders', 'customers.id', '=', 'orders.customer_id')
    //             -> select('customers.*')
    //             -> where('orders.paymentType', '=', 'pending');
    // }
}
