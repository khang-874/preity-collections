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
    protected $with = ['orderListings', 'details'];
    protected $fillable = ['paymentType', 'customer_id'];

    public function customer() : BelongsTo{
        return $this -> belongsTo(Customer::class);
    }
    public function orderListings() : HasMany{
        return $this -> hasMany(OrderListing::class);
    }
    public function details() : BelongsToMany{
        return $this -> belongsToMany(Detail::class, 'orders_listings', 'order_id', 'detail_id');
    }
    public function getSubtotalAttribute() : float{
        $total = 0;
        foreach($this -> orderListings as $orderListing){
            $total += $orderListing -> listing -> getSellingPriceAttribute();
        }
        return $total;
    }

    public function getTotalAttribute() : float{
        return $this -> getSubTotalAttribute() * 1.13;
    }
}
