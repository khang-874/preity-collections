<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //Store new category
    public function store(Request $request){
        $request -> validate([
            'name' => 'required',
        ]);
        $input = $request -> all();
        // dd($name);
        Category::create([
            'name' => $input['name']
        ]);
        return redirect('/manage') -> with('message' ,'Create new categories successfully');
    }
    
    public function delete(Category $category){
        $category -> delete();
        return redirect('/manage') -> with('message', 'Delete categories successfully');
    }
}
