<?php

declare(strict_types=1);

namespace App\Providers;

use App\Jobs\SeedTenantJob;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Stancl\JobPipeline\JobPipeline;
use Stancl\Tenancy\Events;
use Stancl\Tenancy\Jobs;
use Stancl\Tenancy\Listeners;
use Stancl\Tenancy\Middleware;

class TenancyServiceProvider extends ServiceProvider
{
    // By default, no namespace is used to support the callable array syntax.
    public static string $controllerNamespace = '';

    public function events()
    {
        return [
            // Tenant events
            Events\CreatingTenant::class => [],
            Events\TenantCreated::class => [
                JobPipeline::make([
                    // Jobs\CreateDatabase::class,
                    Jobs\MigrateDatabase::class,
                    // Jobs\SeedDatabase::class,
                    SeedTenantJob::class,
                    // Your own jobs to prepare the tenant.
                ])->send(function (Events\TenantCreated $event) {
                    Log::info('TenantCreated event for tenant id: ' . $event->tenant->id . ' at ' . now());
                    return $event->tenant;
                })->shouldBeQueued(false), // Cambia in true per produzione, ma in debug tienilo false
            ],
            Events\SavingTenant::class => [],
            Events\TenantSaved::class => [],
            Events\UpdatingTenant::class => [],
            Events\TenantUpdated::class => [],
            Events\DeletingTenant::class => [],
            Events\TenantDeleted::class => [
                JobPipeline::make([
                    Jobs\DeleteDatabase::class,
                ])->send(function (Events\TenantDeleted $event) {
                    Log::info('TenantDeleted event for tenant id: ' . $event->tenant->id . ' at ' . now());
                    return $event->tenant;
                })->shouldBeQueued(false),
            ],

            // Domain events
            Events\CreatingDomain::class => [],
            Events\DomainCreated::class => [],
            Events\SavingDomain::class => [],
            Events\DomainSaved::class => [],
            Events\UpdatingDomain::class => [],
            Events\DomainUpdated::class => [],
            Events\DeletingDomain::class => [],
            Events\DomainDeleted::class => [],

            // Database events
            Events\DatabaseCreated::class => [],
            Events\DatabaseMigrated::class => [],
            Events\DatabaseSeeded::class => [],
            Events\DatabaseRolledBack::class => [],
            Events\DatabaseDeleted::class => [],

            // Tenancy events
            Events\InitializingTenancy::class => [],
            Events\TenancyInitialized::class => [
                Listeners\BootstrapTenancy::class,
            ],

            Events\EndingTenancy::class => [],
            Events\TenancyEnded::class => [
                Listeners\RevertToCentralContext::class,
            ],

            Events\BootstrappingTenancy::class => [],
            Events\TenancyBootstrapped::class => [],
            Events\RevertingToCentralContext::class => [],
            Events\RevertedToCentralContext::class => [],

            // Resource syncing
            Events\SyncedResourceSaved::class => [
                Listeners\UpdateSyncedResource::class,
            ],

            Events\SyncedResourceChangedInForeignDatabase::class => [],
        ];
    }

    public function register()
    {
        //
    }

    public function boot()
    {
        Log::info('TenancyServiceProvider boot started at ' . now());
        $start = microtime(true);

        $this->bootEvents();
        Log::info('After bootEvents at ' . now());

        $this->mapRoutes();
        Log::info('After mapRoutes at ' . now());

        $this->makeTenancyMiddlewareHighestPriority();
        Log::info('After makeTenancyMiddlewareHighestPriority at ' . now());

        $end = microtime(true);
        Log::info('TenancyServiceProvider boot finished in ' . round($end - $start, 4) . ' seconds');
    }

    protected function bootEvents()
    {
        $start = microtime(true);
        Log::info('bootEvents started at ' . now());

        foreach ($this->events() as $event => $listeners) {
            foreach ($listeners as $listener) {
                if ($listener instanceof JobPipeline) {
                    $listener = $listener->toListener();
                }

                Log::info("Registering listener for event: $event at " . now());
                Event::listen($event, $listener);
                Log::info("Listener registered for event: $event at " . now());
            }
        }

        $end = microtime(true);
        Log::info('bootEvents finished in ' . round($end - $start, 4) . ' seconds');
    }

    protected function mapRoutes()
    {
        $start = microtime(true);
        Log::info('mapRoutes started at ' . now());

        $this->app->booted(function () {
            if (file_exists(base_path('routes/tenant.php'))) {
                Route::namespace(static::$controllerNamespace)
                    ->group(base_path('routes/tenant.php'));
                Log::info('Tenant routes loaded at ' . now());
            } else {
                Log::warning('routes/tenant.php not found at ' . now());
            }
        });

        $end = microtime(true);
        Log::info('mapRoutes finished in ' . round($end - $start, 4) . ' seconds');
    }

    protected function makeTenancyMiddlewareHighestPriority()
    {
        Log::info('makeTenancyMiddlewareHighestPriority started at ' . now());

        $tenancyMiddleware = [
            Middleware\PreventAccessFromCentralDomains::class,

            Middleware\InitializeTenancyByDomain::class,
            Middleware\InitializeTenancyBySubdomain::class,
            Middleware\InitializeTenancyByDomainOrSubdomain::class,
            Middleware\InitializeTenancyByPath::class,
            Middleware\InitializeTenancyByRequestData::class,
        ];

        foreach (array_reverse($tenancyMiddleware) as $middleware) {
            $this->app[\Illuminate\Contracts\Http\Kernel::class]->prependToMiddlewarePriority($middleware);
        }

        Log::info('makeTenancyMiddlewareHighestPriority finished at ' . now());
    }
}
