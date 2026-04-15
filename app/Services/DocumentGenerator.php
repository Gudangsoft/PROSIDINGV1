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
     *
     * @param Paper $paper
     * @return string Path to generated PDF
     */
    public function generateLOA(Paper $paper): string
    {
        // 1. Generate unique LOA number
        $loaNumber = $this->generateLOANumber($paper);
        
        // 2. Generate QR Code for verification
        $qrCodeDataUri = $this->generateQRCode(route('verify-loa', ['code' => $loaNumber]));
        
        // 3. Load conference with related data
        $conference = $paper->conference()->with(['importantDates', 'keynoteSpeakers'])->first();
        
        // 4. Prepare data for PDF
        $data = [
            'paper' => $paper,
            'author' => $paper->user,
            'conference' => $conference,
            'loaNumber' => $loaNumber,
            'qrCode' => $qrCodeDataUri,
            'generatedDate' => now(),
        ];
        
        // 5. Generate PDF from view
        $pdf = Pdf::loadView('pdf.loa-template', $data)
            ->setPaper('a4', 'portrait');
        
        // 6. Save to storage
        $filename = "LOA-{$paper->id}-" . now()->format('Ymd-His') . ".pdf";
        $path = "loa/" . now()->year . "/{$filename}";
        
        Storage::disk('public')->put($path, $pdf->output());
        
        // 7. Store LOA number in paper metadata (for verification)
        $paper->update([
            'loa_number' => $loaNumber,
        ]);
        
        return $path;
    }
    
    /**
     * Generate Certificate PDF for a user
     *
     * @param User $user
     * @param string $type (author, participant, reviewer, committee)
     * @param Paper|null $paper (for author type)
     * @return string Path to generated PDF
     */
    public function generateCertificate(User $user, string $type = 'author', ?Paper $paper = null): string
    {
        // 1. Generate unique certificate number
        $certNumber = $this->generateCertificateNumber($type);
        
        // 2. Generate QR Code
        $qrCodeDataUri = $this->generateQRCode(route('verify-certificate', ['code' => $certNumber]));
        
        // 3. Get active conference (or specific conference from paper)
        $conference = $paper ? $paper->conference : Conference::where('is_active', true)->first();
        
        // 4. Prepare data
        $data = [
            'user' => $user,
            'paper' => $paper,
            'conference' => $conference,
            'certNumber' => $certNumber,
            'qrCode' => $qrCodeDataUri,
            'type' => $type,
            'generatedDate' => now(),
        ];
        
        // 5. Generate PDF (landscape for certificate)
        $pdf = Pdf::loadView('pdf.certificate-template', $data)
            ->setPaper('a4', 'landscape');
        
        // 6. Save to storage
        $filename = "CERT-{$type}-{$user->id}-" . now()->format('Ymd-His') . ".pdf";
        $path = "certificates/" . now()->year . "/{$filename}";
        
        Storage::disk('public')->put($path, $pdf->output());

        // 7. Store certificate record in DB for verification
        try {
            Certificate::create([
                'cert_number'   => $certNumber,
                'type'          => $type,
                'user_id'       => $user->id,
                'paper_id'      => $paper?->id,
                'conference_id' => $conference?->id,
                'file_path'     => $path,
                'generated_at'  => now(),
            ]);
        } catch (\Throwable $e) {
            \Log::warning('Could not save certificate record: ' . $e->getMessage());
        }
        
        return $path;
    }
    
    /**
     * Generate unique LOA number
     *
     * @param Paper $paper
     * @return string
     */
    private function generateLOANumber(Paper $paper): string
    {
        $conference = $paper->conference;
        $year = now()->year;
        
        $acronym = $conference->acronym ?: 'CONF';
        // Sanitize: collapse spaces, remove characters that break URLs/filenames
        $acronym = preg_replace('/\s+/', '-', trim($acronym));
        $acronym = preg_replace('/[^A-Za-z0-9\-]/', '', $acronym);
        $acronymUpper = strtoupper($acronym);
        
        // Count existing LOAs for this conference and year, then loop until unique
        $count = Paper::where('conference_id', $conference->id)
            ->whereNotNull('loa_number')
            ->count() + 1;
        
        do {
            $loaNumber = sprintf("LOA/%03d/%s/%d", $count, $acronymUpper, $year);
            $exists = Paper::where('loa_number', $loaNumber)->exists();
            if ($exists) {
                $count++;
            }
        } while ($exists);
        
        return $loaNumber;
    }
    
    /**
     * Generate unique certificate number
     *
     * @param string $type
     * @return string
     */
    private function generateCertificateNumber(string $type): string
    {
        $year = now()->year;
        $typeCode = strtoupper(substr($type, 0, 3)); // AUT, PAR, REV, COM

        // Use DB-based sequential counter
        $count = 1;
        try {
            $count = Certificate::where('type', $type)
                ->whereYear('generated_at', $year)
                ->count() + 1;
        } catch (\Throwable) {
            // certificates table may not exist yet; fall back to random
            $count = rand(100, 999);
        }

        return sprintf("CERT/%s/%03d/%d", $typeCode, $count, $year);
    }
    
    /**
     * Generate QR Code as base64 data URI
     *
     * @param string $url
     * @return string
     */
    private function generateQRCode(string $url): string
    {
        $builder = new Builder(
            writer: new PngWriter(),
            data: $url,
            encoding: new Encoding('UTF-8'),
            size: 120,
            margin: 5,
        );

        $result = $builder->build();

        return $result->getDataUri();
    }
    
    /**
     * Batch generate certificates for all accepted papers
     *
     * @param Conference $conference
     * @return array Stats about generation
     */
    public function batchGenerateCertificates(Conference $conference): array
    {
        $stats = [
            'authors' => 0,
            'failed' => 0,
        ];
        
        // Get all accepted papers without certificates
        $papers = Paper::where('conference_id', $conference->id)
            ->whereIn('status', ['payment_verified', 'deliverables_pending', 'completed'])
            ->whereDoesntHave('deliverables', function ($query) {
                $query->where('type', 'certificate');
            })
            ->with('user')
            ->get();
        
        foreach ($papers as $paper) {
            try {
                $path = $this->generateCertificate($paper->user, 'author', $paper);
                
                // Create deliverable record
                $paper->deliverables()->create([
                    'user_id' => $paper->user_id,
                    'type' => 'certificate',
                    'direction' => 'admin_send',
                    'file_path' => $path,
                    'original_name' => basename($path),
                    'notes' => 'Certificate auto-generated',
                    'sent_at' => now(),
                ]);
                
                $stats['authors']++;
            } catch (\Exception $e) {
                \Log::error("Failed to generate certificate for paper {$paper->id}: " . $e->getMessage());
                $stats['failed']++;
            }
        }
        
        return $stats;
    }
}
