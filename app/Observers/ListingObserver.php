<?php

namespace App\Observers;

use App\Models\Listing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ListingObserver
{
    /**
     * Handle the Listing "creating" event.
     */
    public function creating(Listing $listing): void
    {
        //
        $words = explode(' ', $listing -> subsection -> section -> category -> name); 
        $acronym = "";
        foreach($words as $word){
            $acronym .= mb_substr($word, 0, 1);
        }
 
        $words = explode(' ', $listing-> subsection -> section -> name); 
        foreach($words as $word){
            $acronym .= mb_substr($word, 0, 1);
        }

        $section = $listing -> subsection -> section;
    
        $id = $section -> serial_number; 
        $id++;
        $section -> serial_number = $id;
        $section -> save();
        $acronym .= $id;
        $listing -> serial_number = $acronym;
    }

    public function updating(Listing $listing):void{
        // If change subsection
        if($listing -> isDirty('subsection_id')){
            $words = explode(' ', $listing -> subsection -> section -> category -> name); 
            $acronym = "";
            foreach($words as $word){
                $acronym .= mb_substr($word, 0, 1);
            }
 
            $words = explode(' ', $listing-> subsection -> section -> name); 
            foreach($words as $word){
                $acronym .= mb_substr($word, 0, 1);
            }

            $section = $listing -> subsection -> section;
    
            $id = $section -> serial_number; 
            $id++;
            $section -> serial_number = $id;
            $section -> save();
            $acronym .= $id;
            $listing -> serial_number = $acronym;
        }
    }
    /**
     * Handle the Listing "updated" event.
     */
    public function updated(Listing $listing): void
    {
        //
        if(!$listing -> getOriginal('images'))
            return;

        // Delete image
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
