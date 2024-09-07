<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Webhook;

class StripePaymentController extends Controller
{
    public function __construct(
        protected OrderController $orderController,
    ){} 
    public function stripeCheckout(Request $request)
    {
        $stripe = new \Stripe\StripeClient(Config::get('stripe.stripe_secret_key'));

        $items = json_decode($request -> input('items'), true); 

        $itemDetails = [];
        foreach($items as $item){
           $itemDetails[] = $item['detailId']; 
           $itemListings[] = $item['listingId'];
           $itemQuantity[] = $item['quantity'];
        }


        $listings = Listing::whereIn('id', $itemListings) -> get();
        // dd($listings);

        $line_items = [];
        foreach($listings as $key => $value){
           $line_items []= [
                'price_data' => [
                    'product_data' => [
                        'name' => $value -> name,
                        'images' => [$value -> images],
                        'metadata' => [
                            'detail_id' => $itemDetails[$key]
                        ]
                    ],
                    'unit_amount' => 100 * $value -> sellingPrice,
                    'currency' => 'CAD',
                ],
                'quantity' => $itemQuantity[$key]
            ];
        }
        $response =  $stripe->checkout->sessions->create([
            'success_url' => route('index'),
            'payment_method_types' => ['link', 'card'],
            'cancel_url' => route('index'),
            'line_items' => [[$line_items]],
            'shipping_address_collection' => [
                'allowed_countries' => ['CA']
            ],
            'mode' => 'payment',
            'allow_promotion_codes' => false
        ]);

        return redirect($response -> url);
    }
    
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET'); // You will set this up in Stripe Dashboard

        // Log::info($sigHeader);
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        // Log::info("I'm here");
        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event -> data -> object;
                
                $sessionId = $session -> id;
                $this -> processSessionData($sessionId); 
                break; 
            default:
                return response()->json(['error' => 'Unhandled event type'], 400);
        }

        return response()->json(['status' => 'success'], 200);
    }
    private function processSessionData($sessionId){
        Stripe::setApiKey(Config::get('stripe.stripe_secret_key'));
        $session = Session::retrieve([
            'id' => $sessionId,
            ['expand' => ['line_items']]
        ]);

        Log::debug($session -> customer_details);

        $lineItems = $session -> allLineItems($sessionId);

        $orderItems = [];

        $amount_paid = '';
        foreach($lineItems -> data as $item){
            $name = $item -> name;
            $description = $item->description;
            $quantity = $item->quantity;
            $amount_paid = $item->amount_total;
            $priceObject = $item -> price;
            $metadata = $priceObject -> metadata -> detailId;
            $orderItems[]= [
                'detailId' => $priceObject -> metadata -> detailId, 
                'listingId' => $priceObject -> metadata -> listingId,
                'quantity' => $quantity
            ];
            Log::info('Line Item:', [
                'name' => $name,
                'description' => $description,
                'quantity' => $quantity,
                'price' => $amount_paid,
                'metadata' => $metadata 
            ]);
        }

        $this -> orderController -> createOnlineOrder($orderItems, $session -> customer_details, $amount_paid);

    }
}
