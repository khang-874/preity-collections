<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Detail;
use App\Models\Vendor;
use App\Models\Listing;
use App\Models\Section;
use App\Models\Category;
use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ListingController extends Controller
{
    public function index(){
        return view('listings.index', [
                'listings' => Listing::filter(request(['category', 'section', 'subsection','search'])) 
                                -> size(request('size')) -> color(request('color')) 
                                -> clearance(request() -> query('isClearance')) -> paginate(40),
                'sizes' => Listing::filter(request(['category', 'section', 'subsection', 'search', 'isClearance'])) 
                                -> allSize() -> clearance(request('isClearance')) -> get(),
                'colors' => Listing::filter(request(['category', 'section', 'subsection', 'search', 'isClearance'])) 
                                -> allColor() -> clearance(request('isClearance')) -> get(),
                'categories' => Category::all() -> sortBy(function($category){return $category -> index;}),
        ]);

    }
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing,
            'categories' => Category::all() -> sortBy(function($category){return $category -> index;}),
        ]);
    }
    public function create(){
        return view('listings.create', [
            'categories' => Category::all() -> sortBy(function($category){return $category -> index;}),
            'vendors' => Vendor::all()
        ]);
    }
    public function store(Request $request){

        // dd($request -> all());
        $request -> validate([
            'name' => 'required',
            'description' => 'required',
            'vendor_id' => 'required',
            'initPrice' => ['required', 'numeric'],
            'subsection_id' => ['required']
        ]);

        $details = json_decode($request -> input('details'), true);
    
        $listing = $request -> only(['name', 'description', 'brand', 'weight', 'vendor_id', 'initPrice', 'subsection_id']);
        $createdListing = Listing::create([
            'name' => $listing['name'],
            'description' => $listing['description'],
            'vendor_id' => $listing['vendor_id'],
            'initPrice' => $listing['initPrice'],
            'subsection_id' => $listing['subsection_id'],
            'weight' => $listing['weight']
        ]);
        
        foreach($details as $detail){
            Detail::create([
                'size' => $detail['size'],
                'color' => $detail['color'],
                'inventory' => intval($detail['inventory']),
                'sold' => intval($detail['sold']),
                'listing_id' => $createdListing -> id
            ]);
        }
        return redirect('/listings/' . $createdListing -> id . '/edit');
    } 
    public function edit(Listing $listing){
        return view('listings.edit', [
            'listing' => $listing,
            'vendors' => Vendor::all(), 
            'categories' => Category::all() -> sortBy(function($category){return $category -> index;})
        ]);
    } 

    public function update(Listing $listing, Request $request){
        $formFields = $request -> validate([
            'name' => 'required',
            'description' => 'required',
            'vendor_id' => 'required',
            'initPrice' => ['required'],
        ]); 
       $formFields = $request -> all();
        $listing -> update($formFields);

        return redirect('/listings/' . $listing -> id  . '/edit') -> with('message', 'Listing update successfully');
    }
    
    public function destroy(Listing $listing){
        $listing -> delete();
        return redirect('/');
    }
}
