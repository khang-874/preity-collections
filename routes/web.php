<?php

use App\Http\Controllers\DetailController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
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



//Update detail
Route::put('/details/{detail}', [DetailController::class, 'update']) -> middleware('auth');

//Delete detail
Route::delete('/details/{detail}', [DetailController::class, 'destroy']) -> middleware('auth');

//Create new deatil
Route::post('/details', [DetailController::class, 'create']) -> middleware('auth');



//Display login form
Route::get('/login', [UserController::class, 'login']);

//Authenticate user
Route::post('/authenticate', [UserController::class, 'authenticate']);

//Logout user
Route::post('/logout', [UserController::class, 'logout']);