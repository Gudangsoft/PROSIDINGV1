<?php

declare(strict_types=1);

use App\Http\Controllers\Central\CentralAdminAuthController;
use App\Models\Domain;
use App\Models\Scopes\VerifiedDomainScope;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Central Routes
|--------------------------------------------------------------------------
|
| These routes only resolve on config('tenancy.central_domains') — the
| SaaS product site itself, not any tenant's conference site. This is a
| placeholder for now; the real central app (marketing page, tenant
| signup/onboarding, domain management, super-admin panel) is future work.
|
*/

Route::get('/', function () {
    return 'Prosiding SaaS — central app placeholder. Tenant sites are served on their own domains.';
})->name('home');

/*
|--------------------------------------------------------------------------
| Central Admin — Tenant Management
|--------------------------------------------------------------------------
|
| Gated by a single shared password (App\Http\Middleware\EnsureCentralAdmin)
| rather than a full auth system — see that class's docblock. Views use
| plain paths (not route()) since these routes are registered once per
| central domain with a domain-specific name prefix.
|
*/
Route::get('/admin/login', [CentralAdminAuthController::class, 'showLogin']);
Route::post('/admin/login', [CentralAdminAuthController::class, 'login']);
Route::post('/admin/logout', [CentralAdminAuthController::class, 'logout']);

Route::middleware(\App\Http\Middleware\EnsureCentralAdmin::class)->group(function () {
    Route::get('/admin/tenants', \App\Livewire\Central\TenantManager::class);
});

/*
|--------------------------------------------------------------------------
| Caddy On-Demand TLS "ask" endpoint
|--------------------------------------------------------------------------
|
| Caddy calls this before issuing a Let's Encrypt certificate for a domain
| it hasn't seen before, with ?domain=whatever-was-in-the-sni-hello. We
| only return 200 for domains that have completed DNS ownership
| verification — otherwise anyone could point a random domain at this
| server's IP and get us to issue them a certificate / serve tenant data
| under domain confusion. See config/caddy/Caddyfile.example.
|
*/
Route::get('/internal/domain-check', function (\Illuminate\Http\Request $request) {
    $domain = $request->query('domain');

    if (!$domain) {
        abort(400);
    }

    $isVerifiedTenantDomain = Domain::withoutGlobalScope(VerifiedDomainScope::class)
        ->where('domain', $domain)
        ->whereNotNull('verified_at')
        ->exists();

    $isCentralDomain = in_array($domain, config('tenancy.central_domains'), true);

    if ($isVerifiedTenantDomain || $isCentralDomain) {
        return response('ok', 200);
    }

    abort(404);
})->name('domain-check');
