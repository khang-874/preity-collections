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
use App\Mail\NewOrder;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Listing;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

//Get all listing
Route::get('/', [ListingController::class, 'index']);

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


//Place order
Route::get('/placeOrder', [OrderController::class, 'placeOrder']);

//Update detail
Route::put('/details/{detail}', [DetailController::class, 'update']) -> middleware('auth');

//Delete detail
Route::delete('/details/{detail}', [DetailController::class, 'destroy']) -> middleware('auth');

//Create new deatil
Route::post('/details', [DetailController::class, 'create']) -> middleware('auth');

//Delete image
Route::delete('/images/{image}' , [ImageController::class, 'destroy']) -> middleware('auth');

//Display orders
Route::get('/orders', [OrderController::class, 'index']) -> middleware('auth');

//Display a single order
Route::get('/orders/{order}', [OrderController::class, 'show']) -> middleware('auth');

//Create new order;
Route::post('/orders' ,[OrderController::class, 'create']);

//Display all customers
Route::get('/customers', [CustomerController::class, 'index']) -> middleware('auth');

//Display a single customer
Route::get('/customers/{customer}', [CustomerController::class, 'show']) -> middleware('auth');
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

//Authenticate user
Route::post('/authenticate', [UserController::class, 'authenticate']);

//Logout user
Route::post('/logout', [UserController::class, 'logout']);