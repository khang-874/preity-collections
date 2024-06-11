<?php

namespace App\Http\Controllers;

use App\Models\Subsection;
use Illuminate\Http\Request;

class SubsectionController extends Controller
{
    //
    public function store(Request $request){
        $request -> validate([
            'sectionId' => 'required',
            'name' => 'required',
        ]);
        $input = $request -> all();
        Subsection::create([
            'name' => $input['name'],
            'section_id' => $input['sectionId'],
        ]);
        return redirect('/manage') -> with('message', 'Create new subsection successfully');
    }

    public function delete(Subsection $subsection){
        $subsection-> delete();
        return redirect('/manage') -> with('message', 'Delete subsection successfully');
    }   
}
