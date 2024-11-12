<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function processPayment(){
        $merchantID = "xxxxxx"; //Virtual Merchant Account ID 
        $merchantUserID = "apiuser123"; //Virtual Merchant User ID 
        $merchantPinCode = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"; //Converge PIN 
        $vendorID = "xxxxxx"; //Vendor ID 

        $url = "https://api.demo.convergepay.com/hosted-payments/transaction_token"; // URL to Converge demo session token server 
        //$url = "https://api.convergepay.com/hosted-payments/transaction_token"; // URL to Converge production session token server  

        // Read the following querystring variables 

        $amount= $_POST['ssl_amount']; //Post Tran Amount

        $ch = curl_init(); // initialize curl handle 
        curl_setopt($ch, CURLOPT_URL,$url); // set url to post to 
        curl_setopt($ch, CURLOPT_POST, true); // set POST method 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // Set up the post fields. If you want to add custom fields, you will add them in Converge and add the field name in the curlopt_postfields string. 
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
        "ssl_merchant_id=$merchantID". 
        "&ssl_user_id=$merchantUserID". 
        "&ssl_pin=$merchantPinCode". 
        "&ssl_vendor_id=$vendorID". 
        // "&ssl_first_name=Samuel". //You can pass in values from your application, and they will appear and pre-populate the HPP form 
        // "&ssl_avs_address=7301 Chapman Hwy". //You can pass in values from your application, and they will appear and pre-populate the HPP form 
        // "&ssl_avs_zip=37920". //You can pass in values from your application, and they will appear and pre-populate the HPP form 
        "&ssl_invoice_number=Inv123".  
        //"&ssl_next_payment_date=03/03/2023". //used only if transaction type is ccrecurring 
        //"&ssl_billing_cycle=MONTHLY".  //used only if transaction type is ccrecurring 
        "&ssl_transaction_type=ccsale". 
        "&ssl_verify=N". //set to 'Y' if transaction type is ccgettoken, otherwise not needed 
        "&ssl_get_token=Y". //pass with 'Y' if you wish to tokenize the card as part of a ccsale, do not send if transaction type set to ccgettoken 
        "&ssl_add_token=Y". // should always be Y if using card manager and either transaction type is set to 'Y' or if ssl_get_token is set to 'Y'. 
        "&ssl_amount=$amount" //do not pass amount if using ccgettoken as the transaction type 
        ); 

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $result = curl_exec($ch); // run the curl process 
        curl_close($ch); // Close cURL

        dd($result);
        // echo $result; //shows the session token.
    }
}
