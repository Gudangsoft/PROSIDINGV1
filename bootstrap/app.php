<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function () {
            // Central routes first, scoped to each central domain — the SaaS
            // product site itself (config('tenancy.central_domains')).
            // routes/central.php gets loaded once per configured central
            // domain, so each route inside it would otherwise be registered
            // under the exact same name multiple times — harmless at runtime,
            // but `route:cache`/`optimize` refuses to compile duplicate
            // route names. Prefixing per domain keeps every registration
            // unique without needing route() lookups anywhere for these.
            foreach (config('tenancy.central_domains') as $domain) {
                \Illuminate\Support\Facades\Route::middleware('web')
                    ->domain($domain)
                    ->name("central.{$domain}.")
                    ->group(base_path('routes/central.php'));
            }

            // Tenant routes (the whole Prosiding app) registered after —
            // routes/tenant.php self-scopes via InitializeTenancyByDomain +
            // PreventAccessFromCentralDomains, so it only ever resolves for
            // a domain that belongs to a tenant.
            \Illuminate\Support\Facades\Route::middleware('web')
                ->group(base_path('routes/tenant.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register custom middleware aliases
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'activity.log' => \App\Http\Middleware\ActivityLogger::class,
        ]);

        // Apply security headers to all web routes
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        // Configure throttle limits
        $middleware->throttleApi();
        
        // Apply activity logger to authenticated routes
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\ActivityLogger::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // A domain that doesn't belong to any tenant is a 404 (unrecognized
        // site), not a 500 (server fault) — matters both for visitor UX and
        // for not polluting error monitoring with every stray/typo'd Host header.
        $exceptions->render(function (\Stancl\Tenancy\Contracts\TenantCouldNotBeIdentifiedException $e) {
            abort(404);
        });
    })->create();
