<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderListing extends Pivot
{
    use HasFactory;
    protected $table = "orders_listings";
    protected $with = ['listing'];
    public function order() : BelongsTo{
        return $this -> belongsTo(Order::class);
    }
    public function listing() : BelongsTo{
        return $this -> belongsTo(Listing::class);
    }
    public function detail() : BelongsTo{
        return $this -> belongsTo(Detail::class, 'detail_id');
    }
    public function getSubtotalAttribute() : float{
        return $this -> listing -> sellingPrice * $this -> quantity;
    }
}
