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
        
        if($order -> payment_type != 'pending'){
            //Updating inventory and sold
            foreach($order -> orderListings as $orderListing){
                $orderListing -> detail -> inventory -= $orderListing -> quantity;
                $orderListing -> detail -> sold += $orderListing -> quantity;
                $orderListing -> detail -> save();
            }  
        }
        Log::debug('Createing new order');
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
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
     * Handle the Order "deleting" event.
     * Undo the action on inventory to properly manage it
     */
    public function deleting(Order $order): void
    {
        //
       foreach($order -> orderListings as $orderListing){
            $orderListing -> detail -> inventory += $orderListing -> quantity;
            $orderListing -> detail -> sold -= $orderListing -> quantity;
            $orderListing -> detail -> save();

       } 
    }
}
