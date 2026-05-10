<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Paper;
use App\Models\User;
use App\Models\Conference;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

class DocumentGenerator
{
    /**
     * Generate LOA (Letter of Acceptance) PDF for a paper
     */
    public function generateLOA(Paper $paper): string
    {
        $loaNumber = $this->generateLOANumber($paper);
        $qrCodeDataUri = $this->generateQRCode(route('verify-loa', ['code' => $loaNumber]));
        $conference = $paper->conference()->with(['importantDates', 'keynoteSpeakers'])->first();

        $data = [
            'paper'         => $paper,
            'author'        => $paper->user,
            'conference'    => $conference,
            'loaNumber'     => $loaNumber,
            'qrCode'        => $qrCodeDataUri,
            'generatedDate' => now(),
        ];

        $pdf = Pdf::loadView('pdf.loa-template', $data)->setPaper('a4', 'portrait');

        $filename = "LOA-{$paper->id}-" . now()->format('Ymd-His') . ".pdf";
        $path     = "loa/" . now()->year . "/{$filename}";
        Storage::disk('public')->put($path, $pdf->output());

        $paper->update(['loa_number' => $loaNumber]);

        return $path;
    }

    /**
     * Generate a Certificate PDF and store it.
     *
     * Guarantees exactly ONE certificate record per (user, type, conference).
     * Safe order: delete old → generate PDF → save file → create record.
     * If PDF generation or file-save fails an exception propagates to the caller
     * and nothing is deleted, so existing data stays intact.
     */
    public function generateCertificate(
        User $user,
        string $type = 'author',
        ?Paper $paper = null
    ): string {
        $conference = $paper
            ? $paper->conference
            : Conference::where('is_active', true)->first();

        // Remove any stale duplicate records for this user+type+conference.
        // Done BEFORE generating the PDF so that if generation fails the old
        // record (if valid) is untouched.
        if ($conference) {
            $existing = Certificate::where('user_id', $user->id)
                ->where('conference_id', $conference->id)
                ->where('type', $type)
                ->get();

            foreach ($existing as $old) {
                if ($old->file_path && Storage::disk('public')->exists($old->file_path)) {
                    Storage::disk('public')->delete($old->file_path);
                }
                $old->delete();
            }
        }

        $certNumber    = $this->generateCertificateNumber($type);
        $qrCodeDataUri = $this->generateQRCode(route('verify-certificate', ['code' => $certNumber]));

        $data = [
            'user'          => $user,
            'paper'         => $paper,
            'conference'    => $conference,
            'certNumber'    => $certNumber,
            'qrCode'        => $qrCodeDataUri,
            'type'          => $type,
            'generatedDate' => now(),
        ];

        $pdf = Pdf::loadView('pdf.certificate-template', $data)->setPaper('a4', 'landscape');

        $filename = "CERT-{$type}-{$user->id}-" . now()->format('Ymd-His') . ".pdf";
        $path     = "certificates/" . now()->year . "/{$filename}";
        Storage::disk('public')->put($path, $pdf->output());

        Certificate::create([
            'cert_number'   => $certNumber,
            'type'          => $type,
            'user_id'       => $user->id,
            'paper_id'      => $paper?->id,
            'conference_id' => $conference?->id,
            'file_path'     => $path,
            'generated_at'  => now(),
        ]);

        return $path;
    }

    /**
     * Batch generate author certificates.
     *
     * Rules:
     * - One certificate per user (even if the user has multiple papers).
     * - Skips users who already have a valid author certificate (file exists on disk).
     * - Re-generates for users whose certificate record exists but file is missing.
     */
    public function batchGenerateCertificates(Conference $conference): array
    {
        $stats = ['authors' => 0, 'failed' => 0];

        // Users who already have an author cert WITH a valid file on disk → skip.
        $alreadyCertified = Certificate::where('conference_id', $conference->id)
            ->where('type', 'author')
            ->get()
            ->filter(fn ($c) => $c->file_path && Storage::disk('public')->exists($c->file_path))
            ->pluck('user_id')
            ->toArray();

        $papers = Paper::where('conference_id', $conference->id)
            ->whereIn('status', ['payment_verified', 'deliverables_pending', 'completed'])
            ->whereNotIn('user_id', $alreadyCertified)
            ->with('user')
            ->latest()
            ->get()
            ->unique('user_id');

        foreach ($papers as $paper) {
            try {
                $this->generateCertificate($paper->user, 'author', $paper);
                $stats['authors']++;
            } catch (\Exception $e) {
                \Log::error("Failed to generate author certificate for paper {$paper->id}: " . $e->getMessage());
                $stats['failed']++;
            }
        }

        return $stats;
    }

