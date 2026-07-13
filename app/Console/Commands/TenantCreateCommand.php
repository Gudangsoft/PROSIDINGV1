<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * One-command tenant provisioning: creates the tenant + verified domain,
 * creates its database (if missing), runs tenant migrations, and
 * optionally copies existing data from the central database. Safe to
 * re-run — every step checks what already exists before acting, so a
 * partial failure (e.g. missing DB privileges) can just be fixed and
 * the same command run again to pick up where it left off.
 */
class TenantCreateCommand extends Command
{
    protected $signature = 'tenant:create
        {id : Short slug for the tenant, e.g. sinacon}
        {domain : The domain that should resolve to this tenant}
        {--copy-from-central : Copy existing data from the central database into the new tenant database (use for migrating an existing site into its first tenant)}';

    protected $description = 'Provision a tenant end-to-end: tenant record, verified domain, database, migrations, and optional data copy';

    public function handle(): int
    {
        $id = $this->argument('id');
        $domainName = $this->argument('domain');

        $tenant = Tenant::find($id);
        if ($tenant) {
            $this->info("Tenant '{$id}' already exists — reusing it.");
        } else {
            $tenant = Tenant::create(['id' => $id]);
            $this->info("Tenant '{$id}' created.");
        }

        $domain = $tenant->domains()->where('domain', $domainName)->first();
        if ($domain) {
            $this->info("Domain '{$domainName}' already registered.");
        } else {
            $domain = $tenant->domains()->create(['domain' => $domainName]);
            $this->info("Domain '{$domainName}' registered.");
        }
        if (!$domain->verified_at) {
            $domain->markVerified();
            $this->info('Domain marked verified.');
        }

        $tenantDb = $tenant->database()->getName();
        $dbExists = collect(DB::select('SHOW DATABASES'))->pluck('Database')->contains($tenantDb);

        if (!$dbExists) {
            try {
                $tenant->database()->manager()->createDatabase($tenant);
                $dbExists = true;
                $this->info("Database '{$tenantDb}' created.");
            } catch (\Throwable $e) {
                $this->error("Could not create database '{$tenantDb}': " . $e->getMessage());
                $this->warn(
                    "The database user needs CREATE DATABASE privileges. Either run this as your DB root user:\n" .
                    "  GRANT ALL PRIVILEGES ON `tenant%`.* TO '" . config('database.connections.mysql.username') . "'@'" . config('database.connections.mysql.host') . "';\n" .
                    "  FLUSH PRIVILEGES;\n" .
                    "...or create '{$tenantDb}' manually via your hosting panel, then re-run this exact command — it will detect the database and continue from here."
                );

                return self::FAILURE;
            }
        } else {
            $this->info("Database '{$tenantDb}' already exists.");
        }

        $this->info('Running tenant migrations...');
        $this->call('tenants:migrate', ['--tenants' => [$id]]);

        if ($this->option('copy-from-central')) {
            $this->copyDataFromCentral($tenant, $tenantDb);
        }

        $this->info("Done. '{$domainName}' now resolves to tenant '{$id}'.");

        return self::SUCCESS;
    }

    private function copyDataFromCentral(Tenant $tenant, string $tenantDb): void
    {
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

        // 'settings' first since nothing depends on it and it's a common
        // sanity check; order otherwise doesn't matter with FK checks off.
        $ordered = $tables->contains('settings')
            ? collect(['settings'])->merge($tables->reject(fn ($t) => $t === 'settings'))
            : $tables;

        foreach ($ordered as $table) {
            $srcCount = DB::table($table)->count();
            $dstCountBefore = DB::connection($connectionName)->table($table)->count();

            if ($srcCount === 0 || $dstCountBefore > 0) {
                continue;
            }

            $mainCols = collect(DB::select("SHOW COLUMNS FROM `{$centralDb}`.`{$table}`"))->pluck('Field');
            $tenantCols = collect(DB::connection($connectionName)->select("SHOW COLUMNS FROM `{$table}`"))->pluck('Field');
            $common = $mainCols->intersect($tenantCols)->map(fn ($c) => "`{$c}`")->implode(', ');

            try {
                DB::connection($connectionName)->statement(
                    "INSERT INTO `{$tenantDb}`.`{$table}` ({$common}) SELECT {$common} FROM `{$centralDb}`.`{$table}`"
                );
                $dstCount = DB::connection($connectionName)->table($table)->count();
                $this->line("  {$table}: src={$srcCount} dst={$dstCount} " . ($srcCount === $dstCount ? 'OK' : 'MISMATCH'));
            } catch (\Throwable $e) {
                $this->error("  {$table}: " . $e->getMessage());
            }
        }

        DB::connection($connectionName)->statement('SET FOREIGN_KEY_CHECKS=1');
        $this->info('Data copy from central finished.');
    }
}
