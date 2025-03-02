<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubsectionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Livewire\Counter;
use App\Mail\MyTestMail;
use App\Mail\NewOrder;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('home' ,[
        'categories' => Category::all() -> sortBy(function($category){return $category -> index;}),
        'newArrival' => Listing::orderBy('created_at', 'DESC') -> take(20) -> get() -> all(),
        'promotions' => Promotion::all()
    ]);
}) -> name('index');

Route::get('/aboutus', function(){
    return view('aboutus' ,[
        'categories' => Category::all() -> sortBy(function($category){return $category -> index;}),
    ]);
});

Route::get('/privacypolicy', function(){
    return view('privacypolicy' ,[
        'categories' => Category::all() -> sortBy(function($category){return $category -> index;}),
    ]);
});

//Get all listing
Route::get('/listings', [ListingController::class, 'index']) -> name('listings.index');

//Get all clearance listings
Route::get('/listings/clearance', [ListingController::class, 'indexClearance']) -> name('listings.indexClearance');
Route::get('/listings/sale', [ListingController::class, 'indexSale']) -> name('listings.indexSale');

//Get listing based on event
Route::get('/listings/events/{event}', [ListingController::class, 'indexEvents']);

//Get a single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//Print
Route::get('/print', [UserController::class, 'print']) -> name('print');

//Print receipt
Route::get('/printReceipt', [UserController::class, 'printReceipt']) -> name('printReceipt');

//Place order
Route::get('/placeOrder', [OrderController::class, 'placeOrder']);

//Create new online order;
Route::post('/orders/online' ,[OrderController::class, 'handleOnlineOrder']);

//Route to export sale data
Route::get('/sales/export/', [OrderController::class, 'export']);

//When success order come
Route::post('/orders/success', [OrderController::class, 'successOrder']);