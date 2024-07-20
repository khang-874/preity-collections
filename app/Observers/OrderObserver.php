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
            $customer = $order -> customer;
            $amount_owe = 0;
            foreach($customer -> orders as $order){
                $amount_owe += $order -> remaining;
            }
            $customer -> amount_owe = $amount_owe;
            $customer -> save();
        }
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
            $customer = $order -> customer;
            $amount_owe = 0;
            foreach($customer -> orders as $order){
                $amount_owe += $order -> remaining;
            }
            $customer -> amount_owe = $amount_owe;
            $customer -> save();
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
