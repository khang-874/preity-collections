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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home', [
    'categories' => Category::all() -> sortBy(function($category){return $category -> index;}),
    'newArrival' => Listing::orderBy('created_at', 'DESC') -> take(20) -> get() -> all()
]);

//Get all listing
Route::get('/listings', [ListingController::class, 'index']) -> name('listings.index');

//Get all clearance listings
Route::get('/listings/clearance', [ListingController::class, 'indexClearance']) -> name('listings.indexClearance');
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

Route::get('/print', [UserController::class, 'print']) -> name('print');

//Place order
Route::get('/placeOrder', [OrderController::class, 'placeOrder']);

//Update detail
Route::put('/details/{detail}', [DetailController::class, 'update']) -> middleware('auth');

//Delete detail
Route::delete('/details/{detail}', [DetailController::class, 'destroy']) -> middleware('auth');

//Create new deatil
Route::post('/details', [DetailController::class, 'create']) -> middleware('auth');

// //Delete image
// Route::delete('/images/{image}' , [ImageController::class, 'destroy']) -> middleware('auth');

//Display pending order
Route::get('/orders', [OrderController::class, 'index']) -> middleware('auth');

Route::get('/orderes/create/{customer}', [OrderController::class, 'create']) -> middleware('auth');
//Display a single order
Route::get('/orders/{order}', [OrderController::class, 'show']) -> middleware('auth');

//Edit an order
Route::put('/orders/{order}', [OrderController::class, 'edit']) -> middleware('auth');


//Create new order;
Route::post('/orders' ,[OrderController::class, 'store']);

//Display all customers
Route::get('/customers', [CustomerController::class, 'index']) -> middleware('auth');

Route::get('/customers/newOrder', [CustomerController::class, 'newOrder']) -> middleware('auth');

//Display a single customer
Route::get('/customers/{customer}', [CustomerController::class, 'show']) -> middleware('auth');

//Update customer
Route::post('/customers/{customer}', [CustomerController::class, 'edit']) -> middleware('auth');

//Display login form
Route::get('/login', [UserController::class, 'login']) -> name('login');

// Mange categories, sections, subsections
Route::get('/manage', [UserController::class, 'manage']) -> middleware('auth');

//Create a new category
Route::post('/categories', [CategoryController::class, 'store']) -> middleware('auth');

//Delete a category
Route::delete('/categories/{category}', [CategoryController::class, 'delete']) -> middleware('auth');

//Create a new section
Route::post('/sections', [SectionController::class, 'store']) -> middleware('auth');

//Delete a section
Route::delete('/sections/{section}', [SectionController::class, 'delete']) -> middleware('auth');

//Create new subsection
Route::post('/subsections', [SubsectionController::class, 'store']) -> middleware('auth');

//Delete a subsection
Route::delete('/subsections/{subsection}', [SubsectionController::class, 'delete']) -> middleware('auth');

// //View all listings belonged to a vendor
// Route::get("/vendors/{vendor}", [VendorController::class, 'show']) -> middleware('auth');

// //Delete a vendor
// Route::delete('/vendors/{vendor}', [VendorController::class, 'delete']) -> middleware('auth');

// //Create new vendor
// Route::post('/vendors', [VendorController::class, 'store']) -> middleware('auth');

//Authenticate user
Route::post('/authenticate', [UserController::class, 'authenticate']);

//Logout user
Route::post('/logout', [UserController::class, 'logout']);

