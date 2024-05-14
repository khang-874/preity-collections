<?php

use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

//Get all listing
Route::get('/', [ListingController::class, 'index']);

//Create a new listing
Route::get('/listings/create', [ListingController::class, 'create']);

//Store listing data
Route::post('listings', [ListingController::class, 'store']);

//Get a single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

