<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
            // Log solo in locale
            if (app()->environment('local')) {
                Log::info('View rendered:', ['view_name' => $view->getName()]);
                Log::info('View composer started', ['domain' => request()->getHost()]);
            }

            static $categories = null;
            static $tenant = null;
            static $user = null;

            $requestDomain = request()->getHost();
            $centralDomains = config('tenancy.central_domains', []);

            if (in_array($requestDomain, $centralDomains)) {
                if (!$user) {
                    $user = auth()->user();
                }

                $view->with([
                    'user' => $user
                ]);

                if (app()->environment('local')) {
                    Log::info('Domain is central domain');
                    Log::info('View composer finished');
                }

                return;
            }

            // Caricamento tenant e user una sola volta
            if (!$tenant) {
                $tenant = tenant();
                if (isset($tenant->data) && $tenant->data !== null) {
                    $tenant->data = json_decode($tenant->data);
                    if (app()->environment('local')) {
                        Log::info('Tenant data decoded');
                    }
                }
            }

            if (!$user) {
                $user = auth()->user();
            }

            // Categories da sessione, se non presente caricala da DB e salva in sessione
            if (!$categories) {
                if (!Session::has('categories')) {
                    $categories = Category::with('children')
                        ->whereNull('parent_id')
                        ->usedInProducts()
                        ->orderBy('nome')
                        ->get();

                    Session::put('categories', $categories);

                    if (app()->environment('local')) {
                        Log::info('Categories fetched from DB and saved in session', ['count' => $categories->count()]);
                    }
                } else {
                    $categories = Session::get('categories');

                    if (app()->environment('local')) {
                        Log::info('Categories loaded from session', ['count' => $categories->count()]);
                    }
                }
            }

            $hide_catalogo_mandatory = $tenant->registration_process == 'Mandatory' && !$user;
            $hide_catalogo_mandatory_con_conferma = $tenant->registration_process == 'Mandatory with confirmation' && !$user?->email_verified_at;
            $email_verified = $user?->email_verified_at ? true : false;

            if (app()->environment('local')) {
                Log::info('User and tenant flags', [
                    'user_id' => $user?->id,
                    'hide_catalogo_mandatory' => $hide_catalogo_mandatory,
                    'hide_catalogo_mandatory_con_conferma' => $hide_catalogo_mandatory_con_conferma,
                    'email_verified' => $email_verified,
                ]);
                Log::info('View composer finished');
            }

            $view->with([
                'user' => $user,
                'site_settings' => $tenant,
                'categories' => $categories,
                'hide_catalogo_mandatory_con_conferma' => $hide_catalogo_mandatory_con_conferma,
                'hide_catalogo_mandatory' => $hide_catalogo_mandatory,
                'email_verified' => $email_verified
            ]);
        });
    }
}
