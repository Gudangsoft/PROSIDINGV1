<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Lightweight gate for the central admin (tenant management) pages.
 * There's no central-app user model yet — this is a single shared
 * password (config('tenancy.central_admin_password'), i.e.
 * CENTRAL_ADMIN_PASSWORD in .env) stored in the session after a
 * successful login. Good enough for a single-operator setup; replace
 * with real central-app auth before onboarding other admins.
 */
class EnsureCentralAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! session('central_admin_authenticated')) {
            // Plain path, not route(): routes/central.php is registered once
            // per central domain with a domain-specific name prefix
            // (central.{domain}.*), so a single portable route() reference
            // isn't available here. Carry the intended URL forward so login
            // can send the user back to it (this route may live on a tenant
            // domain, e.g. /admin/platform-tenants, not just central ones).
            return redirect('/admin/login?redirect=' . urlencode($request->fullUrl()));
        }

        return $next($request);
    }
}
