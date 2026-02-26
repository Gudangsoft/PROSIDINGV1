<div>
    <div class="max-w-4xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Sertifikat Saya</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar sertifikat yang telah diterbitkan untuk Anda</p>
        </div>

        @if($certificates->isEmpty())
        {{-- Empty state --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-yellow-50 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0
                             3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946
                             3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138
                             3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806
                             3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438
                             3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <h3 class="text-gray-700 font-semibold text-lg mb-1">Belum Ada Sertifikat</h3>
            <p class="text-gray-400 text-sm max-w-sm mx-auto">
                Sertifikat akan diterbitkan oleh panitia setelah proses verifikasi pembayaran dan pengumpulan berkas selesai.
            </p>
        </div>

        @else
        {{-- Certificate grid --}}
        <div class="grid gap-5">
            @foreach($certificates as $cert)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden
                        hover:shadow-md transition-shadow duration-200">
                {{-- Gold accent bar --}}
                <div class="h-1.5 bg-gradient-to-r from-yellow-400 via-amber-400 to-yellow-500"></div>

                <div class="p-6 flex items-start gap-5">
                    {{-- Icon --}}
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-yellow-400 to-amber-500 flex items-center
                                justify-center shrink-0 shadow-md shadow-yellow-200">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0
                                     3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946
                                     3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138
                                     3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806
                                     3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438
                                     3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-3 flex-wrap">
                            <div>
                                <p class="font-semibold text-gray-900 text-base">
                                    {{ $cert->getTypeLabel() }}
                                </p>
                                @if($cert->conference)
                                <p class="text-sm text-gray-500 mt-0.5">{{ $cert->conference->name }}</p>
                                @endif
                                @if($cert->paper)
                                <p class="text-xs text-gray-400 mt-1 line-clamp-1 italic">{{ $cert->paper->title }}</p>
                                @endif
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                                         bg-green-50 text-green-700 border border-green-200 shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Terverifikasi
                            </span>
                        </div>

                        <div class="mt-3 flex items-center gap-4 flex-wrap">
                            <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                <code class="font-mono">{{ $cert->cert_number }}</code>
                            </div>
                            @if($cert->generated_at)
                            <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $cert->generated_at->format('d F Y') }}
                            </div>
                            @endif
                        </div>

                        {{-- Action buttons --}}
                        @if($cert->file_path)
                        <div class="mt-4 flex items-center gap-2 flex-wrap">
                            <a href="{{ Storage::url($cert->file_path) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white text-xs
                                      font-medium rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download
                            </a>
                            <a href="{{ route('verify-certificate', ['code' => $cert->cert_number]) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-700 text-xs
                                      font-medium rounded-lg hover:bg-gray-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Verifikasi
                            </a>
                        </div>
                        @else
                        <p class="mt-3 text-xs text-amber-600 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            File sertifikat sedang diproses
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>
