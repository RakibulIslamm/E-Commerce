<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 'central_app.layouts.app', 'central_app.layouts.guest', 'central_app.layouts.navigation'
        // Only bind view composer to specific layouts (not all views)
        View::composer(['app.layouts.guest', 'app.layouts.app', 'app.components.Home.products.Partials.product-item', 'app.components.Home.products.Partials.product-item-list', 'app.pages.products.show'], function ($view) {
            static $cache = [];

            $requestDomain = request()->getHost();
            $centralDomains = config('tenancy.central_domains', []);
            $isLocal = app()->environment('local');

            if ($isLocal) {
                Log::info('Rendering view', [
                    'view' => $view->getName(),
                    'domain' => $requestDomain,
                ]);
            }

            // Central domain logic (no tenant)
            if (in_array($requestDomain, $centralDomains)) {
                $cache['user'] ??= auth()->user();

                $view->with([
                    'user' => $cache['user'],
                ]);

                if ($isLocal) {
                    Log::info('Central domain detected — no tenant logic applied');
                }

                return;
            }

            // Load tenant once
            $cache['tenant'] ??= tenant();
            $tenant = $cache['tenant'];

            if (isset($tenant->data) && is_string($tenant->data)) {
                $tenant->data = json_decode($tenant->data);
                if ($isLocal) {
                    Log::info('Tenant data decoded');
                }
            }

            // Authenticated user
            $cache['user'] ??= auth()->user();
            $user = $cache['user'];

            // Load categories using session
            $tenantId = $tenant->id ?? 'default';
            $sessionKey = "categories_tenant_{$tenantId}";

            if (!Session::has($sessionKey)) {
                $cache['categories'] = Category::with('children')
                    ->whereNull('parent_id')
                    ->usedInProducts()
                    ->orderBy('nome')
                    ->get();

                Session::put($sessionKey, $cache['categories']);

                if ($isLocal) {
                    Log::info('Categories fetched from DB and stored in session', [
                        'count' => $cache['categories']->count(),
                        'session_key' => $sessionKey,
                    ]);
                }
            } else {
                $cache['categories'] = Session::get($sessionKey);

                if ($isLocal) {
                    Log::info('Categories loaded from session', [
                        'count' => $cache['categories']->count(),
                        'session_key' => $sessionKey,
                    ]);
                }
            }

            $categories = $cache['categories'];

            // Flags for catalog visibility
            $hideCatalogoMandatory = $tenant->registration_process === 'Mandatory' && !$user;
            $hideCatalogoMandatoryConConferma = $tenant->registration_process === 'Mandatory with confirmation' && !$user?->email_verified_at;
            $emailVerified = (bool) $user?->email_verified_at;

            if ($isLocal) {
                Log::info('Flags computed', [
                    'user_id' => $user?->id,
                    'hide_catalogo_mandatory' => $hideCatalogoMandatory,
                    'hide_catalogo_mandatory_con_conferma' => $hideCatalogoMandatoryConConferma,
                    'email_verified' => $emailVerified,
                ]);
            }

            $view->with([
                'user' => $user,
                'site_settings' => $tenant,
                'categories' => $categories,
                'hide_catalogo_mandatory' => $hideCatalogoMandatory,
                'hide_catalogo_mandatory_con_conferma' => $hideCatalogoMandatoryConConferma,
                'email_verified' => $emailVerified,
            ]);
        });
    }
}
