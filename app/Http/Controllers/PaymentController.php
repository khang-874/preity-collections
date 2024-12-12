<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    //
    public function processPayment(){
        $merchantID = env("MERCHANT_ID"); //Virtual Merchant Account ID 
        $merchantUserID = env("USER_ID"); //Virtual Merchant User ID 
        $merchantPinCode = env("PIN_CODE"); //Converge PIN 
        $vendorID = env("VENDOR_ID"); //Vendor ID 
// 
        $url = "https://api.demo.convergepay.com/hosted-payments/transaction_token"; // URL to Converge demo session token server 
        //$url = "https://api.convergepay.com/hosted-payments/transaction_token"; // URL to Converge production session token server  
        
        $amount = 100.0;

        $postFields = [
            'ssl_merchant_id' => $merchantID,
            'ssl_user_id' => $merchantUserID,
            'ssl_pin' => $merchantPinCode,
            'ssl_vendor_id' => $vendorID,
            'ssl_invoice_number' => 'Inv123',  // Invoice number
            'ssl_transaction_type' => 'ccsale',  // Transaction type
            'ssl_verify' => 'N',
            'ssl_get_token' => 'Y',  // Generate token
            'ssl_add_token' => 'Y',  // Add token if necessary
            'ssl_amount' => $amount  // Transaction amount
        ];

        $response = Http::asForm()->post($url, $postFields);

        // If the response is successful, it will contain the session token
        if ($response->successful()) {
            // Get the response data (session token)
            $token = $response->body(); // Assuming the response is just the token
 
            return view('payment.submitForm', ['token' => $token]);
        } else {
            // Handle error - log or display an error message
            return response()->json(['error' => 'Failed to get session token'], 500);
        }
    }
}
