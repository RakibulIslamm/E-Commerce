<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $requestDomain = request()->getHost();
            $centralDomains = config('tenancy.central_domains', []);

            if (in_array($requestDomain, $centralDomains)) {
                $view->with([
                    'user' => auth()->user()
                ]);
            } else {
                $tenant = tenant();
                if ($tenant->data != null) {
                    $tenant->data = json_decode($tenant->data);
                }
                $view->with([
                    'user' => auth()->user(),
                    'site_settings' =>
                        $tenant,
                ]);
            }
        });
    }
}
