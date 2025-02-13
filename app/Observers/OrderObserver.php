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
         
        Log::debug('Createing new order');
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    { 
        Log::debug('Processing new order');
    }

    /**
     * Handle the Order "deleting" event.
     * Undo the action on inventory to properly manage it
     */
    public function deleting(Order $order): void
    { 
    }
}
