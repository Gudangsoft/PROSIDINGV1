<div class="max-w-5xl mx-auto py-8 px-4">

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">My Certificates &amp; Materials</h1>
        <p class="text-gray-500 text-sm mt-1">Download your certificates and conference materials</p>
    </div>

    {{-- Access Locked --}}
    @if(!$hasAccess)
    <div class="bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-200 rounded-2xl p-10 text-center">
        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-orange-800 mb-2">Access Locked</h3>
        <p class="text-sm text-orange-700 max-w-sm mx-auto">Certificates and materials are only available after your registration payment is verified by the committee.</p>
        <a href="{{ route('participant.payment') }}" class="inline-flex items-center gap-2 mt-5 px-5 py-2.5 bg-orange-500 text-white rounded-xl text-sm font-semibold hover:bg-orange-600 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            Upload Payment Proof
        </a>
    </div>

    @elseif($conferenceGroups->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border p-14 text-center text-gray-400">
        <svg class="w-14 h-14 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
        </svg>
        <p class="font-semibold text-gray-500">No content available yet</p>
        <p class="text-sm mt-1">The committee will upload your certificates and materials soon.</p>
    </div>

    @else

    @foreach($conferenceGroups as $group)
    @php
        $conference = $group['conference'];
        $materials  = $group['materials'];
        $certs      = $materials->get('sertifikat', collect());
        $otherMats  = $materials->except('sertifikat');
        $totalOther = $otherMats->flatten()->count();
    @endphp

    {{-- CERTIFICATE SECTION --}}
    @if($certs->isNotEmpty())
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">My Certificates</h2>
                <p class="text-xs text-gray-500">{{ $conference->name }}</p>
            </div>
            <span class="ml-auto bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-full">{{ $certs->count() }} certificate{{ $certs->count() > 1 ? 's' : '' }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($certs as $cert)
            <div class="relative overflow-hidden rounded-2xl border-2 border-yellow-300 shadow-md bg-white hover:shadow-lg transition-all duration-300">
                <div class="h-2 bg-gradient-to-r from-yellow-400 via-amber-300 to-yellow-500"></div>
                <div class="mx-3 mt-2 mb-3 border border-yellow-200 rounded-xl p-4 bg-gradient-to-br from-yellow-50/60 to-amber-50/40">
                    <div class="absolute top-8 right-4 pointer-events-none">
                        <svg class="w-20 h-20 text-yellow-300 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-800 text-sm leading-tight">{{ $cert->title }}</p>
                            <p class="text-xs text-amber-700 font-medium mt-0.5">{{ $conference->name }}</p>
                            @if($cert->description)
                                <p class="text-xs text-gray-500 mt-1">{{ $cert->description }}</p>
                            @endif
                            <div class="flex items-center gap-1.5 mt-1">
                                <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <span class="text-xs text-green-600 font-medium">Verified Certificate</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-4">
                        <a href="{{ asset('storage/'.$cert->file_path) }}" download="{{ $cert->file_name }}"
                           class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-yellow-500 to-amber-500 text-white rounded-xl text-sm font-semibold hover:from-yellow-600 hover:to-amber-600 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download Certificate
                        </a>
                        <a href="{{ asset('storage/'.$cert->file_path) }}" target="_blank"
                           class="inline-flex items-center justify-center gap-1.5 px-3 py-2.5 border-2 border-yellow-300 text-amber-700 rounded-xl text-sm font-semibold hover:bg-yellow-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            View
                        </a>
                    </div>
                </div>
                <div class="h-1 bg-gradient-to-r from-yellow-400 via-amber-300 to-yellow-500"></div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- OTHER MATERIALS SECTION --}}
    @if($totalOther > 0)
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">Conference Materials</h2>
                <p class="text-xs text-gray-500">{{ $conference->name }}</p>
            </div>
            <span class="ml-auto bg-teal-100 text-teal-700 text-xs font-bold px-2.5 py-1 rounded-full">{{ $totalOther }} file{{ $totalOther > 1 ? 's' : '' }}</span>
        </div>

        @if($otherMats->has('ppt'))
        <div class="mb-4">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 pl-1">Presentations (PPT)</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($otherMats['ppt'] as $mat)
                <div class="bg-white border border-blue-100 rounded-xl p-4 flex items-center gap-3 hover:shadow-sm hover:border-blue-200 transition group">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-200 transition">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm truncate">{{ $mat->title }}</p>
                        @if($mat->description)<p class="text-xs text-gray-400 truncate">{{ $mat->description }}</p>@endif
                        @if($mat->file_size)<p class="text-xs text-gray-400 mt-0.5">{{ $mat->file_size }}</p>@endif
                    </div>
                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        <a href="{{ asset('storage/'.$mat->file_path) }}" download="{{ $mat->file_name }}"
                            class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition" title="Download">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                        <a href="{{ asset('storage/'.$mat->file_path) }}" target="_blank"
                            class="p-2 border border-gray-200 text-gray-500 rounded-lg hover:bg-gray-50 transition" title="View">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($otherMats->has('materi'))
        <div class="mb-4">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 pl-1">Materials</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($otherMats['materi'] as $mat)
                <div class="bg-white border border-teal-100 rounded-xl p-4 flex items-center gap-3 hover:shadow-sm hover:border-teal-200 transition group">
                    <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-teal-200 transition">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm truncate">{{ $mat->title }}</p>
                        @if($mat->description)<p class="text-xs text-gray-400 truncate">{{ $mat->description }}</p>@endif
                        @if($mat->file_size)<p class="text-xs text-gray-400 mt-0.5">{{ $mat->file_size }}</p>@endif
                    </div>
                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        <a href="{{ asset('storage/'.$mat->file_path) }}" download="{{ $mat->file_name }}"
                            class="p-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition" title="Download">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                        <a href="{{ asset('storage/'.$mat->file_path) }}" target="_blank"
                            class="p-2 border border-gray-200 text-gray-500 rounded-lg hover:bg-gray-50 transition" title="View">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($otherMats->has('lainnya'))
        <div class="mb-4">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 pl-1">Others</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($otherMats['lainnya'] as $mat)
                <div class="bg-white border rounded-xl p-4 flex items-center gap-3 hover:shadow-sm transition">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm truncate">{{ $mat->title }}</p>
                        @if($mat->description)<p class="text-xs text-gray-400 truncate">{{ $mat->description }}</p>@endif
                        @if($mat->file_size)<p class="text-xs text-gray-400 mt-0.5">{{ $mat->file_size }}</p>@endif
                    </div>
                    <a href="{{ asset('storage/'.$mat->file_path) }}" download="{{ $mat->file_name }}"
                        class="p-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition" title="Download">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
    @endif

    @if($certs->isEmpty() && $totalOther === 0)
    <div class="bg-white rounded-2xl border p-10 text-center text-gray-400 mb-8">
        <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <p class="text-sm font-medium">No content uploaded yet for <span class="text-gray-600">{{ $conference->name }}</span></p>
    </div>
    @endif

    @endforeach
    @endif

</div>
