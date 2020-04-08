<?php

namespace Kurt\Rating;

use Illuminate\Support\ServiceProvider;

class RatingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $migrationsPath = app()->basePath().'/database/migrations/'.date('Y_m_d_His').'_create_ratings_table.php';

        $this->publishes([
            __DIR__.'/../migrations/create_ratings_table.php' => $migrationsPath,
        ], 'rating');
    }

    /**
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('rating', function () {
            return new Rating;
        });
    }
}
