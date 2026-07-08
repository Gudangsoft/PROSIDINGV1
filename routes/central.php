<?php

declare(strict_types=1);

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
