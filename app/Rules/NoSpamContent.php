<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Flags free-text input that looks like bot/spam content: promotional
 * keywords, link-stuffing, or unnatural character repetition. Intended for
 * public-facing text fields (registration notes, research interests, etc.)
 * where NoScriptTags alone doesn't cover non-HTML spam.
 */
class NoSpamContent implements ValidationRule
{
    private const BLOCKED_KEYWORDS = [
        'viagra', 'cialis', 'casino', 'poker online', 'judi online', 'slot gacor',
        'togel', 'bandar bola', 'situs slot', 'agen judi', 'porn', 'xxx', 'escort',
        'bitcoin investment', 'forex signal', 'crypto giveaway', 'loan approved',
        'work from home', 'buy followers', 'seo backlink', 'cheap replica',
        'penis enlargement', 'weight loss pill',
    ];

    public function __construct(private ?int $maxLinks = null)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || $value === '') {
            return;
        }

        $lower = mb_strtolower($value);

        foreach (self::BLOCKED_KEYWORDS as $keyword) {
            if (str_contains($lower, $keyword)) {
                $fail('Isian mengandung konten yang terindikasi spam.');

                return;
            }
        }

        $maxLinks = $this->maxLinks ?? (int) config('security.spam.max_links', 3);
        $linkCount = preg_match_all('#https?://|www\.#i', $value);
        if ($linkCount > $maxLinks) {
            $fail('Isian mengandung terlalu banyak tautan.');

            return;
        }

        if (preg_match('/(.)\1{9,}/u', $value)) {
            $fail('Isian mengandung karakter berulang yang tidak wajar.');
        }
    }
}
