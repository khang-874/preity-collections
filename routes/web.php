<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
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
use App\Models\Customer;
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

//Get all listing
Route::get('/listings', [ListingController::class, 'index']) -> name('listings.index');

//Get all clearance listings
Route::get('/listings/clearance', [ListingController::class, 'indexClearance']) -> name('listings.indexClearance');
Route::get('/listings/sale', [ListingController::class, 'indexSale']) -> name('listings.indexClearance');
//show create form
Route::get('/listings/create', [ListingController::class, 'create']) -> middleware('auth');

//Store listing data
Route::post('/listings', [ListingController::class, 'store']) -> middleware('auth');

//Update listing data
Route::put('/listings/{listing}', [ListingController::class, 'update']) -> middleware('auth');

//Edit a listing
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']) -> middleware('auth');

//Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy']) -> middleware('auth');

//Get a single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//Print
Route::get('/print', [UserController::class, 'print']) -> name('print');

//Print receipt
Route::get('/printReceipt', [UserController::class, 'printReceipt']) -> name('printReceipt');

//Place order
Route::get('/placeOrder', [OrderController::class, 'placeOrder']);

//Create new order;
Route::post('/orders' ,[OrderController::class, 'store']);

//Route to export sale data
Route::get('/sales/export/', [OrderController::class, 'export']);

Route::post('/orders/success', [OrderController::class, 'successOrder']);