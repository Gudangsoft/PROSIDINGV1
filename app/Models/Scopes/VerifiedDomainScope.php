<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Custom domains must prove ownership (DNS verification) before they're
 * allowed to resolve to a tenant — otherwise anyone could point an
 * arbitrary domain at our server and potentially confuse/hijack routing
 * for it. This scope hides unverified domain rows from every query that
 * doesn't explicitly opt out (e.g. the admin "pending domains" screen).
 */
class VerifiedDomainScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereNotNull($model->getTable() . '.verified_at');
    }
}
