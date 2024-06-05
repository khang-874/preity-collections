<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('orders.index', [
            'orders' => Order::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request -> validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'phoneNumber' => ['required', 'unique:App\Models\Customer,phoneNumber']
            
        ]);
        $firstName = $request -> input('firstName');
        $lastName = $request -> input('lastName');
        $phoneNumber = $request -> input('phoneNumber');
        $items = json_decode($request -> input('items'), true);

        $payment = 'pending';

        if(sizeof($items) == 0){
            return redirect('/') -> with('message', "You don't have any items in cart");
        }

        $customer = Customer::where('phoneNumber', $phoneNumber) -> firstOr(function() use ($firstName, $lastName, $phoneNumber){
            return Customer::create([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'phoneNumber' => $phoneNumber,
                'amountOwed' => 0.0
            ]);
        });

        $order = Order::create([
                'paymentType' => $payment,
                'customer_id' => $customer -> id,
        ]);
       
        $uniqueItems = [];
        for($i = 0; $i < sizeof($items); ++$i){
            $inArray = true;
            for($j = 0; $j < sizeof($uniqueItems); ++$j){
                if($uniqueItems[$j]['listingId'] == $items[$i]['listingId'] && $uniqueItems[$j]['detailId'] == $items[$i]['detailId']){
                    $inArray= false;
                    break;
                }
            }
            if(!$inArray)
                continue;
            $uniqueItems[] = $items[$i];
            for($j = $i + 1; $j < sizeof($items); ++$j){
                if($items[$i]['listingId'] == $items[$j]['listingId'] && $items[$i]['detailId'] == $items[$j]['detailId']){
                        $uniqueItems[sizeof($uniqueItems) - 1]['quantity'] += $items[$j]['quantity'];
                }
            }
        }
        foreach($uniqueItems as $item){
            $order -> listings() -> attach($item['listingId'], [
                'detail_id' => $item['detailId'], 
                'quantity' => $item['quantity']
            ]);     
        }
        return redirect('/') -> with('message', 'Place order successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order, Request $request)
    {
        //
        return view('orders.show', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
