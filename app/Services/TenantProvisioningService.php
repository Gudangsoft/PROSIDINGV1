<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/**
 * Core tenant provisioning logic, shared by the `tenant:create` CLI
 * command and the central admin "manage tenants" UI. Every step checks
 * existing state before acting, so calling this repeatedly for the same
 * tenant is safe — a partial failure (e.g. the DB user lacking CREATE
 * DATABASE privileges) can be fixed and provisioning re-run to continue
 * from where it left off.
 */
class TenantProvisioningService
{
    /**
     * @return array{tenant: Tenant, log: string[]}
     */
    public function provision(string $id, string $domainName, bool $copyFromCentral = false): array
    {
        $log = [];

        $tenant = Tenant::find($id);
        if ($tenant) {
            $log[] = "Tenant '{$id}' already exists — reusing it.";
        } else {
            $tenant = Tenant::create(['id' => $id]);
            $log[] = "Tenant '{$id}' created.";
        }

        $domain = $tenant->domains()->where('domain', $domainName)->first();
        if ($domain) {
            $log[] = "Domain '{$domainName}' already registered.";
        } else {
            $domain = $tenant->domains()->create(['domain' => $domainName]);
            $log[] = "Domain '{$domainName}' registered.";
        }
        if (!$domain->verified_at) {
            $domain->markVerified();
            $log[] = 'Domain marked verified.';
        }

        $tenantDb = $tenant->database()->getName();
        $dbExists = collect(DB::select('SHOW DATABASES'))->pluck('Database')->contains($tenantDb);

        if (!$dbExists) {
            $tenant->database()->manager()->createDatabase($tenant);
            $dbExists = true;
            $log[] = "Database '{$tenantDb}' created.";
        } else {
            $log[] = "Database '{$tenantDb}' already exists.";
        }

        $log[] = 'Running tenant migrations...';
        Artisan::call('tenants:migrate', ['--tenants' => [$id]]);
        $log[] = trim(Artisan::output()) ?: 'Migrations up to date.';

        if ($copyFromCentral) {
            $log = array_merge($log, $this->copyDataFromCentral($tenant, $tenantDb));
        }

        $log[] = "Done. '{$domainName}' now resolves to tenant '{$id}'.";

        return ['tenant' => $tenant, 'log' => $log];
    }

    /**
     * @return string[]
     */
    private function copyDataFromCentral(Tenant $tenant, string $tenantDb): array
    {
        $log = [];

        // Must be the literal 'mysql' connection, never DB::connection()'s
        // implicit default — this runs from web requests too (the "Kelola
        // Tenant" page embedded in a tenant's own dashboard), where the
        // default connection is whichever tenant is currently active, not
        // central. Reading through the default here previously copied the
        // ACTIVE tenant's own data into the new tenant instead of central's.
        $centralConnection = 'mysql';
        $centralDb = config('database.connections.mysql.database');
        $connectionName = 'tenant_copy_tmp';

        config(["database.connections.{$connectionName}" => array_merge(
            config('database.connections.mysql'),
            ['database' => $tenantDb]
        )]);

        DB::connection($connectionName)->statement('SET FOREIGN_KEY_CHECKS=0');

        $tables = collect(DB::connection($connectionName)->select('SHOW TABLES'))
            ->map(fn ($t) => array_values((array) $t)[0])
            ->reject(fn ($t) => $t === 'migrations');

        // Only tables that actually exist in central have anything to copy —
        // tenant-only tables (users, papers, payments, ...) have no central
        // counterpart at all and would otherwise blow up on SHOW COLUMNS.
        $centralTables = collect(DB::connection($centralConnection)->select('SHOW TABLES'))
            ->map(fn ($t) => array_values((array) $t)[0]);
        $tables = $tables->intersect($centralTables);

        $ordered = $tables->contains('settings')
            ? collect(['settings'])->merge($tables->reject(fn ($t) => $t === 'settings'))
            : $tables;

        foreach ($ordered as $table) {
            $srcCount = DB::connection($centralConnection)->table($table)->count();
            $dstCountBefore = DB::connection($connectionName)->table($table)->count();

            if ($srcCount === 0 || $dstCountBefore > 0) {
                continue;
            }

            $mainCols = collect(DB::connection($centralConnection)->select("SHOW COLUMNS FROM `{$table}`"))->pluck('Field');
            $tenantCols = collect(DB::connection($connectionName)->select("SHOW COLUMNS FROM `{$table}`"))->pluck('Field');
            $common = $mainCols->intersect($tenantCols)->map(fn ($c) => "`{$c}`")->implode(', ');

            try {
                DB::connection($connectionName)->statement(
                    "INSERT INTO `{$tenantDb}`.`{$table}` ({$common}) SELECT {$common} FROM `{$centralDb}`.`{$table}`"
                );
                $dstCount = DB::connection($connectionName)->table($table)->count();
                $log[] = "  {$table}: src={$srcCount} dst={$dstCount} " . ($srcCount === $dstCount ? 'OK' : 'MISMATCH');
            } catch (\Throwable $e) {
                $log[] = "  {$table}: ERROR " . $e->getMessage();
            }
        }

        DB::connection($connectionName)->statement('SET FOREIGN_KEY_CHECKS=1');
        $log[] = 'Data copy from central finished.';

        return $log;
    }
}
