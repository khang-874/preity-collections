<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Detail;
use App\Models\Vendor;
use App\Models\Listing;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ListingController extends Controller
{
    public function index(){
        return view('listings.index', [
                'listings' => Listing::filter(request(['category', 'section', 'subsection','search'])) -> size(request('size')) -> paginate(30),
                'sizes' => Listing::filter(request(['category', 'section', 'subsection', 'search'])) -> allSize() -> get(),
                'colors' => Listing::filter(request(['category', 'section', 'subsection', 'search'])) -> allColor() -> get(),
                'categories' => Category::all()
        ]);

    }
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing,
            'categories' => Category::with('sections.subsections') -> get(),
        ]);
    }
    public function create(){
        return view('listings.create', [
            'categories' => Category::with('sections.subsections') -> get(),
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
                        'listing_id' => $createdListing -> id,
                   ]);
                }
            }
        }
        return redirect('/listings/' . $createdListing -> id . '/edit');
    } 
    public function edit(Listing $listing){
        return view('listings.edit', [
            'listing' => $listing,
            'vendors' => Vendor::all(), 
            'categories' => Category::with('sections.subsections') -> get(),
        ]);
    } 

    public function update(Listing $listing, Request $request){
        $formFields = $request -> validate([
            'name' => 'required',
            'description' => 'required',
            'vendor_id' => 'required',
            'initPrice' => ['required'],
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
                        'listing_id' => $listing -> id,
                   ]);
                }
            }
        }
        $formFields = $request -> all();
        // dd($formFields);
        $listing -> update($formFields);

        return redirect('/listings/' . $listing -> id  . '/edit') -> with('message', 'Listing update successfully');
    }
    
    public function destroy(Listing $listing){
        $listing -> delete();
        return redirect('/');
    }
}
