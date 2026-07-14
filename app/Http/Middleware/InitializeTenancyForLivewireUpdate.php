<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Contracts\TenantCouldNotBeIdentifiedException;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

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
 * can't just get PreventAccessFromCentralDomains bolted on.
 *
 * This used to check config('tenancy.central_domains') to decide whether to
 * skip tenancy init — but that broke domains that are deliberately BOTH a
 * real tenant site AND the central admin hub for other tenants on the same
 * server (e.g. conference.appihi.or.id): being listed as "central" made
 * every Livewire interaction on that domain's own tenant pages skip tenancy
 * and fall back to the central DB, which has no `users` table (users are
 * tenant-only).
 *
 * Instead, actually attempt to resolve a tenant for the request's host
 * first: if one exists, initialize tenancy for it — regardless of whether
 * the domain is also central. Only fall back to the central_domains check
 * when no tenant matches at all, so genuinely central-only hosts (127.0.0.1
 * in local dev, or a dedicated admin-only domain with no tenant of its own)
 * still pass through untouched, while a host that's neither a known tenant
 * nor a configured central domain still gets rejected (404, same as a
 * normal tenant page load would).
 */
class InitializeTenancyForLivewireUpdate
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();

        try {
            app(DomainTenantResolver::class)->resolve($host);
        } catch (TenantCouldNotBeIdentifiedException $e) {
            if (in_array($host, config('tenancy.central_domains', []), true)) {
                return $next($request);
            }

            throw $e;
        }

        return app(InitializeTenancyByDomain::class)->handle($request, $next);
    }
}
