<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Mail\NewOrder;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Listing;
use App\Models\Order;
use App\Models\OrderListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Prepare to send to payment
     */
    public function handleOnlineOrder(Request $request)
    {
        $request -> validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'phoneNumber' => 'required',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postalCode' => 'required'
        ]);

        $items = json_decode($request -> input('items'), true);

        if(!$items || sizeof($items) == 0){
            return redirect('/') -> with('message', "You don't have any items in cart");
        }
        $firstName = $request -> input('firstName');
        $lastName = $request -> input('lastName');
        $phoneNumber = $request -> input('phoneNumber');
        $email = $request -> input("email");
        $address = request('address');
        $city = request('city');
        $postalCode = request('postalCode');
        
        $customer = Customer::where('phone_number', $phoneNumber) 
                        -> firstOr(function() use ($firstName, $lastName, $phoneNumber, $email, $address, $city, $postalCode){
            return Customer::make([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone_number' => $phoneNumber,
                'amount_owe' => 0.0,
                'address' => $address,
                'city' => $city,
                'postal_code' => $postalCode,
            ]);
        }); 
        
        $response = $this -> redirectToPaymentPage($customer, $items);
        // If the response is successful, it will contain the session token
        if ($response->successful()) {
            $token = $response->body(); // Assuming the response is just the token
             return view('payment.submitForm', ['token' => $token]);
        } else {
            // Handle error - log or display an error message
            return response()->json(['error' => 'Failed to get session token'], 500);
        }
    }
 
    //Store the success order to the database
    public function successOrder(Request $request){
        $firstName = request('ssl_first_name');
        $lastName = request('ssl_last_name');
        $phoneNumber = request('ssl_phone');
        $email = request("ssl_email");
        $address = request('ssl_avs_address');
        $city = request('ssl_city');
        $postalCode = request('ssl_avs_zip');
        $items = request('items');
        
        $payment = 'online';

        $customer = Customer::where('phone_number', $phoneNumber) 
                        -> firstOr(function() use ($firstName, $lastName, $phoneNumber, $email, $address, $city, $postalCode){
            return Customer::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone_number' => $phoneNumber,
                'amount_owe' => 0.0,
                'address' => $address,
                'city' => $city,
                'postal_code' => $postalCode,
            ]);
        });

        $order = Order::create([
                'payment_type' => $payment,
                'customer_id' => $customer -> id,
                'amount_paid' => 0
        ]);
       

        foreach($items as $item){
            OrderListing::create([
                'listing_id' => $item['l'],
                'detail_id' => $item['d'],
                'quantity' => $item['q'],
                'order_id' => $order -> id,
            ]); 
        }

        return redirect('/') -> with('message', 'Your Order has been placed successfully');
    }

    public function getTotalAmount(array $items){
        $listingsId = [];
        foreach($items as $item){
            $listingsId []= $item['listingId'];
        }

        $listings = Listing::whereIn('id', $listingsId) -> get();
        $total = 0;
        foreach($items as $item){
            foreach($listings as $listing){
                if($item['listingId'] == $listing -> id){
                    $total += $item['quantity'] * $listing -> getSellingPriceAttribute();
                }
            }
        }
        
        //Add tax
        $total *= 1.13;

        return $total;
    }

    /*
    ** Note that using 'l' for listingId
    ** 'd' for detailId
    ** 'q' for quantity in items send to converge to save space because there is a limit 
    ** on how many character we can send
    */
    public function redirectToPaymentPage(Customer $customer, array $items){
        $merchantID = env("MERCHANT_ID"); //Virtual Merchant Account ID 
        $merchantUserID = env("USER_ID"); //Virtual Merchant User ID 
        $merchantPinCode = env("PIN_CODE"); //Converge PIN 
        $vendorID = env("VENDOR_ID"); //Vendor ID 
        $url = "https://api.demo.convergepay.com/hosted-payments/transaction_token"; // URL to Converge demo session token server 
        //$url = "https://api.convergepay.com/hosted-payments/transaction_token"; // URL to Converge production session token server  
 
        $amount = $this -> getTotalAmount($items);
        $orderId = Order::count() + 1;

        $sendItems = [];
        foreach($items as $item){
            $sendItems []= [
                'l' => $item['listingId'],
                'd' => $item['detailId'],
                'q' => $item['quantity'],
            ];
        }

        $postFields = [
            'ssl_merchant_id' => $merchantID,
            'ssl_user_id' => $merchantUserID,
            'ssl_pin' => $merchantPinCode,
            'ssl_vendor_id' => $vendorID,
            'ssl_invoice_number' => 'Inv' . $orderId,  // Invoice number
            'ssl_transaction_type' => 'ccsale',  // Transaction type
            'ssl_first_name' => $customer -> first_name,
            'ssl_last_name' => $customer -> last_name,
            'ssl_phone' => $customer -> phone_number,
            'ssl_email' => $customer -> email,
            'ssl_avs_address' => $customer -> address,
            'ssl_city' => $customer -> city,
            'ssl_avs_zip' => $customer -> postal_code,
            'items' => json_encode($sendItems),
            'ssl_verify' => 'N',
            'ssl_get_token' => 'Y',  // Generate token
            'ssl_add_token' => 'Y',  // Add token if necessary
            'ssl_amount' => $amount  // Transaction amount
        ];

        $response = Http::asForm()->post($url, $postFields);

        return $response; 
    } 

    public function placeOrder(){
        return view('orders.placeorder',[
            'categories' => Category::all(),
        ]);
    }
 
    // public function cancelPlaceOrder(){
    //     dd(request(), json_decode(request('items'), true), strlen(request('items')));
    //     return view('orders.placeorder', [
    //         'categories' => Category::all(),
    //     ]);
    // }

    public function export(){
        return Excel::download(new SalesExport, 'sales.xlsx');
    }
}
