<?php

namespace App\Livewire\Admin;

use App\Helpers\DatabaseBackup;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DatabaseManager extends Component
{
    use WithFileUploads;

    public $importFile = null;
    public bool $showImportConfirm = false;
    public bool $importing = false;

    public function rules(): array
    {
        return [
            'importFile' => 'required|file|mimes:sql,txt|max:51200', // max 50MB
        ];
    }

    public function openImportConfirm()
    {
        $this->validate();
        $this->showImportConfirm = true;
    }

    public function cancelImport()
    {
        $this->showImportConfirm = false;
        $this->importFile = null;
    }

    public function runImport()
    {
        $this->validate();

        if (!Auth::user()->isAdmin()) {
            session()->flash('error', 'Tidak diizinkan.');
            return;
        }

        $this->importing = true;
        $backupPath = null;

        try {
            $path = $this->importFile->getRealPath();
            $sql  = file_get_contents($path);

            if (empty(trim($sql))) {
                session()->flash('error', 'File SQL kosong.');
                $this->importing = false;
                $this->showImportConfirm = false;
                return;
            }

            // Safety net: snapshot the current database before running
            // arbitrary SQL from the uploaded file (it can contain DROP
            // TABLE etc.), so a bad import can still be restored manually.
            $backupPath = 'db-backups/' . DatabaseBackup::filename();
            Storage::disk('local')->put($backupPath, DatabaseBackup::dump());

            // Split into individual statements
            $pdo = DB::getPdo();
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);

            DB::unprepared($sql);

            session()->flash('success', 'Database berhasil diimport. Backup sebelum import disimpan di storage/app/private/' . $backupPath . '.');
        } catch (\Throwable $e) {
            \Log::error('Database import error: ' . $e->getMessage());
            $backupNote = $backupPath ? ' Backup sebelum import tersedia di storage/app/private/' . $backupPath . '.' : '';
            session()->flash('error', 'Import gagal: ' . $e->getMessage() . $backupNote);
        }

        $this->importing = false;
        $this->showImportConfirm = false;
        $this->importFile = null;
    }

    public function render()
    {
        $tables = collect(DB::select('SHOW TABLE STATUS'))->map(function ($t) {
            $t = (array) $t;
            return [
                'name'    => $t['Name'],
                'rows'    => number_format($t['Rows']),
                'size'    => $this->formatBytes(($t['Data_length'] ?? 0) + ($t['Index_length'] ?? 0)),
                'engine'  => $t['Engine'] ?? '-',
                'updated' => $t['Update_time'] ?? null,
            ];
        });

        $dbName   = DB::getDatabaseName();
        $totalSize = $this->formatBytes(
            collect(DB::select('SHOW TABLE STATUS'))->sum(fn($t) => ((array)$t)['Data_length'] + ((array)$t)['Index_length'])
        );

        return view('livewire.admin.database-manager', compact('tables', 'dbName', 'totalSize'))
            ->layout('layouts.app');
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1_048_576) return round($bytes / 1_048_576, 2) . ' MB';
        if ($bytes >= 1_024)    return round($bytes / 1_024, 1)     . ' KB';
        return $bytes . ' B';
    }
}
