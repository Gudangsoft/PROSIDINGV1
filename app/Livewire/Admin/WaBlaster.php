<?php

namespace App\Livewire\Admin;

use App\Jobs\SendWaBlastJob;
use App\Models\Setting;
use App\Models\User;
use App\Models\WaBlast;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class WaBlaster extends Component
{
    use WithPagination;

    public string $activeTab = 'compose';

    // ── Settings ──
    public string $waProvider      = 'fonnte';
    public string $waToken         = '';
    public string $waSenderNumber  = '';
    public string $waDelay         = '2';

    // ── Compose ──
    public string $blastTitle     = '';
    public string $recipientType  = 'all';
    public string $recipientRole  = '';
    public string $customPhones   = '';
    public string $message        = '';
    public string $testPhone      = '';

    // ── Preview ──
    public int   $recipientCount   = 0;
    public array $recipientPreview = [];

    // ── Delete confirm ──
    public ?int $confirmDeleteId = null;

    protected array $rules = [
        'waToken'   => 'required|string',
        'waDelay'   => 'required|integer|min:1|max:60',
        'message'   => 'required|string|min:1',
        'testPhone' => 'required|string|min:8|max:20',
    ];

    public function mount(): void
    {
        $this->waProvider     = Setting::getValue('wa_provider', 'fonnte');
        $this->waToken        = Setting::getValue('wa_token', '');
        $this->waSenderNumber = Setting::getValue('wa_sender_number', '');
        $this->waDelay        = Setting::getValue('wa_delay', '2');
    }

    // ─────────────────────────────────────────────
    //  SETTINGS
    // ─────────────────────────────────────────────

    public function saveSettings(): void
    {
        $this->validate([
            'waToken' => 'required|string',
            'waDelay' => 'required|integer|min:1|max:60',
        ]);

        Setting::setValue('wa_provider',       $this->waProvider,      'wa_blaster', 'text',   'WA Provider');
        Setting::setValue('wa_token',          $this->waToken,         'wa_blaster', 'text',   'WA API Token');
        Setting::setValue('wa_sender_number',  $this->waSenderNumber,  'wa_blaster', 'text',   'WA Sender Number');
        Setting::setValue('wa_delay',          $this->waDelay,         'wa_blaster', 'number', 'WA Delay Antar Pesan (detik)');

        session()->flash('settings_success', 'Pengaturan WA Blaster berhasil disimpan.');
    }

    // ─────────────────────────────────────────────
    //  RECIPIENT PREVIEW
    // ─────────────────────────────────────────────

    public function updatedRecipientType(): void
    {
        $this->recipientRole = '';
        $this->previewRecipients();
    }

    public function updatedRecipientRole(): void
    {
        $this->previewRecipients();
    }

    public function previewRecipients(): void
    {
        if ($this->recipientType === 'custom') {
            $phones = array_filter(array_map('trim', explode("\n", $this->customPhones)));
            $this->recipientCount   = count($phones);
            $this->recipientPreview = [];
            return;
        }

        $users = $this->queryRecipients()->get();
        $this->recipientCount   = $users->count();
        $this->recipientPreview = $users->take(5)->map(fn (User $u) => [
            'name'  => $u->name,
            'phone' => $u->phone,
            'role'  => $u->role,
        ])->toArray();
    }

    protected function queryRecipients()
    {
        $query = User::whereNotNull('phone')->where('phone', '!=', '');

        if ($this->recipientType === 'role' && $this->recipientRole) {
            $query->where('role', $this->recipientRole);
        }

        return $query;
    }

    // ─────────────────────────────────────────────
    //  TEST SEND
    // ─────────────────────────────────────────────

    public function sendTest(): void
    {
        $this->validate([
            'message'   => 'required|string|min:1',
            'testPhone' => 'required|string|min:8|max:20',
        ]);

        $token = Setting::getValue('wa_token', '');
        if (empty($token)) {
            session()->flash('compose_error', 'Token API belum dikonfigurasi. Silakan atur di tab Pengaturan.');
            return;
        }

        $phone   = $this->normalizePhone($this->testPhone);
        $message = str_replace(
            ['{name}', '{email}', '{phone}', '{role}'],
            ['Test User', 'test@email.com', $phone, 'admin'],
            $this->message
        );

        $result = $this->callFonnteApi($phone, $message, $token);

        if ($result['ok']) {
            session()->flash('compose_success', "✅ Pesan test berhasil dikirim ke {$phone}.");
        } else {
            $reason = $result['reason'] ?? '';
            $httpCode = $result['http_code'] ?? '';

            if (str_contains(strtolower($reason), 'disconnected')) {
                session()->flash('compose_error', "❌ Device WhatsApp tidak terhubung ke Fonnte. Buka fonnte.com → pilih device → klik Reconnect atau scan ulang QR code.");
            } elseif (str_contains(strtolower($reason), 'token')) {
                session()->flash('compose_error', "❌ Token tidak valid. Periksa kembali token di tab Pengaturan.");
            } else {
                session()->flash('compose_error', "❌ Gagal: {$reason}" . ($httpCode ? " (HTTP {$httpCode})" : ''));
            }
        }
    }

    // ─────────────────────────────────────────────
    //  TEST API CONNECTION
    // ─────────────────────────────────────────────

    public function testConnection(): void
    {
        $token = Setting::getValue('wa_token', $this->waToken);
        if (empty($token)) {
            session()->flash('settings_error', 'Token API kosong. Isi dan simpan dulu.');
            return;
        }

        try {
            $response = Http::withHeaders(['Authorization' => $token])
                ->timeout(15)
                ->get('https://api.fonnte.com/device');

            $data = $response->json() ?? [];
            $httpCode = $response->status();

            Log::info('Fonnte device check', ['code' => $httpCode, 'data' => $data]);

            if ($response->successful() && ($data['status'] ?? false)) {
                $deviceName = $data['name'] ?? '-';
                $devicePhone = $data['number'] ?? '-';
                $deviceStatus = $data['device_status'] ?? '-';
                session()->flash('settings_success',
                    "✅ Koneksi OK! Device: {$deviceName} | No: {$devicePhone} | Status: {$deviceStatus}"
                );
            } else {
                $reason = $data['reason'] ?? ($data['detail'] ?? 'Tidak diketahui');
                session()->flash('settings_error', "❌ Koneksi Gagal (HTTP {$httpCode}): {$reason}");
            }
        } catch (\Throwable $e) {
            session()->flash('settings_error', "❌ Error koneksi: " . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────
    //  SEND BLAST
    // ─────────────────────────────────────────────

    public function sendBlast(): void
    {
        $this->validate([
            'message'      => 'required|string|min:1',
            'recipientType' => 'required|in:all,role,custom',
        ]);

        $token = Setting::getValue('wa_token', '');
        if (empty($token)) {
            session()->flash('compose_error', 'Token API belum dikonfigurasi. Silakan atur di tab Pengaturan.');
            return;
        }

        if ($this->recipientType === 'custom') {
            $rawPhones   = array_filter(array_map('trim', explode("\n", $this->customPhones)));
            $phoneNumbers = array_values(array_map(fn ($p) => $this->normalizePhone($p), $rawPhones));
            $total        = count($phoneNumbers);
        } else {
            $users        = $this->queryRecipients()->get();
            $phoneNumbers = $users->pluck('phone')->filter()->map(fn ($p) => $this->normalizePhone($p))->values()->toArray();
            $total        = $users->count();
        }

        if ($total === 0) {
            session()->flash('compose_error', 'Tidak ada penerima yang memiliki nomor WhatsApp.');
            return;
        }

        $blast = WaBlast::create([
            'title'            => $this->blastTitle ?: 'Blast ' . now()->format('d/m/Y H:i'),
            'recipient_type'   => $this->recipientType,
            'recipient_role'   => $this->recipientType === 'role' ? ($this->recipientRole ?: null) : null,
            'phone_numbers'    => $phoneNumbers,
            'message'          => $this->message,
            'status'           => 'sending',
            'total_recipients' => $total,
            'created_by'       => auth()->id(),
        ]);

        // Dispatch job to queue so HTTP request doesn't time out
        SendWaBlastJob::dispatch($blast->id);

        $this->blastTitle  = '';
        $this->message     = '';
        $this->activeTab   = 'history';
        $this->resetPage();

        session()->flash('history_success', "Blast dijadwalkan untuk {$total} penerima. Proses berjalan di background.");
    }

    // ─────────────────────────────────────────────
    //  DELETE
    // ─────────────────────────────────────────────

    public function confirmDelete(int $id): void
    {
        $this->confirmDeleteId = $id;
    }

    public function cancelDelete(): void
    {
        $this->confirmDeleteId = null;
    }

    public function deleteBlast(): void
    {
        if ($this->confirmDeleteId) {
            WaBlast::find($this->confirmDeleteId)?->delete();
            $this->confirmDeleteId = null;
            session()->flash('history_success', 'Log blast berhasil dihapus.');
        }
    }

    // ─────────────────────────────────────────────
    //  HELPERS
    // ─────────────────────────────────────────────

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

    protected function callFonnteApi(string $phone, string $message, string $token): array
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

            Log::info('Fonnte API response', ['phone' => $phone, 'code' => $httpCode, 'data' => $data]);

            $ok = $response->successful() && !empty($data['status']) && (bool) $data['status'];

            return [
                'ok'        => $ok,
                'reason'    => $data['reason'] ?? ($data['detail'] ?? ($ok ? 'OK' : 'Device tidak terhubung atau token salah')),
                'http_code' => $httpCode,
                'raw'       => $data,
            ];
        } catch (\Throwable $e) {
            Log::error('WA Blaster send error: ' . $e->getMessage(), ['phone' => $phone]);
            return [
                'ok'        => false,
                'reason'    => $e->getMessage(),
                'http_code' => 0,
                'raw'       => [],
            ];
        }
    }

    // ─────────────────────────────────────────────
    //  RENDER
    // ─────────────────────────────────────────────

    public function render()
    {
        $blasts = WaBlast::with('creator')
            ->orderByDesc('created_at')
            ->paginate(10);

        $stats = [
            'total'     => WaBlast::count(),
            'completed' => WaBlast::where('status', 'completed')->count(),
            'failed'    => WaBlast::where('status', 'failed')->count(),
            'total_sent' => WaBlast::sum('sent_count'),
        ];

        return view('livewire.admin.wa-blaster', compact('blasts', 'stats'))
            ->layout('layouts.app');
    }
}
