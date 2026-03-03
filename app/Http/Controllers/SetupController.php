<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SetupController extends Controller
{
    // Token keamanan - baca dari file .setup-token atau gunakan default
    private function getSetupToken(): string
    {
        try {
            $tokenFile = base_path('.setup-token');
            if (file_exists($tokenFile) && is_readable($tokenFile)) {
                $token = trim(file_get_contents($tokenFile));
                if (!empty($token)) {
                    return $token;
                }
            }
        } catch (\Exception $e) {
            // Ignore errors, use default
        }
        return 'setup-prosiding'; // Default token
    }

    // Rate limiting - max 5 attempts per 15 minutes
    // Menggunakan file-based jika cache tidak tersedia
    private function isRateLimited(Request $request): bool
    {
        try {
            $key = 'setup_attempts_' . md5($request->ip());
            
            // Coba gunakan cache terlebih dahulu
            if ($this->isCacheAvailable()) {
                $attempts = cache()->get($key, 0);
                return $attempts >= 5;
            }
            
            // Fallback ke file-based rate limiting
            $filePath = $this->getRateLimitFilePath($request);
            if (file_exists($filePath)) {
                $data = json_decode(file_get_contents($filePath), true);
                if ($data && isset($data['expires']) && $data['expires'] > time()) {
                    return ($data['attempts'] ?? 0) >= 5;
                }
            }
        } catch (\Exception $e) {
            // Jika error, izinkan akses
        }
        return false;
    }

    private function incrementAttempts(Request $request): void
    {
        try {
            $key = 'setup_attempts_' . md5($request->ip());
            
            if ($this->isCacheAvailable()) {
                $attempts = cache()->get($key, 0);
                cache()->put($key, $attempts + 1, now()->addMinutes(15));
                return;
            }
            
            // Fallback ke file-based
            $filePath = $this->getRateLimitFilePath($request);
            $data = ['attempts' => 1, 'expires' => time() + 900]; // 15 minutes
            
            if (file_exists($filePath)) {
                $existing = json_decode(file_get_contents($filePath), true);
                if ($existing && isset($existing['expires']) && $existing['expires'] > time()) {
                    $data['attempts'] = ($existing['attempts'] ?? 0) + 1;
                    $data['expires'] = $existing['expires'];
                }
            }
            
            file_put_contents($filePath, json_encode($data));
        } catch (\Exception $e) {
            // Ignore errors
        }
    }

    private function clearAttempts(Request $request): void
    {
        try {
            $key = 'setup_attempts_' . md5($request->ip());
            
            if ($this->isCacheAvailable()) {
                cache()->forget($key);
            }
            
            // Hapus file juga jika ada
            $filePath = $this->getRateLimitFilePath($request);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        } catch (\Exception $e) {
            // Ignore errors
        }
    }
    
    private function isCacheAvailable(): bool
    {
        try {
            cache()->put('_test_cache_', 1, 1);
            cache()->forget('_test_cache_');
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    private function getRateLimitFilePath(Request $request): string
    {
        $dir = storage_path('app/setup_ratelimit');
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        return $dir . '/' . md5($request->ip()) . '.json';
    }

    // File penanda bahwa setup sudah selesai
    private function completedFlagPath(): string
    {
        return storage_path('app/setup_complete.lock');
    }

    private function isCompleted(): bool
    {
        try {
            return file_exists($this->completedFlagPath());
        } catch (\Exception $e) {
            return false;
        }
    }

    private function checkToken(Request $request): bool
    {
        try {
            return $request->session()->get('setup_authenticated') === true;
        } catch (\Exception $e) {
            return false;
        }
    }

    // -------------------------------------------------------------------------
    // GET /setup  →  Halaman utama wizard
    // -------------------------------------------------------------------------
    public function index(Request $request)
    {
        try {
            if ($this->isCompleted()) {
                return view('setup.index', ['completed' => true, 'envValues' => [], 'error' => null]);
            }
            
            // Load existing .env values for pre-fill
            $envValues = $this->getEnvValues();
            
            return view('setup.index', [
                'completed' => false,
                'envValues' => $envValues,
                'error' => null,
            ]);
        } catch (\Exception $e) {
            // Jika ada error, tampilkan halaman setup dengan pesan error
            return view('setup.index', [
                'completed' => false,
                'envValues' => [],
                'error' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    // -------------------------------------------------------------------------
    // POST /setup/auth  →  Verifikasi token akses
    // -------------------------------------------------------------------------
    public function auth(Request $request)
    {
        // Check rate limiting
        if ($this->isRateLimited($request)) {
            return response()->json([
                'success' => false, 
                'message' => 'Terlalu banyak percobaan. Coba lagi dalam 15 menit.'
            ], 429);
        }

        $token = $request->input('token');
        if ($token === $this->getSetupToken()) {
            $this->clearAttempts($request);
            $request->session()->put('setup_authenticated', true);
            return response()->json(['success' => true]);
        }
        
        $this->incrementAttempts($request);
        return response()->json(['success' => false, 'message' => 'Token tidak valid.'], 401);
    }

    // -------------------------------------------------------------------------
    // POST /setup/requirements  →  Cek kebutuhan sistem
    // -------------------------------------------------------------------------
    public function requirements(Request $request)
    {
        if (!$this->checkToken($request)) {
            return response()->json(['success' => false, 'message' => 'Tidak terautentikasi.'], 401);
        }

        $checks = [];

        // PHP Version
        $phpVersion = PHP_VERSION;
        $checks[] = [
            'label' => 'PHP Version (' . $phpVersion . ')',
            'pass'  => version_compare($phpVersion, '8.2.0', '>='),
            'note'  => 'Minimal PHP 8.2',
        ];

        // Required Extensions
        $extensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'fileinfo', 'gd'];
        foreach ($extensions as $ext) {
            $checks[] = [
                'label' => 'Extension: ' . $ext,
                'pass'  => extension_loaded($ext),
                'note'  => '',
            ];
        }

        // Folder writable
        $writablePaths = [
            'storage/app'         => storage_path('app'),
            'storage/framework'   => storage_path('framework'),
            'storage/logs'        => storage_path('logs'),
            'bootstrap/cache'     => base_path('bootstrap/cache'),
        ];
        foreach ($writablePaths as $label => $path) {
            $checks[] = [
                'label' => 'Writable: ' . $label,
                'pass'  => is_writable($path),
                'note'  => 'Folder harus bisa ditulis (chmod 775)',
            ];
        }

        // .env writable
        $envPath = base_path('.env');
        $envExists = file_exists($envPath);
        $checks[] = [
            'label' => '.env file ' . ($envExists ? '(ada, writable)' : '(belum ada)'),
            'pass'  => !$envExists || is_writable($envPath),
            'note'  => 'File .env harus bisa ditulis',
        ];

        $allPass = collect($checks)->every(fn($c) => $c['pass']);

        return response()->json(['success' => true, 'checks' => $checks, 'allPass' => $allPass]);
    }

    // -------------------------------------------------------------------------
    // POST /setup/save-env  →  Tulis file .env
    // -------------------------------------------------------------------------
    public function saveEnv(Request $request)
    {
        if (!$this->checkToken($request)) {
            return response()->json(['success' => false, 'message' => 'Tidak terautentikasi.'], 401);
        }

        $data = $request->validate([
            'app_name'     => 'required|string',
            'app_url'      => 'required|url',
            'app_env'      => 'required|in:local,production,staging',
            'app_debug'    => 'required|in:true,false',
            'app_timezone' => 'required|string',
            'db_host'      => 'required|string',
            'db_port'      => 'required|string',
            'db_database'  => 'required|string',
            'db_username'  => 'required|string',
            'db_password'  => 'nullable|string',
            'mail_mailer'  => 'required|string',
            'mail_host'    => 'nullable|string',
            'mail_port'    => 'nullable|string',
            'mail_username'=> 'nullable|string',
            'mail_password'=> 'nullable|string',
            'mail_from_address' => 'nullable|email',
            'mail_from_name'    => 'nullable|string',
        ]);

        // Baca template .env.example atau .env yang sudah ada
        $envPath        = base_path('.env');
        $envExamplePath = base_path('.env.example');

        $template = file_exists($envExamplePath) ? file_get_contents($envExamplePath) : '';

        // Jika .env sudah ada, gunakan isinya sebagai base
        if (file_exists($envPath)) {
            $template = file_get_contents($envPath);
        }

        $map = [
            'APP_NAME'            => '"' . $data['app_name'] . '"',
            'APP_ENV'             => $data['app_env'],
            'APP_DEBUG'           => $data['app_debug'],
            'APP_TIMEZONE'        => $data['app_timezone'],
            'APP_URL'             => $data['app_url'],
            'DB_CONNECTION'       => 'mysql',
            'DB_HOST'             => $data['db_host'],
            'DB_PORT'             => $data['db_port'],
            'DB_DATABASE'         => $data['db_database'],
            'DB_USERNAME'         => $data['db_username'],
            'DB_PASSWORD'         => $data['db_password'] ?? '',
            'MAIL_MAILER'         => $data['mail_mailer'],
            'MAIL_HOST'           => $data['mail_host'] ?? '',
            'MAIL_PORT'           => $data['mail_port'] ?? '587',
            'MAIL_USERNAME'       => $data['mail_username'] ?? '',
            'MAIL_PASSWORD'       => $data['mail_password'] ?? '',
            'MAIL_FROM_ADDRESS'   => '"' . ($data['mail_from_address'] ?? '') . '"',
            'MAIL_FROM_NAME'      => '"' . ($data['mail_from_name'] ?? $data['app_name']) . '"',
            'SESSION_DRIVER'      => 'database',
            'CACHE_STORE'         => 'database',
            'QUEUE_CONNECTION'    => 'database',
        ];

        foreach ($map as $key => $value) {
            // Hapus komentar pada baris yang relevan
            $template = preg_replace('/^#\s*(' . preg_quote($key) . '=.*)$/m', '$1', $template);

            if (preg_match('/^' . preg_quote($key) . '=/m', $template)) {
                // Ganti nilai yang sudah ada
                $template = preg_replace('/^' . preg_quote($key) . '=.*/m', $key . '=' . $value, $template);
            } else {
                // Tambahkan di akhir jika belum ada
                $template .= "\n" . $key . '=' . $value;
            }
        }

        // Pastikan APP_KEY ada (kosong dulu, akan di-generate di langkah berikutnya)
        if (!preg_match('/^APP_KEY=/m', $template)) {
            $template .= "\nAPP_KEY=";
        }

        try {
            file_put_contents($envPath, $template);
            return response()->json(['success' => true, 'message' => 'File .env berhasil disimpan.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menulis .env: ' . $e->getMessage()]);
        }
    }

    // -------------------------------------------------------------------------
    // POST /setup/generate-key  →  Generate APP_KEY
    // -------------------------------------------------------------------------
    public function generateKey(Request $request)
    {
        if (!$this->checkToken($request)) {
            return response()->json(['success' => false, 'message' => 'Tidak terautentikasi.'], 401);
        }

        try {
            // Reload config dari .env yang baru ditulis
            $this->reloadEnv();

            Artisan::call('key:generate', ['--force' => true]);
            $output = Artisan::output();

            return response()->json(['success' => true, 'message' => 'APP_KEY berhasil di-generate.', 'output' => trim($output)]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal generate key: ' . $e->getMessage()]);
        }
    }

    // -------------------------------------------------------------------------
    // POST /setup/test-db  →  Uji koneksi database
    // -------------------------------------------------------------------------
    public function testDb(Request $request)
    {
        if (!$this->checkToken($request)) {
            return response()->json(['success' => false, 'message' => 'Tidak terautentikasi.'], 401);
        }

        try {
            $this->reloadEnv();
            // Paksa ulang konfigurasi database
            config([
                'database.connections.mysql.host'     => env('DB_HOST', '127.0.0.1'),
                'database.connections.mysql.port'     => env('DB_PORT', '3306'),
                'database.connections.mysql.database' => env('DB_DATABASE', ''),
                'database.connections.mysql.username' => env('DB_USERNAME', ''),
                'database.connections.mysql.password' => env('DB_PASSWORD', ''),
            ]);
            DB::purge('mysql');
            DB::reconnect('mysql');

            DB::connection('mysql')->getPdo();
            return response()->json(['success' => true, 'message' => 'Koneksi database berhasil!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Koneksi gagal: ' . $e->getMessage()]);
        }
    }

    // -------------------------------------------------------------------------
    // POST /setup/migrate  →  Jalankan migrasi
    // -------------------------------------------------------------------------
    public function migrate(Request $request)
    {
        if (!$this->checkToken($request)) {
            return response()->json(['success' => false, 'message' => 'Tidak terautentikasi.'], 401);
        }

        try {
            $this->reloadEnv();
            config([
                'database.connections.mysql.host'     => env('DB_HOST', '127.0.0.1'),
                'database.connections.mysql.port'     => env('DB_PORT', '3306'),
                'database.connections.mysql.database' => env('DB_DATABASE', ''),
                'database.connections.mysql.username' => env('DB_USERNAME', ''),
                'database.connections.mysql.password' => env('DB_PASSWORD', ''),
            ]);
            DB::purge('mysql');

            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();

            return response()->json(['success' => true, 'message' => 'Migrasi berhasil.', 'output' => trim($output)]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Migrasi gagal: ' . $e->getMessage()]);
        }
    }

    // -------------------------------------------------------------------------
    // POST /setup/seed  →  Jalankan seeder
    // -------------------------------------------------------------------------
    public function seed(Request $request)
    {
        if (!$this->checkToken($request)) {
            return response()->json(['success' => false, 'message' => 'Tidak terautentikasi.'], 401);
        }

        try {
            $this->reloadEnv();
            Artisan::call('db:seed', ['--force' => true]);
            $output = Artisan::output();

            return response()->json(['success' => true, 'message' => 'Seeder berhasil dijalankan.', 'output' => trim($output)]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Seeder gagal: ' . $e->getMessage()]);
        }
    }

    // -------------------------------------------------------------------------
    // POST /setup/finalize  →  Storage link + clear cache + selesai
    // -------------------------------------------------------------------------
    public function finalize(Request $request)
    {
        if (!$this->checkToken($request)) {
            return response()->json(['success' => false, 'message' => 'Tidak terautentikasi.'], 401);
        }

        $results = [];

        // Storage link
        try {
            // Hapus symlink lama jika ada
            $linkPath = public_path('storage');
            if (is_link($linkPath)) {
                unlink($linkPath);
            }
            Artisan::call('storage:link');
            $results[] = ['label' => 'Storage Link', 'success' => true, 'msg' => Artisan::output()];
        } catch (\Exception $e) {
            $results[] = ['label' => 'Storage Link', 'success' => false, 'msg' => $e->getMessage()];
        }

        // Cache & config clear
        $commands = [
            'Config Cache'  => fn() => Artisan::call('config:clear'),
            'Cache Clear'   => fn() => Artisan::call('cache:clear'),
            'View Clear'    => fn() => Artisan::call('view:clear'),
            'Route Clear'   => fn() => Artisan::call('route:clear'),
        ];
        foreach ($commands as $label => $cmd) {
            try {
                $cmd();
                $results[] = ['label' => $label, 'success' => true, 'msg' => trim(Artisan::output())];
            } catch (\Exception $e) {
                $results[] = ['label' => $label, 'success' => false, 'msg' => $e->getMessage()];
            }
        }

        // Tandai setup selesai
        file_put_contents($this->completedFlagPath(), date('Y-m-d H:i:s'));

        return response()->json(['success' => true, 'results' => $results, 'message' => 'Setup selesai!']);
    }

    // -------------------------------------------------------------------------
    // POST /setup/reset-lock  →  Hapus lock file (jika ingin setup ulang)
    // -------------------------------------------------------------------------
    public function resetLock(Request $request)
    {
        if ($request->input('token') !== $this->getSetupToken()) {
            return response()->json(['success' => false, 'message' => 'Token tidak valid.'], 401);
        }
        if (file_exists($this->completedFlagPath())) {
            unlink($this->completedFlagPath());
        }
        $request->session()->forget('setup_authenticated');
        return response()->json(['success' => true, 'message' => 'Lock file dihapus. Setup bisa dijalankan ulang.']);
    }

    // -------------------------------------------------------------------------
    // Helper: Reload .env ke dalam environment PHP
    // -------------------------------------------------------------------------
    private function reloadEnv(): void
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            return;
        }

        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }
            [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
            $key   = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            if (!empty($key)) {
                putenv("$key=$value");
                $_ENV[$key]    = $value;
                $_SERVER[$key] = $value;
            }
        }
    }

    // -------------------------------------------------------------------------
    // Helper: Get existing .env values for pre-fill
    // -------------------------------------------------------------------------
    private function getEnvValues(): array
    {
        try {
            $envPath = base_path('.env');
            if (!file_exists($envPath) || !is_readable($envPath)) {
                return $this->getDefaultEnvValues();
            }

            $values = [];
            $lines = @file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if ($lines === false) {
                return $this->getDefaultEnvValues();
            }
            
            foreach ($lines as $line) {
                if (str_starts_with(trim($line), '#')) {
                    continue;
                }
                $parts = explode('=', $line, 2);
                if (count($parts) < 2) {
                    continue;
                }
                $key   = trim($parts[0]);
                $value = trim($parts[1], " \t\n\r\0\x0B\"'");
                if (!empty($key)) {
                    $values[$key] = $value;
                }
            }

            return [
                'app_name'     => $values['APP_NAME'] ?? 'Prosiding Conference',
                'app_url'      => $values['APP_URL'] ?? '',
                'app_env'      => $values['APP_ENV'] ?? 'production',
                'app_debug'    => $values['APP_DEBUG'] ?? 'false',
                'app_timezone' => $values['APP_TIMEZONE'] ?? 'Asia/Jakarta',
                'db_host'      => $values['DB_HOST'] ?? 'localhost',
                'db_port'      => $values['DB_PORT'] ?? '3306',
                'db_database'  => $values['DB_DATABASE'] ?? '',
                'db_username'  => $values['DB_USERNAME'] ?? '',
                'mail_mailer'  => $values['MAIL_MAILER'] ?? 'log',
                'mail_host'    => $values['MAIL_HOST'] ?? '',
                'mail_port'    => $values['MAIL_PORT'] ?? '587',
                'mail_username'=> $values['MAIL_USERNAME'] ?? '',
                'mail_from_address' => $values['MAIL_FROM_ADDRESS'] ?? '',
            ];
        } catch (\Exception $e) {
            return $this->getDefaultEnvValues();
        }
    }
    
    private function getDefaultEnvValues(): array
    {
        return [
            'app_name'     => 'Prosiding Conference',
            'app_url'      => '',
            'app_env'      => 'production',
            'app_debug'    => 'false',
            'app_timezone' => 'Asia/Jakarta',
            'db_host'      => 'localhost',
            'db_port'      => '3306',
            'db_database'  => '',
            'db_username'  => '',
            'mail_mailer'  => 'log',
            'mail_host'    => '',
            'mail_port'    => '587',
            'mail_username'=> '',
            'mail_from_address' => '',
        ];
    }

    // -------------------------------------------------------------------------
    // POST /setup/create-admin  →  Buat admin user custom
    // -------------------------------------------------------------------------
    public function createAdmin(Request $request)
    {
        if (!$this->checkToken($request)) {
            return response()->json(['success' => false, 'message' => 'Tidak terautentikasi.'], 401);
        }

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        try {
            $this->reloadEnv();
            config([
                'database.connections.mysql.host'     => env('DB_HOST', '127.0.0.1'),
                'database.connections.mysql.port'     => env('DB_PORT', '3306'),
                'database.connections.mysql.database' => env('DB_DATABASE', ''),
                'database.connections.mysql.username' => env('DB_USERNAME', ''),
                'database.connections.mysql.password' => env('DB_PASSWORD', ''),
            ]);
            DB::purge('mysql');

            // Check if user exists
            $exists = DB::table('users')->where('email', $data['email'])->exists();
            if ($exists) {
                // Update existing user
                DB::table('users')->where('email', $data['email'])->update([
                    'name' => $data['name'],
                    'password' => bcrypt($data['password']),
                    'updated_at' => now(),
                ]);
                return response()->json(['success' => true, 'message' => 'Admin berhasil diupdate.']);
            }

            // Create new admin user
            $userId = DB::table('users')->insertGetId([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Assign admin role if roles table exists
            if (\Schema::hasTable('roles')) {
                $adminRole = DB::table('roles')->where('name', 'admin')->first();
                if ($adminRole && \Schema::hasTable('role_user')) {
                    DB::table('role_user')->insert([
                        'user_id' => $userId,
                        'role_id' => $adminRole->id,
                    ]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Admin berhasil dibuat.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal membuat admin: ' . $e->getMessage()]);
        }
    }
}
