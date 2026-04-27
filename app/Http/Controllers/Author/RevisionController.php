<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\PaperFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RevisionController extends Controller
{
    /**
     * Handle revision file upload via standard multipart form POST.
     * Menggunakan HTTP multipart langsung (bukan Livewire tmp) untuk
     * menghindari error "file kadaluarsa" karena TTL temporary file Livewire.
     */
    public function upload(Request $request, Paper $paper)
    {
        // Pastikan hanya author pemilik paper yang bisa upload
        $user            = Auth::user();
        $isAdminEditor   = in_array($user?->role, ['admin', 'editor']);
        $isImpersonating = session()->has('impersonating_from');

        if (! $isAdminEditor && ! $isImpersonating && (int) $paper->user_id !== (int) Auth::id()) {
            abort(403);
        }

        // Pastikan paper memang dalam status revision_required
        if ($paper->status !== 'revision_required') {
            return back()->with('error', 'Paper ini tidak memerlukan revisi saat ini.');
        }

        $request->validate([
            'revision_file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'revision_file.required' => 'File revisi wajib dipilih.',
            'revision_file.mimes'    => 'Format file harus PDF, DOC, atau DOCX.',
            'revision_file.max'      => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            $file  = $request->file('revision_file');
            $notes = $request->input('revision_notes', '');

            $path = $file->store('papers/' . $paper->id . '/revisions', 'public');

            PaperFile::create([
                'paper_id'      => $paper->id,
                'type'          => 'revision',
                'file_path'     => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type'     => $file->getMimeType(),
                'file_size'     => $file->getSize(),
                'notes'         => $notes,
            ]);

            $paper->update(['status' => 'revised']);

            // Kirim notifikasi ke admin/editor
            $adminIds = \App\Models\User::whereIn('role', ['admin', 'editor'])->pluck('id');
            \App\Models\Notification::createForUsers(
                $adminIds,
                'info',
                'Revisi Paper Diterima',
                'Author telah mengupload revisi untuk paper "' . \Illuminate\Support\Str::limit($paper->title, 50) . '"',
                route('admin.paper.detail', $paper),
                'Lihat Paper'
            );

            return redirect()
                ->route('author.paper.detail', $paper)
                ->with('success', 'Revisi berhasil diunggah!');

        } catch (\Throwable $e) {
            Log::error('RevisionController::upload error: ' . $e->getMessage(), [
                'paper_id' => $paper->id,
                'user_id'  => Auth::id(),
            ]);

            return back()->with('error', 'Terjadi kesalahan saat mengunggah file. Silakan coba lagi.');
        }
    }
}
