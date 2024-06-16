<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    //
    public function show(Vendor $vendor){
        return view("listings.index", [
            "listings" => $vendor -> load('listings') -> listings,
            "categories" => Category::all(),
            "sizes" => [],
            "colors" => []
        ]);
    }

    //Delete vendor
    public function delete(Vendor $vendor){
        $vendor -> delete();
        return redirect('/manage') -> with('message', 'Delete vendor successfully');
    }

    public function store(Request $request){
        $request -> validate([
            'name' => 'required',
        ]);
        $name = $request -> input('name');
        Vendor::create([
            'name' => $name
        ]);
        return redirect('/manage') -> with('message', 'Create vendor successfully');
    }
}
