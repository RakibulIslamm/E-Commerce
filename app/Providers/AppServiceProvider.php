<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

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

            Log::info('View rendered:', ['view_name' => $view->getName()]);
            $startTime = microtime(true);

            $requestDomain = request()->getHost();
            $centralDomains = config('tenancy.central_domains', []);
            Log::info("View composer started", ['domain' => $requestDomain]);

            if (!$view->exception) {
                if (in_array($requestDomain, $centralDomains)) {
                    Log::info("Domain is central domain", ['domain' => $requestDomain]);
                    $view->with([
                        'user' => auth()->user()
                    ]);
                } else {
                    Log::info("Domain is tenant domain, fetching tenant data", ['domain' => $requestDomain]);
                    $tenant = tenant();
                    $user = auth()->user();

                    // Recupera da cache o esegue query, cache per 60 minuti
                    $categoriesCache = Cache::remember('categories', 60 * 60, function () {
                        $start = microtime(true);
                        $cats = Category::with('children')
                            ->whereNull('parent_id')
                            ->usedInProducts()
                            ->orderBy('nome')
                            ->get();
                        $duration = microtime(true) - $start;
                        Log::info("Categories fetched from DB", ['count' => $cats->count(), 'duration_seconds' => $duration]);
                        return $cats;
                    });

                    if (isset($tenant->data) && $tenant->data != null) {
                        $tenant->data = json_decode($tenant->data);
                        Log::info("Tenant data decoded");
                    }

                    $hide_catalogo_mandatory = $tenant->registration_process == 'Mandatory' && !$user;
                    $hide_catalogo_mandatory_con_conferma = $tenant->registration_process == 'Mandatory with confirmation' && !$user?->email_verified_at;
                    $email_verified = $user?->email_verified_at ? true : false;

                    Log::info("User and tenant flags", [
                        'user_id' => $user?->id,
                        'hide_catalogo_mandatory' => $hide_catalogo_mandatory,
                        'hide_catalogo_mandatory_con_conferma' => $hide_catalogo_mandatory_con_conferma,
                        'email_verified' => $email_verified,
                    ]);

                    $view->with([
                        'user' => $user,
                        'site_settings' => $tenant,
                        'categories' => $categoriesCache,
                        'hide_catalogo_mandatory_con_conferma' => $hide_catalogo_mandatory_con_conferma,
                        'hide_catalogo_mandatory'=> $hide_catalogo_mandatory,
                        'email_verified' => $email_verified
                    ]);
                }
            } else {
                Log::warning("View exception detected", ['exception' => $view->exception]);
            }

            $totalDuration = microtime(true) - $startTime;
            Log::info("View composer finished", ['duration_seconds' => $totalDuration]);
        });
    }
}
