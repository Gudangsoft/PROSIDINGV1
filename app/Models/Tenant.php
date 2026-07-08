<?php

namespace App\Models;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

/**
 * Custom fields (name, plan, status, etc.) don't need their own migration —
 * the base Tenant model's HasDataColumn concern exposes the `data` JSON
 * column via magic properties, e.g. $tenant->name, $tenant->plan.
 */
class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
}
