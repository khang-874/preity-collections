<?php

use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

//Get all listing
Route::get('/', [ListingController::class, 'index']);

//Get a single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);