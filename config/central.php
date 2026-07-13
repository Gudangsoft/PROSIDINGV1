<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Central Admin Password
    |--------------------------------------------------------------------------
    |
    | Single shared password gating the central "manage tenants" pages
    | (routes/central.php, App\Livewire\Central\TenantManager). There's no
    | central-app user model yet, so this is intentionally simple — set a
    | strong value in .env before exposing this to the internet, and
    | replace with real auth once more than one person needs access.
    |
    */
    'admin_password' => env('CENTRAL_ADMIN_PASSWORD'),

];
