<?php

namespace App\Jobs;

use App\Models\WaBlast;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWaBlastJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 3600; // 1 hour max

    public function __construct(
        public readonly int $blastId
    ) {}

    public function handle(): void
    {
        $blast = WaBlast::find($this->blastId);
        if (!$blast || $blast->status === 'completed') {
            return;
        }

        $token = \App\Models\Setting::getValue('wa_token', '');
        $delay = max(1, (int) \App\Models\Setting::getValue('wa_delay', 2));

        $blast->update(['status' => 'sending', 'sent_at' => now()]);

        $sent   = 0;
        $failed = 0;
        $errors = [];

        if ($blast->recipient_type === 'custom') {
            $phones = $blast->phone_numbers ?? [];
            foreach ($phones as $phone) {
                $ok = $this->sendMessage($phone, $blast->message, $token);
                $ok ? $sent++ : ($failed++ && $errors[] = $phone);
                sleep($delay);
            }
        } else {
            $query = User::whereNotNull('phone')->where('phone', '!=', '');
            if ($blast->recipient_type === 'role' && $blast->recipient_role) {
                $query->where('role', $blast->recipient_role);
            }

            foreach ($query->cursor() as $user) {
                $phone = $this->normalizePhone($user->phone);
                $msg   = $this->resolveVars($blast->message, $user);
                $ok    = $this->sendMessage($phone, $msg, $token);
                $ok ? $sent++ : ($failed++ && $errors[] = $phone);
                sleep($delay);
            }
        }

        $blast->update([
            'status'       => ($sent === 0 && $failed > 0) ? 'failed' : 'completed',
            'sent_count'   => $sent,
            'failed_count' => $failed,
            'error_log'    => !empty($errors) ? implode(', ', array_slice($errors, 0, 100)) : null,
        ]);
    }

    protected function sendMessage(string $phone, string $message, string $token): bool
    {
        try {
            $response = Http::withHeaders(['Authorization' => $token])
                ->timeout(20)
                ->post('https://api.fonnte.com/send', [
                    'target'      => $phone,
                    'message'     => $message,
                    'countryCode' => '62',
                ]);

            $data     = $response->json() ?? [];
            $httpCode = $response->status();
            $ok       = $response->successful() && !empty($data['status']) && (bool) $data['status'];

            if (!$ok) {
                $reason = $data['reason'] ?? ($data['detail'] ?? 'Unknown');
                Log::warning("WA Blast failed [{$phone}]: HTTP {$httpCode} — {$reason}");
            }

            return $ok;
        } catch (\Throwable $e) {
            Log::error("WA Blaster send error [{$phone}]: " . $e->getMessage());
            return false;
        }
    }

    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (str_starts_with($phone, '0')) {
            return '62' . substr($phone, 1);
        }
        if (!str_starts_with($phone, '62')) {
            return '62' . $phone;
        }
        return $phone;
    }

    protected function resolveVars(string $message, User $user): string
    {
        return str_replace(
            ['{name}', '{email}', '{phone}', '{role}'],
            [$user->name, $user->email, $user->phone ?? '', $user->role ?? ''],
            $message
        );
    }
}
