<?php

namespace App\Providers;

use App\Services\IMDB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'movie' => \App\Models\Movie::class,
            'series' => \App\Models\Series::class,
            'episode' => \App\Models\SeriesEpisode::class,
        ]);
    } // end boot

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $imdb = new IMDB\OmdbLaravelApi;
        $this->app->instance(IMDB\ImdbApi::class, $imdb);

        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    } // end register
} // end AppServiceProvider
