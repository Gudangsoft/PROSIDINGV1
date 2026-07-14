<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

/**
 * Livewire registers its own AJAX "update" route directly (see
 * vendor/livewire/livewire/src/Mechanisms/HandleRequests/HandleRequests.php),
 * completely outside of routes/central.php and routes/tenant.php, with only
 * the 'web' middleware group. That meant every Livewire component
 * interaction (button clicks, form submits, etc.) ran against the CENTRAL
 * database regardless of which tenant domain the page was loaded from —
 * the same class of bug fixed for Fortify in config/fortify.php.
 *
 * Unlike Fortify's routes (which are tenant-only), this single endpoint is
 * shared by Livewire components on both central and tenant pages, so it
 * can't just get PreventAccessFromCentralDomains bolted on — central
 * requests need to pass through untouched, tenant requests need tenancy
 * initialized.
 */
class InitializeTenancyForLivewireUpdate
{
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->getHost(), config('tenancy.central_domains', []), true)) {
            return $next($request);
        }

        return app(InitializeTenancyByDomain::class)->handle($request, $next);
    }
}
