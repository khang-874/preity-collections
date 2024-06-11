<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;

class SectionController extends Controller
{
    public function store(Request $request){
        $request -> validate([
            'categoryId' => 'required',
            'name' => 'required',
        ]);
        $input = $request -> all();
        Section::create([
            'name' => $input['name'],
            'category_id' => $input['categoryId'],
        ]);
        return redirect('/manage') -> with('message', 'Create new section successfully');
    }

    public function delete(Section $section){
        $section -> delete();
        return redirect('/manage') -> with('message', 'Delete section successfully');
    }   
}
