<?php

namespace App\Observers;

use App\Models\Customer;

class CustomerObserver
{
    public function retrieved(Customer $customer): void{
        $amount_owe = 0;
        foreach($customer -> orders as $order){
            $amount_owe += $order -> remaining;
        }
        $customer -> amount_owe = round($amount_owe, 2);
        if($customer -> amount_owe != $amount_owe)
            $customer -> save();
    }
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "restored" event.
     */
    public function restored(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     */
    public function forceDeleted(Customer $customer): void
    {
        //
    }
}
