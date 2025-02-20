<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    public $withTimestamps = true;
    protected $with = ['orderListings', 'details', 'payments'];
    protected $fillable = ['customer_id'];

    public function customer() : BelongsTo{
        return $this -> belongsTo(Customer::class);
    }
    public function orderListings() : HasMany{
        return $this -> hasMany(OrderListing::class);
    }
    public function payments() : HasMany{
        return $this -> hasMany(Payment::class);
    }

    public function details() : BelongsToMany{
        return $this -> belongsToMany(Detail::class, 'orders_listings', 'order_id', 'detail_id');
    }
    public function getSubtotalAttribute() : float{
        $total = 0;
        // dd($this -> orderListings);
        foreach($this -> orderListings as $orderListing){
            if($orderListing -> sale_price){
                $total += $orderListing -> sale_price * $orderListing -> quantity;
            }else{
                $total += $orderListing -> listing -> getSellingPriceAttribute() * $orderListing -> quantity;
            }
        }
        // dd($total);
        return $total;
    }

    public function getAmountPaidAttribute() : float{
        $total = 0;
        foreach($this -> payments as $payment){
            $total += $payment -> amount_paid;
        }
        return $total;
    }
    public function getTotalAttribute() : float{
        //Add tax
        if($this -> isTax){
            return round($this -> getSubTotalAttribute() * 1.13, 2);
        }
        return round($this -> getSubtotalAttribute(), 2);
    }

    public function getRemainingAttribute() : float{
        return round($this -> total - $this -> amount_paid, 2);
    }

    public function getIsTaxAttribute() : bool{
        $isTax = true;
        foreach($this -> orderListings as $orderListing){
            if($orderListing -> sale_price){
                $isTax = false;
            } 
        } 
        return $isTax;
    }
}
