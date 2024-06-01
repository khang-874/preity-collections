<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;
    public function customer() : BelongsTo{
        return $this -> belongsTo(Customer::class);
    }
    public function listings() : BelongsToMany{
        return $this -> belongsToMany(Listing::class, 'orders_listings', 'order_id', 'listing_id');
    }

    public function getTotalAttribute() : float{
        $total = 0;
        foreach($this -> listings as $listing){
            $total += $listing -> getSellingPriceAttribute();
        }
        return $total;
    }

    public function getTaxAttribute() : float{
        return $this -> getTotalAttribute() * 1.13;
    }
}
