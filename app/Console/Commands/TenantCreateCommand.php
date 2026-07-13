<?php

namespace App\Console\Commands;

use App\Services\TenantProvisioningService;
use Illuminate\Console\Command;

/**
 * One-command tenant provisioning: creates the tenant + verified domain,
 * creates its database (if missing), runs tenant migrations, and
 * optionally copies existing data from the central database. Safe to
 * re-run — every step checks what already exists before acting, so a
 * partial failure (e.g. missing DB privileges) can just be fixed and
 * the same command run again to pick up where it left off.
 *
 * Same provisioning logic backs the central admin "manage tenants" page
 * (App\Livewire\Central\TenantManager) via TenantProvisioningService.
 */
class TenantCreateCommand extends Command
{
    protected $signature = 'tenant:create
        {id : Short slug for the tenant, e.g. sinacon}
        {domain : The domain that should resolve to this tenant}
        {--copy-from-central : Copy existing data from the central database into the new tenant database (use for migrating an existing site into its first tenant)}';

    protected $description = 'Provision a tenant end-to-end: tenant record, verified domain, database, migrations, and optional data copy';

    public function handle(TenantProvisioningService $service): int
    {
        try {
            $result = $service->provision(
                $this->argument('id'),
                $this->argument('domain'),
                $this->option('copy-from-central')
            );
        } catch (\Throwable $e) {
            $this->error('Could not create database: ' . $e->getMessage());
            $this->warn(
                "The database user needs CREATE DATABASE privileges. Either run this as your DB root user:\n" .
                "  GRANT ALL PRIVILEGES ON `tenant%`.* TO '" . config('database.connections.mysql.username') . "'@'" . config('database.connections.mysql.host') . "';\n" .
                "  FLUSH PRIVILEGES;\n" .
                "...or create the tenant's database manually via your hosting panel, then re-run this exact command — it will detect the database and continue from here."
            );

            return self::FAILURE;
        }

        foreach ($result['log'] as $line) {
            $this->line($line);
        }

        return self::SUCCESS;
    }
}
