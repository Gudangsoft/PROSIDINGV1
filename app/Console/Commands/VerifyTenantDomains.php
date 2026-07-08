<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Models\Scopes\VerifiedDomainScope;
use Illuminate\Console\Command;

/**
 * Checks DNS for every domain still pending verification and marks it
 * verified once its TXT record matches. Intended to run on a schedule
 * (e.g. every few minutes) so a tenant's custom domain goes live shortly
 * after they add the DNS record, without needing a manual admin action.
 */
class VerifyTenantDomains extends Command
{
    protected $signature = 'app:verify-tenant-domains';

    protected $description = 'Check DNS for pending tenant domains and mark verified ones as active';

    public function handle(): int
    {
        $pending = Domain::withoutGlobalScope(VerifiedDomainScope::class)
            ->whereNull('verified_at')
            ->get();

        if ($pending->isEmpty()) {
            $this->info('No pending domains to check.');

            return self::SUCCESS;
        }

        foreach ($pending as $domain) {
            if ($domain->dnsRecordMatches()) {
                $domain->markVerified();
                $this->info("Verified: {$domain->domain}");
            } else {
                $this->line("Still pending: {$domain->domain} (expected TXT at {$domain->verificationRecordName()})");
            }
        }

        return self::SUCCESS;
    }
}
