<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(){
        return view('users.login');
    } 
    
    public function authenticate(Request $request){
        $formFields = $request -> validate([
            'email' => ['required'],
            'password' =>  'required',
        ]);

        if(auth() -> attempt($formFields)){
            $request -> session() -> regenerate();

            return redirect('/') -> with('message', 'Login successfully');
        }

        return back() -> withErrors([
            'email' => 'Invalid username',
            'password' => 'Invalid password',
        ]);
    }

    public function logout(){
        auth() -> logout();
        return redirect('/') -> with('message', 'Log out successfully');
    }
}
