<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Detail;
use App\Models\Listing;
use App\Models\Order;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class UserController extends Controller
{  
    public function print(){
        $details = [];
        $listing = null;
        if(request() -> query('listingId')){
            $listingId = request() -> query('listingId');
            $listing = Listing::find($listingId);
            foreach($listing -> details as $detail){
                for($i=0; $i < $detail -> inventory; ++$i){
                    $details []= $detail;
                }
            }
        }
        if(request() -> query('detailId')){
            $detailModel = Detail::find(request() -> query('detailId'));
            for($i = 0; $i < $detailModel -> inventory; ++$i){
                $details []= $detailModel;
            }
            $listing = $detailModel -> listing; 
        }
        // dd($listing);
        return view('users.print', [
            'details' => $details,
            'listing' => $listing
        ]);
    }

    public function printReceipt(){
        $order = Order::find(request() -> query('orderId'));
        return view('users.printReceipt',[
            'order' => $order,
        ]);
    }
}
