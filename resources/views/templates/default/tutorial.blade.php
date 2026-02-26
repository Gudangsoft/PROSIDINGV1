<!DOCTYPE html>
@php
    $siteLanguage = \App\Models\Setting::getValue('site_language', 'id');
    app()->setLocale($siteLanguage);
    $siteName    = \App\Models\Setting::getValue('site_name', 'Prosiding LPKD-APJI');
    $siteTagline = \App\Models\Setting::getValue('site_tagline', '');
    $siteLogo    = \App\Models\Setting::getValue('site_logo');
    $footerText  = \App\Models\Setting::getValue('footer_text');
    $poweredBy   = \App\Models\Setting::getValue('powered_by', 'Powered by Laravel');
    $headerMenus = \App\Models\Menu::getTree('header');
@endphp
<html lang="{{ $siteLanguage }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial – {{ $siteName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('templates.default.partials.theme-config')
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    {{-- Navbar --}}
    <nav x-data="{ scrolled: false, mobileOpen: false }"
         @scroll.window="scrolled=(window.scrollY>60)"
         :class="scrolled?'bg-white shadow-md':'bg-white/90 backdrop-blur'"
         class="fixed top-0 w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-3">
                    @if($siteLogo)
                        <img src="{{ asset('storage/'.$siteLogo) }}" alt="Logo" class="h-10 w-10 object-contain rounded">
                    @else
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center shadow">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                    @endif
                    <a href="{{ url('/') }}" class="text-base font-bold text-gray-800 leading-tight hover:text-blue-700 transition">{{ $siteName }}</a>
                </div>
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-50 transition font-medium">Beranda</a>
                    <a href="{{ route('proceedings') }}" class="text-sm text-gray-600 hover:text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-50 transition font-medium">Publikasi</a>
                    <a href="{{ route('archive') }}" class="text-sm text-gray-600 hover:text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-50 transition font-medium">Arsip</a>
                    <a href="{{ route('tutorial') }}" class="text-sm font-semibold text-blue-700 bg-blue-50 px-3 py-2 rounded-lg">Tutorial</a>
                    @if($headerMenus->count())
                    @include(\App\Helpers\Template::view('partials.menu-dropdown'), ['items' => $headerMenus, 'depth' => 0])
                    @endif
                    <div class="w-px h-6 bg-gray-200 mx-2"></div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 font-medium transition shadow-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-blue-700 px-3 py-2 font-medium transition">Login</a>
                        <a href="{{ route('register') }}" class="text-sm bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 font-medium transition shadow-sm">Register</a>
                    @endauth
                </div>
                <button @click="mobileOpen=!mobileOpen" class="md:hidden flex items-center text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            {{-- Mobile menu --}}
            <div x-show="mobileOpen" x-cloak class="md:hidden pb-4 border-t space-y-1 pt-2">
                <a href="{{ url('/') }}" @click="mobileOpen=false" class="block px-3 py-2 text-sm text-gray-600 hover:bg-blue-50 rounded-lg">Beranda</a>
                <a href="{{ route('proceedings') }}" @click="mobileOpen=false" class="block px-3 py-2 text-sm text-gray-600 hover:bg-blue-50 rounded-lg">Publikasi</a>
                <a href="{{ route('archive') }}" @click="mobileOpen=false" class="block px-3 py-2 text-sm text-gray-600 hover:bg-blue-50 rounded-lg">Arsip</a>
                <a href="{{ route('tutorial') }}" class="block px-3 py-2 text-sm font-semibold text-blue-700 bg-blue-50 rounded-lg">Tutorial</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-blue-50 rounded-lg">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-blue-50 rounded-lg">Login</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-blue-50 rounded-lg">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <div class="pt-16">
        <div class="bg-gradient-to-br from-blue-700 to-indigo-800 py-16 px-4 text-center">
            <div class="max-w-3xl mx-auto">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white/20 mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Panduan & Tutorial</h1>
                <p class="text-blue-200 text-lg">Pelajari cara menggunakan sistem konferensi ini langkah demi langkah</p>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto px-4 py-14">

        @if($tutorials->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <p class="text-gray-400 text-sm">Panduan belum tersedia. Silakan cek kembali nanti.</p>
        </div>
        @else

        {{-- PDF Downloads row --}}
        @php $pdfs = $tutorials->where('pdf_path', '!=', null)->where('is_active', true); @endphp
        @if($pdfs->count())
        <div class="mb-10">
            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Download Panduan PDF</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($pdfs as $pdf)
                <a href="{{ Storage::url($pdf->pdf_path) }}" target="_blank"
                   class="flex items-center gap-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-red-200
                          transition px-5 py-4 group">
                    <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center shrink-0 group-hover:bg-red-100 transition">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 group-hover:text-blue-700 transition truncate">{{ $pdf->title }}</p>
                        <p class="text-xs text-red-600 mt-0.5">{{ $pdf->pdf_label ?? 'Download Panduan PDF' }}</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500 transition shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Step-by-step text tutorials --}}
        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Langkah-Langkah</h2>
        <div class="space-y-6">
            @foreach($tutorials->where('is_active', true) as $i => $tutorial)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition">
                {{-- Step header --}}
                <div class="flex items-center gap-4 px-6 py-4 border-b border-gray-50">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm shadow-blue-200">
                        {{ $i + 1 }}
                    </div>
                    <h3 class="font-semibold text-gray-800 text-base flex-1">{{ $tutorial->title }}</h3>
                    @if($tutorial->pdf_path)
                    <a href="{{ Storage::url($tutorial->pdf_path) }}" target="_blank"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 text-xs font-medium rounded-lg
                              hover:bg-red-100 transition shrink-0">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/></svg>
                        {{ $tutorial->pdf_label ?? 'PDF' }}
                    </a>
                    @endif
                </div>

                {{-- Content --}}
                @if($tutorial->content)
                <div class="px-6 py-5">
                    <div class="text-gray-600 text-sm leading-relaxed space-y-2">
                        @foreach(explode("\n", $tutorial->content) as $line)
                            @if(trim($line))
                            <p>{{ $line }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

    </div>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-gray-400 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm">
            @if($footerText)
                <p>{{ $footerText }}</p>
            @endif
            <p class="mt-1 text-gray-500 text-xs">{{ $poweredBy }}</p>
        </div>
    </footer>

</body>
</html>
