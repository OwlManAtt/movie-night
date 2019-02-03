<?php

namespace App\Providers;

use App\Services\IMDB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $imdb = new IMDB\OmdbLaravelApi;
        $this->app->instance(IMDB\ImdbApi::class, $imdb);
    } // end register

} // end AppServiceProvider
