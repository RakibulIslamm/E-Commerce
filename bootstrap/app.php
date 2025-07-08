<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\BasicAuthenticate;
use App\Http\Middleware\CheckCentralDomain;
use App\Http\Middleware\Creator;
use App\Http\Middleware\Editor;
use App\Http\Middleware\RegistrationProcess;
use App\Http\Middleware\RequestTracker;
use App\Http\Middleware\User;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            foreach (config('tenancy.central_domains', []) as $domain) {
                Route::middleware('web')
                    ->domain($domain)
                    ->group(base_path('routes/web.php'));
            }
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            \Illuminate\Http\Middleware\HandleCors::class,

        ]);
     
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);

        $middleware->alias([
            'admin' => Admin::class,
            'editor' => Editor::class,
            'creator' => Creator::class,
            'user' => User::class,
            'central_domain' => CheckCentralDomain::class,
            'track_user' => RequestTracker::class,
            'registration_process' => RegistrationProcess::class,
            'auth.basic' => BasicAuthenticate::class,
        ]);

        $middleware->redirectUsersTo(function () {
            if (Auth::check() && tenant()) {
                return route('app.dashboard');
            }
            return route('dashboard');
        });

        $middleware->redirectGuestsTo(function () {
            if (!Auth::check() && tenant()) {
                return route('app.login');
            }
            return route('central.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // dd($exceptions);
    })->create();
