<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ClamAV Antivirus Integration
    |--------------------------------------------------------------------------
    |
    | Optional. If a ClamAV daemon/CLI is installed on the server, enable
    | this to layer a real antivirus scan on top of the built-in static
    | checks in App\Helpers\MalwareScanner. Safe to leave disabled — most
    | shared hosting doesn't have ClamAV installed, and the scanner fails
    | open (never blocks an upload) when the binary is unavailable.
    |
    */
    'clamav' => [
        'enabled' => env('CLAMAV_ENABLED', false),
        'binary' => env('CLAMAV_BINARY', 'clamscan'),
        'timeout' => env('CLAMAV_TIMEOUT', 15),
    ],

    /*
    |--------------------------------------------------------------------------
    | Anti-Spam
    |--------------------------------------------------------------------------
    |
    | Tuning for App\Rules\NoSpamContent and the honeypot time-trap used on
    | public forms (registration, reviewer registration, etc).
    |
    */
    'spam' => [
        'max_links' => env('SPAM_MAX_LINKS', 3),
        'honeypot_min_seconds' => env('SPAM_HONEYPOT_MIN_SECONDS', 2),
    ],

];
