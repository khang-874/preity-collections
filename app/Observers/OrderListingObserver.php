<?php

namespace App\Observers;

use App\Models\OrderListing;

class OrderListingObserver
{
    /**
     * Handle the OrderListing "deleting" event.
     * This event happens before delete completely
     */
    public function deleting(OrderListing $orderListing): void
    {
        //
        $orderListing -> detail -> inventory += $orderListing -> quantity;
        $orderListing -> detail -> sold -= $orderListing -> quantity;
        $orderListing -> detail -> save();
    }

    public function created(OrderListing $orderListing): void
    {
        $orderListing -> detail -> inventory -= $orderListing -> quantity;
        $orderListing -> detail -> sold += $orderListing -> quantity;
        $orderListing -> detail -> save();
    }

    public function updated(OrderListing $orderListing): void
    {
        if($orderListing -> isDirty('quantity')){
            $oldQuantity = $orderListing -> getOriginal('quantity');
            $change = $orderListing -> quantity - $oldQuantity;
            $orderListing -> detail -> inventory -= $change;
            $orderListing -> detail -> sold += $change;
            $orderListing -> detail -> save();
        }
    }
}
