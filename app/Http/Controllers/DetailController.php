<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Image;
use App\Models\Listing;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    //Create new detail
    public function create(Request $request){
        $listingId = $request -> query('listingId');
        $detail = Detail::create([
            'color' => "#FFFFFF",
            'size' => "XL",
            'inventory' => 0,
            'sold' => 0,
            'weight' => '1.0',
            'listing_id' => $listingId
        ]);
        return redirect('/listings/' . $listingId . '/edit') -> with('message', 'Create new detail');
    }

    //Delete detail
    public function destroy(Detail $detail){
        $listingId = $detail -> listing -> id;
        $detail -> delete();

        return redirect('/listings/' . $listingId . '/edit') -> with('message', 'Delete detail successfully'); 
    }


    //Update detail
    public function update(Detail $detail, Request $request){
        $formFields = $request -> validate([
            "inventory" => ["required", "gte:0"],
            "sold" => ["required", "gte:0"],
            "size" => ['required']
        ]);
        if($request->hasFile('images')){
            $files= $request -> file('images');
            $allowedFileExtension=['jpg','png','jpeg'];

            foreach($files as $file){
                $extension = $file -> getClientOriginalExtension();
                $check = in_array($extension, $allowedFileExtension);
                if($check){
                   $imageURL = asset('storage/'.$file -> store('photos')); 
                   Image::create([
                        'imageURL' => $imageURL,
                        'detail_id' => $detail -> id,
                   ]);
                }
            }
            // dd($files);
        }
        $detail -> update($formFields);
        return redirect('/listings/'. $detail->listing->id. '/edit') -> with('message', 'Update detail successfully');
    }
}
