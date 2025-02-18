<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Detail;
use App\Models\Vendor;
use App\Models\Listing;
use App\Models\Section;
use App\Models\Category;
use App\Models\Promotion;
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

    public function indexClearance()
    {
        return $this->prepareListingView('clearance');
    }

    public function index()
    {
        return $this->prepareListingView('normal');
    }

    public function indexSale()
    {
        return $this->prepareListingView('sale');
    }

    public function indexEvents(string $event){
        // dd($event);
        return $this -> prepareListingView('events', $event);
    }

    private function prepareListingView($type, $event='')
    {
        $title = $this->findTitle($type);
        $orders = $this->getOrders();

        $filters = request(['category', 'section', 'subsection', 'search', 'order']);
        $filtersColorSize = request(['category', 'section', 'subsection', 'search']);
        $size = request('size');
        $color = request('color');

        $listingsQuery = Listing::filter($filters)->size($size)->color($color)->available();
 
        match($type){
            'clearance' => $listingsQuery -> clearance(),
            'sale' => $listingsQuery -> sale(),
            'events' => $listingsQuery -> events($event),
            default => null,
        }; 
        $listingsNumber = $listingsQuery -> count();
        return view('listings.index', [
            'listings' => $listingsQuery->paginate(40),
            'sizes' => $this->getSizes($filtersColorSize, $type),
            'colors' => $this->getColors($filtersColorSize, $type),
            'categories' => $this->getCategories(),
            'listings_number' => $listingsNumber,
            'title' => $title,
            'orders' => $orders,
        ]);
    }

    private function getSizes($filters, $type)
    {
        $query = Listing::filter($filters)->allSize();
        match($type){
            'clearance' => $query -> clearance(),
            'sale' => $query -> sale(),
            default => null,
        }; 
        return $query->get();
    }

    private function getColors($filters, $type)
    {
        $query = Listing::filter($filters)->allColor();
        match($type){
            'clearance' => $query -> clearance(),
            'sale' => $query -> sale(),
            default => null
        };  
        return $query->get();
    }

    private function getCategories()
    {
        return Category::all()->sortBy(function ($category) {
            return $category->index;
        });
    } 

    //Get the sorting order
    private function getOrders(){
        $orders = [
            'highestdiscount' => ['name' => 'Highest discount', 'active' => false,],
            'newtoold' => ['name' => 'New to Old','active' => false,],
            'oldtonew' => ['name' => 'Old to New','active' => false,],
            'hightolow' => ['name' => 'High to Low','active' => false,],
            'lowtohigh' => ['name' => 'Low to High','active' => false,],
        ];
        // dd(request('order'));

        if(request('order') ?? false){
            
            foreach ($orders as $key => $value) {
                if($key == request('order')){
                    $orders[$key]['active'] = true;
                }
                else
                    $order[$key]['active'] = false;
            }
        }

        // dd($orders);
        return $orders; 
    }
    private function findTitle($type){
        $title = '';
        if(request('category'))
            $title= Category::find(request('category')) -> name;
        if(request('section'))
            $title= Section::find(request('section')) -> name;
        if(request('subsection'))
            $title = Subsection::find(request('subsection')) -> name;
        match($type){
            'sale' => $title .= 'Special Sale',
            'clearance' => $title .= ' Clearance',
            default => null,
        };
        return $title;
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
        $randomSubsectionListings = $this -> randomListings($subsectionListings, 4);

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

        $colors = [];
        $sizes = [];
        foreach ($listing -> details as $detail) 
            if($detail -> available){ 
                $colors[$detail->color][$detail->size] = ['detailId' => $detail -> id, 'quantity' => $detail -> inventory];
                $sizes[$detail->size][$detail->color] = ['detailId' => $detail -> id, 'quantity' => $detail -> inventory]; 
        }

        return view('listings.show', [
            'listing' => $listing,
            'categories' => Category::all() -> sortBy(function($category){return $category -> index;}),
            'recommendListings' => $recommend,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }
    public function create(){
        return view('listings.create', [
            'categories' => Category::all() -> sortBy(function($category){return $category -> index;}),
            'vendors' => Vendor::all()
        ]);
    }   
}
