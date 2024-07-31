<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Detail;
use App\Models\Vendor;
use App\Models\Listing;
use App\Models\Section;
use App\Models\Category;
use App\Models\Subsection;
use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ListingController extends Controller
{
    public function index(){
        return view('listings.index', [
                'listings' => Listing::filter(request(['category', 'section', 'subsection','search'])) 
                                -> size(request('size')) -> color(request('color')) -> available() 
                                -> paginate(40),
                'sizes' => Listing::filter(request(['category', 'section', 'subsection', 'search'])) 
                                -> allSize() -> get(),
                'colors' => Listing::filter(request(['category', 'section', 'subsection', 'search', 'isClearance'])) 
                                -> allColor() -> get(),
                'categories' => Category::all() -> sortBy(function($category){return $category -> index;}),
        ]);
    }
    public function indexClearance(){
        return view('listings.index', [
                'listings' => Listing::filter(request(['category', 'section', 'subsection','search'])) 
                                -> size(request('size')) -> color(request('color')) -> available() 
                                -> clearance() -> paginate(40),
                'sizes' => Listing::filter(request(['category', 'section', 'subsection', 'search'])) 
                                -> allSize() -> clearance() -> get(),
                'colors' => Listing::filter(request(['category', 'section', 'subsection', 'search'])) 
                                -> allColor() -> clearance() -> get(),
                'categories' => Category::all() -> sortBy(function($category){return $category -> index;}),
        ]);

    }

    private function randomListings(array $listing, int $number){
        $randomListing = array_rand($listing, min($number, count($listing))); 
        if(gettype($randomListing) == gettype(1))
            return [$listing[0]];
        else return array_map(fn($index) => $listing[$index], $randomListing);
    }
    public function show(Listing $listing){
        $section_id = '';
        $category_id = '';
        $categories = Category::all();

        foreach($categories as $category)
            foreach($category->sections as $section)
                foreach($section->subsections as $subsection)
                    if($subsection->id == $listing->subsection_id){
                        $section_id = $section->id;
                        $category_id = $category->id;
                        break 3;
                    }    
                    
        $subsectionListings = Subsection::find($listing -> subsection_id) -> listings -> all();
        // dd(array_rand($subsectionListings, min(4, count($subsectionListings))));
        // dd( array_intersect_key( $subsectionListings, array_flip( array_rand( $subsectionListings, 2 ) ) ) );
        $randomSubsectionListings = $this -> randomListings($subsectionListings, 4);
        // $randomSubsectionListings = [];

        $sectionListings = [];
        $section = Section::find($section_id);
        foreach($section -> subsections as $subsection){
            $sectionListings = array_merge($sectionListings, $subsection -> listings -> all());  
        }

        $categoryListings = [];
        $category = Category::find($category_id);
        $categoryListings = [];
        foreach($category -> sections as $section){
            foreach($section -> subsections as $subsection){
                $categoryListings = array_merge($categoryListings, $subsection -> listings -> all());
            }
        }
        $randomSectionListings = $this -> randomListings($sectionListings, 4);
        $randomCategoryListings = $this -> randomListings($categoryListings, 4);
        $recommend =  array_merge($randomCategoryListings, $randomSectionListings, $randomSubsectionListings);

        return view('listings.show', [
            'listing' => $listing,
            'categories' => Category::all() -> sortBy(function($category){return $category -> index;}),
            'recommendListings' => $recommend
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
