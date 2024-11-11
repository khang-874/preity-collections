<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Listing;
use App\Models\Order;
use App\Models\OrderListing;
use App\Observers\CustomerObserver;
use App\Observers\ListingObserver;
use App\Observers\OrderListingObserver;
use App\Observers\OrderObserver;
use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // if (!$this->app->environment('production')) {
        //     $this->app->register('App\Providers\FakerServiceProvider');
        // }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Model::unguard();
        Listing::observe(ListingObserver::class);
        Order::observe(OrderObserver::class);
        Customer::observe(CustomerObserver::class);
        OrderListing::observe(OrderListingObserver::class);
    }
}
