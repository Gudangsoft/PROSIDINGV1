<?php

namespace App\Livewire\Concerns;

/**
 * Bot-mitigation for public Livewire forms: a hidden honeypot field plus a
 * minimum time-to-submit check. Real visitors never fill the honeypot and
 * never submit within a couple seconds of the form rendering; form-filling
 * bots that auto-populate every field and submit instantly do.
 *
 * Usage: `use HasHoneypot;`, add a hidden `wire:model="website"` input to
 * the view (see resources/views/livewire/auth/reviewer-register.blade.php
 * for an example), then guard the submit handler with `isSpamSubmission()`.
 */
trait HasHoneypot
{
    // Named to look like a normal field to bots; hidden from real users via CSS in the view.
    public string $website = '';

    public ?int $formRenderedAt = null;

    public function initializeHasHoneypot(): void
    {
        $this->formRenderedAt = now()->timestamp;
    }

    protected function isSpamSubmission(): bool
    {
        if (trim($this->website) !== '') {
            return true;
        }

        $minSeconds = (int) config('security.spam.honeypot_min_seconds', 2);

        return $this->formRenderedAt !== null
            && (now()->timestamp - $this->formRenderedAt) < $minSeconds;
    }
}
