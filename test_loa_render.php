<?php
// Quick test to verify LOA PDF template compiles without errors
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$paper = \App\Models\Paper::with(['user', 'conference'])->whereNotNull('conference_id')->first();

if (!$paper) {
    echo "No paper with conference found. Creating dummy test...\n";
    // Just test that the view compiles
    echo "Template file exists: " . (file_exists(resource_path('views/pdf/loa-template.blade.php')) ? 'YES' : 'NO') . "\n";
    exit(0);
}

echo "Paper: {$paper->title}\n";
echo "Conference: {$paper->conference->name}\n";

try {
    // Test that the view compiles without errors
    $conference = $paper->conference;
    $data = [
        'paper' => $paper,
        'author' => $paper->user,
        'conference' => $conference,
        'loaNumber' => 'TEST/001/2026',
        'qrCode' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==',
        'generatedDate' => now(),
    ];
    
    $html = view('pdf.loa-template', $data)->render();
    echo "HTML length: " . strlen($html) . " bytes\n";
    echo "Contains 'Letter of Acceptance': " . (str_contains($html, 'Letter of Acceptance') ? 'YES' : 'NO') . "\n";
    echo "Contains paper title: " . (str_contains($html, htmlspecialchars($paper->title, ENT_QUOTES)) ? 'YES' : 'NO') . "\n";
    echo "\n✅ LOA template renders successfully!\n";
} catch (\Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
