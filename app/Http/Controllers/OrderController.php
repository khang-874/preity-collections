<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Mail\NewOrder;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

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
        // dd($request);
        $firstName = $request -> input('firstName');
        $lastName = $request -> input('lastName');
        $phoneNumber = $request -> input('phoneNumber');
        $email = $request -> input("email");
        
        $items = json_decode($request -> input('items'), true);

        $payment = 'pending';

        if(!$items || sizeof($items) == 0){
            return redirect('/') -> with('message', "You don't have any items in cart");
        }

        $customer = Customer::where('phone_number', $phoneNumber) 
                        -> orWhere('first_name', $firstName) 
                        -> firstOr(function() use ($firstName, $lastName, $phoneNumber, $email){
            return Customer::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone_number' => $phoneNumber,
                'amount_owe' => 0.0
            ]);
        });

        $order = Order::create([
                'payment_type' => $payment,
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
 
        $response = $this -> processPayment($customer, $order);
        // If the response is successful, it will contain the session token
        if ($response->successful()) {
            $token = $response->body(); // Assuming the response is just the token
             return view('payment.submitForm', ['token' => $token]);
        } else {
            // Handle error - log or display an error message
            return response()->json(['error' => 'Failed to get session token'], 500);
        }
    }
    public function successOrder(Request $request){
        $params = $request -> all();
        $orderId = substr($params['ssl_invoice_number'], 3);
        $order = Order::find(intval($orderId));
        $order -> payment_type = 'online';
        $order -> save();
        return redirect('/') -> with('message', 'Your Order has been placed successfully');
    }
    public function processPayment(Customer $customer, Order $order){
        $merchantID = env("MERCHANT_ID"); //Virtual Merchant Account ID 
        $merchantUserID = env("USER_ID"); //Virtual Merchant User ID 
        $merchantPinCode = env("PIN_CODE"); //Converge PIN 
        $vendorID = env("VENDOR_ID"); //Vendor ID 
        $url = "https://api.demo.convergepay.com/hosted-payments/transaction_token"; // URL to Converge demo session token server 
        //$url = "https://api.convergepay.com/hosted-payments/transaction_token"; // URL to Converge production session token server  
        
        $amount = $order -> total;
        $postFields = [
            'ssl_merchant_id' => $merchantID,
            'ssl_user_id' => $merchantUserID,
            'ssl_pin' => $merchantPinCode,
            'ssl_vendor_id' => $vendorID,
            'ssl_invoice_number' => 'Inv' . $order -> id,  // Invoice number
            'ssl_transaction_type' => 'ccsale',  // Transaction type
            'ssl_first_name' => $customer -> first_name,
            'ssl_last_name' => $customer -> last_name,
            'ssl_phone' => $customer -> phone_number,
            'ssl_email' => $customer -> email,
            'order_id' => $order -> id,
            'ssl_verify' => 'N',
            'ssl_get_token' => 'Y',  // Generate token
            'ssl_add_token' => 'Y',  // Add token if necessary
            'ssl_amount' => $amount  // Transaction amount
        ];

        $response = Http::asForm()->post($url, $postFields);

        return $response; 
    }
    private function getAddress($addressObject){
        return $addressObject -> line1 . $addressObject -> line2 . ', ' 
        . $addressObject -> city . ', '
        . $addressObject -> state . ', '
        . $addressObject -> country . ', '
        . $addressObject -> postal_code . '.';
    } 

    public function placeOrder(){
        return view('orders.placeorder',[
            'categories' => Category::all(),
        ]);
    }
 
    public function export(){
        return Excel::download(new SalesExport, 'sales.xlsx');
    }
}
