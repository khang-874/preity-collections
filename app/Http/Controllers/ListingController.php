<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Detail;
use App\Models\Listing;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index(){
        // if(request("category")){
        //     return view('listings.index', [
        //         'listings' => DB::table('listings_categories') 
        //                     -> join('listings', 'listing_id','=','listings.id') 
        //                     -> where('category_id', request('category'))
        //                     -> select('listings.*')
        //                     -> get(),
        //         'categories' => Category::with('sections.subsections')->get(),
        //     ]);
        // }else{
        //     return view('listings.index', [
        //         'listings' => Listing::all(),
        //         'categories' => Category::with('sections')->get(),
        //     ]);
        // }
        return view('listings.index', [
                'listings' => Listing::with('details.images') -> paginate(20),
                'categories' => Category::with('sections.subsections') -> get()
        ]);

    }
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing,
            'categories' => Category::with('sections.subsections') -> get(),
        ]);
    }
    public function create(){
        return view('listings.create');
    }
    public function store(Request $request){
        $formFields = $request -> validate([
            'name' => 'required',
            'description' => 'required',
            'brand' => 'required',
            'vendor' => 'required',
            'initPrice' => ['required', 'numeric'],
            'color' => 'required',
            'inventory' => 'required',
        ]);
        if($request->hasFile('images')){
            
        }
        $listing = $request -> only(['name', 'description', 'brand', 'vendor', 'initPrice']);
        $createdListing = Listing::create($listing);
        $detail = new Detail($request -> only(['color', 'size', 'inventory', 'sold','weight']));
        $createdListing -> details() -> save($detail);

        return redirect('/');
    }
}
