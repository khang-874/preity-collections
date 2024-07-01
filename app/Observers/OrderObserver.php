<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        //
        // dd();
        //Only change update the inventory when make a payment
        if($order -> isDirty('payment_type') && $order -> getOriginal('payment_type') === 'pending'){
            //Updating inventory and sold
            foreach($order -> orderListings as $orderListing){
                $orderListing -> detail -> inventory -= $orderListing -> quantity;
                $orderListing -> detail -> sold += $orderListing -> quantity;
                $orderListing -> detail -> save();
            } 
        }
        Log::debug('Processing new order');
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
