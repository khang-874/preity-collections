<?php

namespace App\Observers;

use App\Models\Promotion;

class PromotionObserver
{
    /**
     * Handle the Promotion "created" event.
     */
    public function created(Promotion $promotion): void
    {
        if(strlen($promotion->event) === 0){
            return;
        }
        $currentEvent = $promotion -> event;
        $currentEvent = strtolower($currentEvent);
        $currentEvent = str_replace(' ', '-', $currentEvent);
        $promotion -> event = $currentEvent;
        $promotion -> saveQuietly();
    }

    /**
     * Handle the Promotion "updated" event.
     */
    public function updated(Promotion $promotion): void
    {
        if(strlen($promotion->event) === 0 || !$promotion->isDirty('event')){
            return;
        }
        $currentEvent = $promotion -> event;
        $currentEvent = strtolower($currentEvent);
        $currentEvent = str_replace(' ', '-', $currentEvent);
        $promotion -> event = $currentEvent;
        $promotion -> saveQuietly();
    }

    /**
     * Handle the Promotion "deleted" event.
     */
    public function deleted(Promotion $promotion): void
    {
        //
    }

    /**
     * Handle the Promotion "restored" event.
     */
    public function restored(Promotion $promotion): void
    {
        //
    }

    /**
     * Handle the Promotion "force deleted" event.
     */
    public function forceDeleted(Promotion $promotion): void
    {
        //
    }
}
