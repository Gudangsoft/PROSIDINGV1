<div class="max-w-4xl mx-auto">

    {{-- Success Message --}}
    @if($success)
    <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-3">Pendaftaran Berhasil!</h2>
        <p class="text-gray-600 mb-6">
            Terima kasih telah mendaftar sebagai reviewer. Akun Anda telah dibuat dan Anda dapat login untuk mengakses dashboard reviewer.
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Login Sekarang
            </a>
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>
    @else

    {{-- Header Card --}}
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl p-8 mb-6 text-white shadow-lg">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Reviewer Registration</h1>
                <p class="text-purple-200 text-sm mt-0.5">Daftar sebagai reviewer untuk me-review paper</p>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <form wire:submit="register">

            {{-- ── SEKSI 1: Data Pribadi ─────────────────────────────────────── --}}
            <div class="px-8 pt-8 pb-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Personal Information</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <input id="name" type="text" wire:model="name" 
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition @error('name') border-red-400 bg-red-50 @enderror"
                                placeholder="Dr. John Doe">
                        </div>
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Gender --}}
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </span>
                            <select id="gender" wire:model="gender"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white appearance-none @error('gender') border-red-400 bg-red-50 @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                        @error('gender')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Institution --}}
                    <div>
                        <label for="institution" class="block text-sm font-medium text-gray-700 mb-1.5">Institusi / Universitas <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </span>
                            <input id="institution" type="text" wire:model="institution"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition @error('institution') border-red-400 bg-red-50 @enderror"
                                placeholder="Universitas Indonesia">
                        </div>
                        @error('institution')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Country --}}
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1.5">Negara <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <select id="country" wire:model="country"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white appearance-none @error('country') border-red-400 bg-red-50 @enderror">
                                <option value="">-- Pilih Negara --</option>
                                <option value="Indonesia">🇮🇩 Indonesia</option>
                                <option value="" disabled>─────────────────</option>
                                @foreach($this->countries as $c)
                                    <option value="{{ $c }}">{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('country')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <input id="email" type="email" wire:model="email"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition @error('email') border-red-400 bg-red-50 @enderror"
                                placeholder="email@example.com">
                        </div>
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <input id="phone" type="text" wire:model="phone" placeholder="+62xxx"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition @error('phone') border-red-400 bg-red-50 @enderror">
                        </div>
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ── SEKSI 2: Informasi Akademik/Reviewer ──────────────────────── --}}
            <div class="px-8 py-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Academic & Reviewer Information</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Qualification --}}
                    <div>
                        <label for="qualification" class="block text-sm font-medium text-gray-700 mb-1.5">Kualifikasi Pendidikan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                            </span>
                            <select id="qualification" wire:model="qualification"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white appearance-none @error('qualification') border-red-400 bg-red-50 @enderror">
                                <option value="">-- Pilih Kualifikasi --</option>
                                <option value="Professor">Professor</option>
                                <option value="Associate Professor">Associate Professor</option>
                                <option value="PhD / Doctoral">PhD / Doctoral</option>
                                <option value="Master / S2">Master / S2</option>
                                <option value="Bachelor / S1">Bachelor / S1</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        @error('qualification')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Review Experience --}}
                    <div>
                        <label for="review_experience" class="block text-sm font-medium text-gray-700 mb-1.5">Pengalaman Review <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <select id="review_experience" wire:model="review_experience"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white appearance-none">
                                <option value="">-- Pilih --</option>
                                <option value="Belum pernah">Belum pernah</option>
                                <option value="< 1 tahun">Kurang dari 1 tahun</option>
                                <option value="1-3 tahun">1-3 tahun</option>
                                <option value="3-5 tahun">3-5 tahun</option>
                                <option value="> 5 tahun">Lebih dari 5 tahun</option>
                            </select>
                        </div>
                    </div>

                    {{-- Research Interest --}}
                    <div class="md:col-span-2">
                        <label for="research_interest" class="block text-sm font-medium text-gray-700 mb-1.5">Bidang Penelitian <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            </span>
                            <textarea id="research_interest" wire:model="research_interest" rows="2"
                                placeholder="e.g. Pharmaceutical Technology, Pharmacology, Clinical Pharmacy"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition resize-none @error('research_interest') border-red-400 bg-red-50 @enderror"></textarea>
                        </div>
                        @error('research_interest')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Expertise --}}
                    <div class="md:col-span-2">
                        <label for="expertise" class="block text-sm font-medium text-gray-700 mb-1.5">Area Keahlian untuk Review <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                            </span>
                            <textarea id="expertise" wire:model="expertise" rows="2"
                                placeholder="Tuliskan area keahlian spesifik yang bisa Anda review, misal: Drug Delivery System, Herbal Medicine, Pharmacokinetics"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition resize-none @error('expertise') border-red-400 bg-red-50 @enderror"></textarea>
                        </div>
                        @error('expertise')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ── SEKSI 3: Academic Profiles (Optional) ─────────────────────── --}}
            <div class="px-8 py-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Academic Profiles <span class="text-gray-400 font-normal text-sm">(Optional)</span></h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Scopus ID --}}
                    <div>
                        <label for="scopus_id" class="block text-sm font-medium text-gray-700 mb-1.5">Scopus Author ID</label>
                        <input id="scopus_id" type="text" wire:model="scopus_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                            placeholder="e.g. 57200000000">
                    </div>

                    {{-- ORCID --}}
                    <div>
                        <label for="orcid" class="block text-sm font-medium text-gray-700 mb-1.5">ORCID ID</label>
                        <input id="orcid" type="text" wire:model="orcid"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                            placeholder="e.g. 0000-0002-1234-5678">
                    </div>

                    {{-- Google Scholar --}}
                    <div class="md:col-span-2">
                        <label for="google_scholar" class="block text-sm font-medium text-gray-700 mb-1.5">Google Scholar Profile URL</label>
                        <input id="google_scholar" type="url" wire:model="google_scholar"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition @error('google_scholar') border-red-400 bg-red-50 @enderror"
                            placeholder="https://scholar.google.com/citations?user=...">
                        @error('google_scholar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- CV Upload --}}
                    <div class="md:col-span-2">
                        <label for="cv_file" class="block text-sm font-medium text-gray-700 mb-1.5">Upload CV / Resume <span class="text-gray-400 font-normal">(PDF, DOC, DOCX - max 5MB)</span></label>
                        <input id="cv_file" type="file" wire:model="cv_file" accept=".pdf,.doc,.docx"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 @error('cv_file') border-red-400 bg-red-50 @enderror">
                        @error('cv_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        <div wire:loading wire:target="cv_file" class="text-sm text-purple-600 mt-2">
                            <svg class="animate-spin inline w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Uploading...
                        </div>
                    </div>

                    {{-- Other Information --}}
                    <div class="md:col-span-2">
                        <label for="other_info" class="block text-sm font-medium text-gray-700 mb-1.5">Informasi Tambahan <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <textarea id="other_info" wire:model="other_info" rows="2"
                            placeholder="Informasi tambahan yang ingin Anda sampaikan"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition resize-none"></textarea>
                    </div>
                </div>
            </div>

            {{-- ── SEKSI 4: Keamanan Akun ────────────────────────────────────── --}}
            <div class="px-8 py-6 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Account Security</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <input id="password" type="password" wire:model="password"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition @error('password') border-red-400 bg-red-50 @enderror"
                                placeholder="Minimal 8 karakter">
                        </div>
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Password Confirmation --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </span>
                            <input id="password_confirmation" type="password" wire:model="password_confirmation"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                                placeholder="Ulangi password">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Submit Button ─────────────────────────────────────────────── --}}
            <div class="px-8 py-6 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-500">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-purple-600 hover:underline font-medium">Login di sini</a>
                </p>
                <button type="submit" 
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="register">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    <span wire:loading wire:target="register">
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    <span wire:loading.remove wire:target="register">Daftar sebagai Reviewer</span>
                    <span wire:loading wire:target="register">Processing...</span>
                </button>
            </div>

        </form>
    </div>
    @endif
</div>
