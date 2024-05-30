<?php

namespace App\Providers;

use App\Services\PleskAPI;
use Illuminate\Support\ServiceProvider;

class PleskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PleskAPI::class, function ($app) {
            $config = $app['config']['services.plesk'];
            return new PleskAPI(
                $config['base_url'],
                $config['username'],
                $config['password']
            );
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
