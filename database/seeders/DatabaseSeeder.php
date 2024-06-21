<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Detail;
use App\Models\Image;
use App\Models\Listing;
use App\Models\Order;
use App\Models\OrderListing;
use App\Models\Section;
use App\Models\Size;
use App\Models\Subsection;
use App\Models\User;
use App\Models\Vendor;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('123456789'),
        ]);


        Vendor::factory(25) -> create();

        $vendors = Vendor::all();
        
        Category::factory(3) -> has(Section::factory(5) 
                            -> has(Subsection::factory(rand(3,5)) 
                            -> has(Listing::factory(10) -> has(Detail::factory(3)) -> recycle($vendors)
                            ))) -> create();

        $listings = Listing::all(); 

        Customer::factory(10) -> has(Order::factory(5)) -> create();
        $orders = Order::all();
        $details = Detail::all();
        foreach($orders as $order){
            $randomListings = $listings -> random(rand(2,5)) -> unique();
            foreach($randomListings as $listing){
                $details = $listing -> details;
                foreach($details as $detail){
                    OrderListing::factory(1) -> create([
                        'detail_id' => $detail -> id,
                        'listing_id' => $listing -> id,
                        'order_id' => $order -> id,
                        'quantity' => random_int(1, $detail -> inventory),
                    ]);
                }
            } 
        };
    }
}
