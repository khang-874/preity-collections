<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customers.index', [
            'customers' => Customer::filter(request(['search'])) -> get(),
            'categories' => Category::all() -> sortBy('index'),
        ]);
    }

    
    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', [
            'customer' => $customer,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer, Request $request)
    {
        $request -> validate([
            'amountOwed' => ['required']
        ]);
        $customer -> amountOwed = $request -> input('amountOwed');
        $customer -> save();
        return redirect('/customers/' . $customer -> id) -> with('message', 'Update customer successfully');
    }
    
    public function newOrder(){
        return view('customers.index', [
            'customers' => Customer::newOrder() -> get(),
            'categories' => Category::all()
        ]);
    }
}
