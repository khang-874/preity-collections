<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    //Delete an image
    public function destroy(Image $image){
        $listingId = $image -> detail -> listing_id;
        $image -> delete();
        return redirect('/listings/' . $listingId . '/edit');
    }
}