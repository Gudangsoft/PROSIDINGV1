<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification – {{ $code }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden">

        {{-- Header band --}}
        <div class="bg-gradient-to-r {{ $certificate ? 'from-blue-800 to-indigo-700' : 'from-red-700 to-red-600' }} px-8 py-6 text-center">
            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-3">
                @if($certificate)
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0
                             3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946
                             3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138
                             3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806
                             3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438
                             3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                @else
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                @endif
            </div>
            <h1 class="text-2xl font-bold text-white tracking-wide">
                {{ $certificate ? 'Certificate Valid ✓' : 'Certificate Not Found' }}
            </h1>
            <p class="{{ $certificate ? 'text-blue-200' : 'text-red-200' }} text-sm mt-1">
                {{ $certificate ? 'Official Authenticity Check' : 'Pemeriksaan Keaslian Resmi' }}
            </p>
        </div>

        {{-- Body --}}
        <div class="px-8 py-6">

            {{-- Certificate number --}}
            <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 mb-5">
                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75
                             A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5
                             A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0
                             1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789
                             6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z"/>
                </svg>
                <span class="text-xs text-gray-500 font-medium">Certificate No.</span>
                <code class="ml-auto font-mono text-sm bg-white border border-gray-200 px-2 py-0.5 rounded text-blue-800 font-bold">{{ $code }}</code>
            </div>

            @if($certificate)
            {{-- Valid badge --}}
            <div class="flex items-start gap-3 bg-green-50 border border-green-200 rounded-xl p-4 mb-5">
                <div class="mt-0.5 w-6 h-6 rounded-full bg-green-500 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-green-800 text-sm">Valid Certificate</p>
                    <p class="text-green-700 text-xs mt-0.5">This certificate is registered and verified in our system.</p>
                </div>
            </div>

            {{-- Certificate details --}}
            <div class="border border-gray-100 rounded-xl divide-y divide-gray-100 mb-5 text-sm">
                <div class="flex items-center px-4 py-3">
                    <span class="text-gray-500 w-36 shrink-0">Issued to</span>
                    <span class="font-semibold text-gray-800">{{ $certificate->user->name ?? '-' }}</span>
                </div>
                <div class="flex items-center px-4 py-3">
                    <span class="text-gray-500 w-36 shrink-0">Certificate Type</span>
                    <span class="text-gray-700">{{ $certificate->getTypeLabel() }}</span>
                </div>
                @if($certificate->paper)
                <div class="flex items-start px-4 py-3">
                    <span class="text-gray-500 w-36 shrink-0 pt-0.5">Paper Title</span>
                    <span class="text-gray-700">{{ $certificate->paper->title }}</span>
                </div>
                @endif
                @if($certificate->conference)
                <div class="flex items-center px-4 py-3">
                    <span class="text-gray-500 w-36 shrink-0">Event</span>
                    <span class="text-gray-700">{{ $certificate->conference->name }}</span>
                </div>
                @endif
                <div class="flex items-center px-4 py-3">
                    <span class="text-gray-500 w-36 shrink-0">Issued on</span>
                    <span class="text-gray-700">{{ ($certificate->generated_at ?? $certificate->created_at)->format('d F Y') }}</span>
                </div>
            </div>

            @else
            {{-- Invalid / Not found --}}
            <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
                <div class="mt-0.5 w-6 h-6 rounded-full bg-red-500 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-red-800 text-sm">Certificate Not Found</p>
                    <p class="text-red-700 text-xs mt-0.5">
                        Nomor sertifikat <code class="font-mono bg-red-100 px-1 rounded">{{ $code }}</code>
                        tidak ditemukan dalam sistem kami. Kemungkinan dokumen tidak valid atau nomor salah.
                    </p>
                </div>
            </div>
            @endif

            {{-- Note --}}
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 text-xs text-amber-800 mb-5">
                For further confirmation, please contact the organizing committee directly.
            </div>

            {{-- Footer --}}
            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-400">Verified at {{ now()->format('d F Y, h:i A') }} UTC</p>
                <a href="{{ url('/') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium hover:underline">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
