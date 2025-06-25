<?php

namespace App\Providers;

use App\Models\Category;
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
            // dd($view->exception);

            if (!$view->exception) {
                if (in_array($requestDomain, $centralDomains)) {
                    $view->with([
                        'user' => auth()->user()
                    ]);
                } else {
                    $tenant = tenant();
                    $user = auth()->user();
                    $categories = Category::with('children')->whereNull('parent_id')->get();
                    if (isset($tenant->data) && $tenant->data != null) {
                        $tenant->data = json_decode($tenant->data);
                    }
                    $hide_catalogo = $tenant->registration_process == 'Mandatory with confirmation' && !$user?->email_verified_at;

                    $email_verified = $user?->email_verified_at ? true : false;

                    $view->with([
                        'user' => $user,
                        'site_settings' =>
                            $tenant,
                        'categories' => $categories,
                        'hide_catalogo' => $hide_catalogo,
                        'email_verified' => $email_verified
                    ]);
                }
            }

        });
    }
}
