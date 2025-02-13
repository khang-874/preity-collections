<?php

namespace App\Observers;

use App\Models\OrderListing;

class OrderListingObserver
{
    /**
     * Handle the OrderListing "deleting" event.
     * Thie event happens when we want to return some items
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
}