    /**
     * Batch generate participant certificates.
     *
     * Covers:
     * 1. Authors whose paper is verified/completed (they present at the conference).
     * 2. Pure participants with a verified participant payment.
     *
     * Skips users who already have a valid participant certificate (file exists on disk).
     * Re-generates if the record exists but the file is missing.
     */
    public function batchGenerateParticipantCertificates(Conference $conference): array
    {
        $stats = ['participants' => 0, 'failed' => 0];

        // Users who already have a participant cert WITH a valid file on disk → skip.
        $alreadyCertified = Certificate::where('conference_id', $conference->id)
            ->where('type', 'participant')
            ->get()
            ->filter(fn ($c) => $c->file_path && Storage::disk('public')->exists($c->file_path))
            ->pluck('user_id')
            ->toArray();

        // Group 1: verified authors (paper payment confirmed)
        $fromPapers = Paper::where('conference_id', $conference->id)
            ->whereIn('status', ['payment_verified', 'deliverables_pending', 'completed'])
            ->whereNotIn('user_id', $alreadyCertified)
            ->with('user')
            ->get()
            ->unique('user_id');

        // Group 2: pure participants with a verified payment
        $fromPayments = \App\Models\Payment::where('type', 'participant')
            ->where('status', 'verified')
            ->whereHas('registrationPackage', fn ($q) => $q->where('conference_id', $conference->id))
            ->whereNotIn('user_id', $alreadyCertified)
            ->with('user')
            ->get()
            ->unique('user_id');

        // Merge, keyed by user_id to avoid duplicates
        $usersById = collect();
        foreach ($fromPapers as $paper) {
            if ($paper->user) {
                $usersById->put($paper->user_id, $paper->user);
            }
        }
        foreach ($fromPayments as $payment) {
            if ($payment->user && ! $usersById->has($payment->user_id)) {
                $usersById->put($payment->user_id, $payment->user);
            }
        }

        foreach ($usersById as $user) {
            try {
                $this->generateCertificate($user, 'participant');
                $stats['participants']++;
            } catch (\Exception $e) {
                \Log::error("Failed to generate participant certificate for user {$user->id}: " . $e->getMessage());
                $stats['failed']++;
            }
        }

        return $stats;
    }

    // ── Private helpers ──────────────────────────────────────────────────────

    private function generateLOANumber(Paper $paper): string
    {
        $conference   = $paper->conference;
        $year         = now()->year;
        $acronym      = preg_replace('/[^A-Za-z0-9\-]/', '', preg_replace('/\s+/', '-', trim($conference->acronym ?: 'CONF')));
        $acronymUpper = strtoupper($acronym);

        $count = Paper::where('conference_id', $conference->id)->whereNotNull('loa_number')->count() + 1;

        do {
            $loaNumber = sprintf("LOA/%03d/%s/%d", $count, $acronymUpper, $year);
            $exists    = Paper::where('loa_number', $loaNumber)->exists();
            if ($exists) {
                $count++;
            }
        } while ($exists);

        return $loaNumber;
    }

    private function generateCertificateNumber(string $type): string
    {
        $year     = now()->year;
        $typeCode = strtoupper(substr($type, 0, 3));

        $count = 1;
        try {
            $count = Certificate::where('type', $type)->whereYear('generated_at', $year)->count() + 1;
        } catch (\Throwable) {
            $count = rand(100, 999);
        }

        return sprintf("CERT/%s/%03d/%d", $typeCode, $count, $year);
    }

    private function generateQRCode(string $url): string
    {
        $result = (new Builder(
            writer: new PngWriter(),
            data: $url,
            encoding: new Encoding('UTF-8'),
            size: 120,
            margin: 5,
        ))->build();

        return $result->getDataUri();
    }
}
