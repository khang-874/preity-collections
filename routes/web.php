<?php

use App\Http\Controllers\DetailController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
use Illuminate\Support\Facades\Route;

//Get all listing
Route::get('/', [ListingController::class, 'index']);

//Create a new listing
Route::get('/listings/create', [ListingController::class, 'create']);

//Store listing data
Route::post('/listings', [ListingController::class, 'store']);

//Update listing data
Route::put('/listings/{listing}', [ListingController::class, 'update']);

//Edit a listing
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']) -> middleware('auth');

//Get a single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);



//Update detail
Route::put('/details/{detail}', [DetailController::class, 'update']);

//Create new deatil
Route::post('/details', [DetailController::class, 'create']);

//Delete detail
Route::get('/details/{detail}/delete', [DetailController::class, 'destroy']);


//Display login form
Route::get('/login', [UserController::class, 'login']);



//Authenticate user
Route::post('/authenticate', [UserController::class, 'authenticate']);

//Logout user
Route::post('/logout', [UserController::class, 'logout']);