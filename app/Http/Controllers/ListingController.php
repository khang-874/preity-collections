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
        ]);
    }
    public function store(Request $request){
        $formFields = $request -> validate([
            'name' => 'required',
            'description' => 'required',
            'brand' => 'required',
            'vendor' => 'required',
            'initPrice' => ['required', 'numeric'],
            'subsection' => ['required']
        ]);

        $listing = $request -> only(['name', 'description', 'brand', 'vendor', 'initPrice', 'subsection']);
        $createdListing = Listing::create([
            'name' => $listing['name'],
            'description' => $listing['description'],
            'brand' => $listing['brand'],
            'vendor' => $listing['vendor'],
            'initPrice' => $listing['initPrice'],
            'subsection_id' => $listing['subsection']
        ]);
        
        return redirect('/listings/' . $createdListing -> id . '/edit');
    } 
    public function edit(Listing $listing){
        return view('listings.edit', [
            'listing' => $listing,
            'categories' => Category::with('sections.subsections') -> get(),
        ]);
    } 

    public function update(Listing $listing, Request $request){
        $formFields = $request -> validate([
            'name' => 'required',
            'description' => 'required',
            'brand' => 'required',
            'vendor' => 'required',
            'initPrice' => ['required', 'numeric'],
        ]); 

        $listing -> update($formFields);

        return redirect('/listings/' . $listing -> id ) -> with('message', 'Listing update successfully');
    }
    
    public function destroy(Listing $listing){
        $listing -> delete();
        return redirect('/');
    }
}
