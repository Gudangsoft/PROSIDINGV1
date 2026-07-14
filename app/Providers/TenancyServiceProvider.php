<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Event;
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
                    Jobs\CreateDatabase::class,
                    Jobs\MigrateDatabase::class,
                    // Jobs\SeedDatabase::class,

                    // Your own jobs to prepare the tenant.
                    // Provision API keys, create S3 buckets, anything you want!

                ])->send(function (Events\TenantCreated $event) {
                    return $event->tenant;
                })->shouldBeQueued(false), // `false` by default, but you probably want to make this `true` for production.
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
                    return $event->tenant;
                })->shouldBeQueued(false), // `false` by default, but you probably want to make this `true` for production.
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

            // Fired only when a synced resource is changed in a different DB than the origin DB (to avoid infinite loops)
            Events\SyncedResourceChangedInForeignDatabase::class => [],
        ];
    }

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->bootEvents();
        // Route loading is handled explicitly in bootstrap/app.php (central vs
        // tenant route files registered via the `using` callback) so central
        // routes can be scoped to central_domains before tenant routes are
        // registered. Calling mapRoutes() here would register routes/tenant.php
        // a second time.
        // $this->mapRoutes();

        $this->makeTenancyMiddlewareHighestPriority();

        $this->patchLivewireInternalRoutesForTenancy();
    }

    /**
     * Livewire registers several of its own routes with only 'web'
     * middleware, independently of routes/central.php and routes/tenant.php
     * (see App\Http\Middleware\InitializeTenancyForLivewireUpdate for the
     * full story) — not just the update/AJAX route, but also the
     * file-upload endpoint (livewire.upload-file, used by every
     * WithFileUploads component) and its preview counterpart
     * (livewire.preview-file). All three do this synchronously, very
     * early, in Livewire's own ServiceProvider::boot() — before our route
     * files (or any `$app->booted()` callback registered from our own
     * boot()) run, so there's no reliable "after Livewire, after routing"
     * hook to patch the route object once and be done.
     *
     * The upload endpoint in particular writes temporary files to disk
     * (before the component's own tenant-aware code ever runs) — without
     * tenancy initialized there, uploads get written to the CENTRAL
     * storage location, and then the real ->store() call later (which
     * *is* tenant-aware, since it runs inside the already-fixed
     * livewire.update request) can't find the temp file where it's
     * actually looking, surfacing to the user as "failed to upload" or an
     * upload that spins forever.
     *
     * Instead we hook Illuminate\Routing\Events\RouteMatched, which fires
     * per-request right after the router resolves a route but before its
     * middleware list is gathered — so appending middleware here always
     * takes effect, regardless of provider/route-loading order.
     */
    protected function patchLivewireInternalRoutesForTenancy()
    {
        $targetNames = ['livewire.upload-file', 'livewire.preview-file'];

        Event::listen(\Illuminate\Routing\Events\RouteMatched::class, function ($event) use ($targetNames) {
            $name = $event->route->getName();

            if (! $name) {
                return;
            }

            if (str($name)->endsWith('livewire.update') || in_array($name, $targetNames, true)) {
                $event->route->middleware(\App\Http\Middleware\InitializeTenancyForLivewireUpdate::class);
            }
        });
    }

    protected function bootEvents()
    {
        foreach ($this->events() as $event => $listeners) {
            foreach ($listeners as $listener) {
                if ($listener instanceof JobPipeline) {
                    $listener = $listener->toListener();
                }

                Event::listen($event, $listener);
            }
        }
    }

    protected function mapRoutes()
    {
        $this->app->booted(function () {
            if (file_exists(base_path('routes/tenant.php'))) {
                Route::namespace(static::$controllerNamespace)
                    ->group(base_path('routes/tenant.php'));
            }
        });
    }

    protected function makeTenancyMiddlewareHighestPriority()
    {
        $tenancyMiddleware = [
            // Even higher priority than the initialization middleware
            Middleware\PreventAccessFromCentralDomains::class,

            Middleware\InitializeTenancyByDomain::class,
            Middleware\InitializeTenancyBySubdomain::class,
            Middleware\InitializeTenancyByDomainOrSubdomain::class,
            Middleware\InitializeTenancyByPath::class,
            Middleware\InitializeTenancyByRequestData::class,

            // Wraps InitializeTenancyByDomain for Livewire's own update route
            // (see patchLivewireUpdateRouteForTenancy() below). Needs the same
            // elevated priority so it runs before StartSession/EncryptCookies —
            // otherwise the session would already be started against the
            // wrong (central) storage path by the time tenancy switches it.
            \App\Http\Middleware\InitializeTenancyForLivewireUpdate::class,
        ];

        foreach (array_reverse($tenancyMiddleware) as $middleware) {
            $this->app[\Illuminate\Contracts\Http\Kernel::class]->prependToMiddlewarePriority($middleware);
        }
    }
}
