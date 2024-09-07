<?php

namespace App\Http\Controllers;

use App\Mail\NewOrder;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('orders.index', [
            'orders' => Order::where('paymenType', '=', 'pending'),
        ]);
    } 
    /**
     * Show the form for creating a new resource.
     */
    public function create(Customer $customer, Request $request)
    {
        //validate request
        dd($customer);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'phoneNumber' => ['required', 'unique:App\Models\Customer,phone_number']
            
        ]);
        $firstName = $request -> input('firstName');
        $lastName = $request -> input('lastName');
        $phoneNumber = $request -> input('phoneNumber');
        $items = json_decode($request -> input('items'), true);

        $payment = 'pending';

        if(sizeof($items) == 0){
            return redirect('/') -> with('message', "You don't have any items in cart");
        }

        $customer = Customer::where('phone_number', $phoneNumber) 
                        -> orWhere('first_name', $firstName) 
                        -> firstOr(function() use ($firstName, $lastName, $phoneNumber){
            return Customer::create([
                'first_name' => $firstName,
                'last_name' => '',
                'email' => '',
                'phone_number' => $phoneNumber,
                'amount_owe' => 0.0
            ]);
        });

        $order = Order::create([
                'payment_type' => 'online',
                'customer_id' => $customer -> id,
                'amount_paid' => 0
        ]);
       
        
        foreach($items as $item){
            OrderListing::create([
                'listing_id' => $item['listingId'],
                'detail_id' => $item['detailId'],
                'quantity' => $item['quantity'],
                'order_id' => $order -> id,
            ]); 
        }

        //Send notificaiton about new email
        $sentEmail = Mail::to('khang07087@gmail.com') -> send(new NewOrder($customer, $order));
        return redirect('/') -> with('message', 'Place order successfully');
    }

    private function getAddress($addressObject){
        return $addressObject -> line1 . $addressObject -> line2 . ', ' 
        . $addressObject -> city . ', '
        . $addressObject -> state . ', '
        . $addressObject -> country . ', '
        . $addressObject -> postal_code . '.';
    }
    public function createOnlineOrder($orderItems, $customer, $amount_paid){
        $name = $customer -> name;
        $email = $customer -> email;
        $phone = $customer -> phone;
        $addressObject = $customer -> address;
        $address = $this -> getAddress($addressObject);

        $customer = Customer::where('phone_number', $phone) 
                        -> orWhere('first_name', $name) 
                        -> orWhere('email', $email)
                        -> firstOr(function() use ($name, $email, $phone){
            return Customer::create([
                'first_name' => $name,
                'last_name' => '',
                'email' => $email,
                'phone_number' => $phone == null ? '' : $phone,
                'amount_owe' => 0.0
            ]);
        });

        $order = Order::create([
            'address' => $address,
            'payment_type' => 'online',
            'customer_id' => $customer -> id,
            'amount_paid' => floatval($amount_paid) / 100
        ]);

        foreach($orderItems as $item){
            OrderListing::create([
                'listing_id' => $item['listingId'],
                'detail_id' => $item['detailId'],
                'quantity' => $item['quantity'],
                'order_id' => $order -> id,
            ]); 
        }

        //Send notificaiton about new email
        $sentEmail = Mail::to('khang07087@gmail.com') -> send(new NewOrder($customer, $order));
    }
    public function edit(Order $order, Request $request){
        $request -> validate([
            'amount' => 'required'
        ]);
        
        $customer = $order -> customer;
        $customer -> amount_owe += $order -> getTotalAttribute() - $request -> input('amount');
        $order -> payment_type = $request -> input('paymentType');
        $customer -> save();
        $order -> save();
        return redirect('/customers/' . $order -> customer_id) -> with('message', 'Pay for order successfully');
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

    public function placeOrder(){
        return view('orders.placeorder',[
            'categories' => Category::all(),
        ]);
    }
 
}
