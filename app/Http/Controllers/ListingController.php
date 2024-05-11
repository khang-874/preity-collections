<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListingController extends Controller
{
    public function index(){
        if(request("category")){
            return view('listings.index', [
                'listings' => DB::table('listings_categories') 
                            -> join('listings', 'listing_id','=','listings.id') 
                            -> where('category_id', request('category'))
                            -> select('listings.*')
                            -> get(),
                'sections' => Section::all(),
                'categories' => Category::all()
            ]);
        }else{
            return view('listings.index', [
                'listings' => Listing::all(),
                'sections' => Section::all(),
                'categories' => Category::all(),
            ]);
        }
    }
}
