<?php

namespace App\Observers;

use App\Models\Listing;
use Illuminate\Support\Facades\Storage;

class ListingObserver
{
    /**
     * Handle the Listing "created" event.
     */
    public function created(Listing $listing): void
    {
        //
    }

    /**
     * Handle the Listing "updated" event.
     */
    public function updated(Listing $listing): void
    {
        //
        // dd($listing, $listing -> isDirty('images'));

        if($listing->isDirty('images')){
            $originalArray = $listing -> getOriginal('images');
            $diffArr = array_diff($originalArray, $listing -> images);
            // dd($diffArr);
            foreach($diffArr as $deleteImage)
                Storage::disk('public') -> delete($deleteImage);
        }
    }

    /**
     * Handle the Listing "deleted" event.
     */
    public function deleted(Listing $listing): void
    {
        //
        if(!is_null($listing -> images)){
            foreach($listing -> images as $image){
                Storage::disk('public') -> delete($image);
            }
        }
    }

    /**
     * Handle the Listing "restored" event.
     */
    public function restored(Listing $listing): void
    {
        //
    }

    /**
     * Handle the Listing "force deleted" event.
     */
    public function forceDeleted(Listing $listing): void
    {
        //
    }
}
