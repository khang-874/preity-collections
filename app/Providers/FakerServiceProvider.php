<?php

namespace App\Providers;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;

class FakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $locale ??= app('config')->get('app.faker_locale') ?? 'en_US';
        $abstract = Generator::class.':'.$locale;

        $this->app->afterResolving($abstract, function (Generator $instance) {
            $instance->addProvider(new \Mmo\Faker\PicsumProvider($instance));
        }); 
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
