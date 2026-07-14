<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * FilesystemTenancyBootstrapper reroutes the global asset() helper through
 * Stancl\Tenancy\Controllers\TenantAssetsController's route
 * (/tenancy/assets/{path}) whenever tenancy is active, which resolves
 * $path directly against storage_path("app/public/$path") — no "storage"
 * segment expected.
 *
 * But every asset('storage/' . $x) call in this codebase (the standard
 * Laravel convention for the public disk's symlink, used ~60+ places:
 * conference logos, certificates, sliders, papers, tutorials, ...) passes
 * $path WITH that "storage/" prefix, since that's what's needed when
 * asset() ISN'T tenancy-rerouted (central context, or tenancy disabled).
 * Rerouted, that prefix makes the controller look for a nonexistent
 * nested storage/app/public/storage/... folder — a 404 on every image on
 * every tenant page, site-wide.
 *
 * Stripping a leading "storage/" here — once, at the route — fixes every
 * one of those call sites without having to touch any of them, and
 * without needing to override stancl's own route/controller.
 */
class NormalizeTenantAssetPath
{
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();
        $path = $route?->parameter('path');

        if (is_string($path) && str_starts_with($path, 'storage/')) {
            $route->setParameter('path', substr($path, strlen('storage/')));
        }

        return $next($request);
    }
}
