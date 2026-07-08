<?php

namespace App\Models;

use App\Models\Scopes\VerifiedDomainScope;
use Illuminate\Support\Str;
use Stancl\Tenancy\Database\Models\Domain as BaseDomain;

/**
 * @property string $verification_token
 * @property \Illuminate\Support\Carbon|null $verified_at
 */
class Domain extends BaseDomain
{
    protected static function booted(): void
    {
        static::addGlobalScope(new VerifiedDomainScope());

        static::creating(function (Domain $domain) {
            if (empty($domain->verification_token)) {
                $domain->verification_token = Str::random(32);
            }
        });
    }

    public function isVerified(): bool
    {
        return $this->verified_at !== null;
    }

    public function markVerified(): void
    {
        $this->forceFill(['verified_at' => now()])->save();
    }

    /**
     * The TXT record name the domain owner must create to prove control:
     *   _prosiding-verify.{domain}  TXT  "{verification_token}"
     */
    public function verificationRecordName(): string
    {
        return '_prosiding-verify.' . $this->domain;
    }

    /**
     * Check DNS for the expected TXT record. Safe to call repeatedly
     * (e.g. from a scheduled job) — does not mark verified itself.
     */
    public function dnsRecordMatches(): bool
    {
        $records = @dns_get_record($this->verificationRecordName(), DNS_TXT);
        if (!$records) {
            return false;
        }

        foreach ($records as $record) {
            if (($record['txt'] ?? null) === $this->verification_token) {
                return true;
            }
        }

        return false;
    }
}
