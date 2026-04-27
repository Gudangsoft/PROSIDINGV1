<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="mb-6">
        <a href="{{ route('author.papers') }}" class="text-blue-600 hover:text-blue-800 text-sm">&larr; Kembali ke Daftar Paper</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">{{ $paper->title }}</h1>
        <div class="flex items-center gap-3 mt-2">
            @php $color = $paper->status_color; @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                @if($color==='green') bg-green-100 text-green-800
                @elseif($color==='red') bg-red-100 text-red-800
                @elseif($color==='yellow' || $color==='amber') bg-yellow-100 text-yellow-800
                @elseif($color==='blue' || $color==='cyan') bg-blue-100 text-blue-800
                @elseif($color==='orange') bg-orange-100 text-orange-800
                @elseif($color==='indigo' || $color==='purple') bg-indigo-100 text-indigo-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ $paper->status_label }}
            </span>
            <span class="text-sm text-gray-500">Disubmit: {{ $paper->submitted_at?->format('d M Y h:i A') }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 mb-4 text-sm">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Paper Info --}}
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Informasi Paper</h3>
                <div class="space-y-3 text-sm">
                    <div><span class="text-gray-500 font-medium">Topik:</span> <span class="text-gray-800">{{ $paper->topic }}</span></div>
                    <div><span class="text-gray-500 font-medium">Kata Kunci:</span> <span class="text-gray-800">{{ $paper->keywords }}</span></div>
                    <div>
                        <span class="text-gray-500 font-medium">Abstrak:</span>
                        <p class="text-gray-800 mt-1 whitespace-pre-line break-words">{{ $paper->abstract }}</p>
                    </div>
                </div>
            </div>

            {{-- Files --}}
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold text-gray-800 mb-4">File yang Diunggah</h3>
                <div class="space-y-2">
                    @foreach($paper->files as $file)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $file->original_name }}</p>
                                <p class="text-xs text-gray-400">{{ ucfirst(str_replace('_', ' ', $file->type)) }} &bull; {{ $file->file_size_human }} &bull; {{ $file->created_at->format('d M Y h:i A') }}</p>
                                @if($file->notes) <p class="text-xs text-gray-500 mt-1">{{ $file->notes }}</p> @endif
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Download</a>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Reviews --}}
            @if($paper->reviews->count())
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Hasil Review</h3>
                <div class="space-y-4">
                    @foreach($paper->reviews->where('status', 'completed') as $review)
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-medium text-gray-800">Reviewer</p>
                                <p class="text-xs text-gray-400">{{ $review->reviewed_at?->format('d M Y h:i A') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($review->recommendation==='accept') bg-green-100 text-green-800
                                    @elseif($review->recommendation==='reject') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ \App\Models\Review::RECOMMENDATION_LABELS[$review->recommendation] ?? '-' }}
                                </span>
                                <p class="text-sm text-gray-500 mt-1">Skor: {{ $review->score }}/100</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-700 whitespace-pre-line bg-gray-50 p-3 rounded">{{ $review->comments }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Editor Notes --}}
            @if($paper->editor_notes)
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <h3 class="font-semibold text-yellow-800 mb-2">Catatan Editor</h3>
                <p class="text-sm text-yellow-700 whitespace-pre-line">{{ $paper->editor_notes }}</p>
            </div>
            @endif

            {{-- Discussions (semua stage) --}}
            @php
                $allDiscussions = $paper->discussions ?? collect();
                $stageLabels = [
                    'submission'  => 'Pre-Review Discussions',
                    'review'      => 'Review Discussions',
                    'copyediting' => 'Copyediting Discussions',
                    'production'  => 'Production Discussions',
                ];
            @endphp
            @if($allDiscussions->count())
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-semibold text-gray-800">Diskusi Paper</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Diskusi antara editor dan author terkait paper ini.</p>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($allDiscussions as $disc)
                    <div>
                        {{-- Discussion Header --}}
                        <div wire:click="openDiscussion({{ $disc->id }})"
                             class="flex items-center justify-between px-6 py-4 cursor-pointer hover:bg-gray-50 transition-colors">
                            <div class="flex items-start gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-blue-700 flex-shrink-0 mt-0.5">
                                    {{ strtoupper(substr($disc->user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-semibold text-gray-800 text-sm">{{ $disc->subject }}</span>
                                        @if($disc->is_closed)
                                            <span class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded text-[10px] font-medium">Ditutup</span>
                                        @endif
                                        <span class="bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded text-[10px]">
                                            {{ $stageLabels[$disc->stage] ?? ucfirst($disc->stage) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-gray-400 mt-0.5">
                                        <span>{{ $disc->user->name }}</span>
                                        <span>•</span>
                                        <span>{{ $disc->messages->count() - 1 }} balasan</span>
                                        <span>•</span>
                                        <span>{{ $disc->latestMessage?->created_at?->diffForHumans() ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform {{ $activeDiscussionId === $disc->id ? 'rotate-180' : '' }}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>

                        {{-- Discussion Messages (expanded) --}}
                        @if($activeDiscussionId === $disc->id)
                        <div class="bg-gray-50 border-t border-gray-100 px-6 py-4">
                            {{-- Messages --}}
                            <div class="space-y-4 max-h-72 overflow-y-auto mb-4">
                                @foreach($disc->messages as $msg)
                                @php
                                    $isMe = $msg->user_id === Auth::id();
                                @endphp
                                <div class="flex gap-3 {{ $isMe ? 'flex-row-reverse' : '' }}">
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-[11px] font-bold flex-shrink-0
                                        {{ $isMe ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                        {{ strtoupper(substr($msg->user->name, 0, 1)) }}
                                    </div>
                                    <div class="{{ $isMe ? 'items-end' : 'items-start' }} flex flex-col max-w-[80%]">
                                        <div class="flex items-center gap-2 mb-1 {{ $isMe ? 'flex-row-reverse' : '' }}">
                                            <span class="text-xs font-semibold text-gray-700">{{ $isMe ? 'Anda' : $msg->user->name }}</span>
                                            <span class="text-[10px] text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="px-3 py-2 rounded-lg text-sm text-gray-700 whitespace-pre-wrap
                                            {{ $isMe ? 'bg-blue-100 text-blue-900' : 'bg-white border border-gray-200' }}">
                                            {{ $msg->message }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            {{-- Reply Form --}}
                            @if(!$disc->is_closed)
                            <div class="flex gap-2 border-t border-gray-200 pt-3">
                                <input wire:model="replyMessage"
                                       wire:keydown.enter="sendReply"
                                       type="text"
                                       placeholder="Tulis balasan..."
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <button wire:click="sendReply" type="button"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition flex-shrink-0">
                                    <span wire:loading.remove wire:target="sendReply">Kirim</span>
                                    <span wire:loading wire:target="sendReply">...</span>
                                </button>
                            </div>
                            @else
                            <p class="text-xs text-gray-400 italic border-t border-gray-200 pt-3 text-center">Diskusi ini telah ditutup oleh editor.</p>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- LOA & Payment Info --}}
            @if($paper->loa_url)
            <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="font-semibold text-green-800 text-lg">Letter of Acceptance (LOA)</h3>
                </div>
                <p class="text-sm text-green-700 mb-3">Paper Anda telah diterima! Silakan unduh LOA dan lakukan pembayaran.</p>
                <a href="{{ $paper->loa_url }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Buka LOA
                </a>

                @if($paper->payment)
                <div class="mt-4 pt-4 border-t border-green-200">
                    <h4 class="text-sm font-bold text-green-800 mb-2">Tagihan Pembayaran</h4>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-green-600 text-xs">Invoice:</span>
                            <p class="font-mono font-medium text-green-800">{{ $paper->payment->invoice_number }}</p>
                        </div>
                        <div>
                            <span class="text-green-600 text-xs">Jumlah:</span>
                            <p class="font-bold text-green-800 text-lg">{{ $paper->payment->formatted_amount }}</p>
                        </div>
                    </div>

                    {{-- Info Rekening Bank --}}
                    @php
                        $pdConf = $paper->conference;
                        $pdBankName = $pdConf->payment_bank_name ?? null;
                        $pdBankAccount = $pdConf->payment_bank_account ?? null;
                        $pdAccountHolder = $pdConf->payment_account_holder ?? null;
                        $pdInstructions = $pdConf->payment_instructions ?? null;
                    @endphp
                    @if($pdBankName || $pdBankAccount)
                    <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-xs font-bold text-blue-800 mb-1.5 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Transfer ke Rekening:
                        </p>
                        <div class="text-xs space-y-0.5">
                            @if($pdBankName)<p class="text-gray-700">Bank: <span class="font-medium">{{ $pdBankName }}</span></p>@endif
                            @if($pdBankAccount)<p class="text-gray-700">No. Rekening: <span class="font-mono font-bold text-gray-900">{{ $pdBankAccount }}</span></p>@endif
                            @if($pdAccountHolder)<p class="text-gray-700">a.n. <span class="font-medium">{{ $pdAccountHolder }}</span></p>@endif
                        </div>
                        @if($pdInstructions)
                        <p class="text-[10px] text-blue-600 mt-1.5 italic">{{ $pdInstructions }}</p>
                        @endif
                    </div>
                    @endif

                    @if(in_array($paper->payment->status, ['pending', 'rejected']))
                    <a href="{{ route('author.paper.payment', $paper) }}" class="inline-flex items-center gap-2 mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Upload Bukti Bayar
                    </a>
                    @endif
                </div>
                @endif
            </div>
            @endif

            {{-- Deliverables from Admin (Buku Prosiding, Sertifikat) --}}
            @if(in_array($paper->status, ['deliverables_pending', 'completed']))
            @php
                $adminSentDeliverables = $paper->deliverables->where('direction', 'admin_send');
            @endphp
            @if($adminSentDeliverables->count())
            <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <h3 class="font-semibold text-purple-800 text-lg">Luaran dari Panitia</h3>
                </div>
                <div class="space-y-3">
                    @foreach($adminSentDeliverables as $deliverable)
                    <div class="bg-white rounded-lg border border-purple-100 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                @if($deliverable->type === 'prosiding_book')
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                @else
                                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-800">{{ \App\Models\Deliverable::TYPE_LABELS[$deliverable->type] ?? $deliverable->type }}</p>
                                    <p class="text-xs text-gray-500">{{ $deliverable->original_name }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Dikirim: {{ $deliverable->sent_at?->format('d M Y h:i A') }}</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $deliverable->file_path) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-purple-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Download
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @endif

            {{-- Video Pemaparan --}}
            @if(in_array($paper->status, ['payment_verified', 'deliverables_pending', 'completed']))
            <div id="video-section" class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-lg">Video Pemaparan</h3>
                </div>

                @if($paper->video_presentation_url)
                <div class="mb-4">
                    @php
                        $videoUrlRaw = $paper->video_presentation_url;
                        // Convert YouTube watch URL to embed
                        $embedUrl = null;
                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/', $videoUrlRaw, $m)) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $m[1];
                        }
                    @endphp
                    @if($embedUrl)
                    <div class="relative rounded-lg overflow-hidden bg-black" style="padding-top:56.25%">
                        <iframe class="absolute inset-0 w-full h-full"
                            src="{{ $embedUrl }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                    @else
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border">
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <a href="{{ $videoUrlRaw }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline text-sm truncate">{{ $videoUrlRaw }}</a>
                    </div>
                    @endif
                    <p class="text-xs text-gray-400 mt-2">Link yang tersimpan. Anda dapat menggantinya kapan saja.</p>
                </div>
                @endif

                <form wire:submit="submitVideoUrl" class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            {{ $paper->video_presentation_url ? 'Ganti Link Video' : 'Submit Link Video' }}
                            <span class="text-gray-400 font-normal">(YouTube, Google Drive, dll.)</span>
                        </label>
                        <input wire:model="videoUrl"
                               type="url"
                               placeholder="https://www.youtube.com/watch?v=..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                        @error('videoUrl') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-red-600 text-white py-2.5 rounded-lg hover:bg-red-700 text-sm font-semibold transition"
                        wire:loading.attr="disabled" wire:loading.class="opacity-60">
                        <span wire:loading.remove wire:target="submitVideoUrl">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.82v6.361a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            {{ $paper->video_presentation_url ? 'Perbarui Video' : 'Submit Video' }}
                        </span>
                        <span wire:loading wire:target="submitVideoUrl">Menyimpan...</span>
                    </button>
                </form>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Status Progress --}}
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Progress</h3>
                @php
                    $steps = [
                        ['status' => 'submitted', 'label' => 'Submitted'],
                        ['status' => 'in_review', 'label' => 'Review'],
                        ['status' => 'accepted', 'label' => 'Accepted'],
                        ['status' => 'payment_verified', 'label' => 'Pembayaran'],
                        ['status' => 'completed', 'label' => 'Selesai'],
                    ];
                    $statusOrder = ['submitted','screening','in_review','revision_required','revised','accepted','rejected','payment_pending','payment_uploaded','payment_verified','deliverables_pending','completed'];
                    $currentIdx = array_search($paper->status, $statusOrder);
                @endphp
                <div class="space-y-3">
                    @foreach($steps as $idx => $step)
                        @php
                            $stepIdx = array_search($step['status'], $statusOrder);
                            $done = $currentIdx >= $stepIdx && $paper->status !== 'rejected';
                        @endphp
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $done ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                @if($done) ✓ @else {{ $idx+1 }} @endif
                            </div>
                            <span class="text-sm {{ $done ? 'text-green-700 font-medium' : 'text-gray-500' }}">{{ $step['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Revision Upload --}}
            @if($paper->status === 'revision_required')
            <div class="bg-orange-50 border-l-4 border-orange-500 rounded-lg p-6 mb-6">
                <div class="flex items-start gap-3 mb-4">
                    <svg class="w-6 h-6 text-orange-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="font-bold text-orange-800 text-lg">Revisi Diperlukan</h3>
                        <p class="text-sm text-orange-700 mt-1">Paper Anda memerlukan revisi. Silakan upload file revisi terbaru di bawah ini.</p>
                    </div>
                </div>

                @php
                    $revisionFiles = $paper->files->where('type', 'revision');
                @endphp

                @if($revisionFiles->count() > 0)
                <div class="mb-4">
                    <p class="text-sm font-semibold text-orange-800 mb-2">File Revisi yang Sudah Diupload:</p>
                    <div class="space-y-2">
                        @foreach($revisionFiles as $file)
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-orange-200">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $file->original_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $file->file_size_human }} &bull; {{ $file->created_at->format('d M Y h:i A') }}</p>
                                    @if($file->notes) <p class="text-xs text-gray-600 mt-1">Catatan: {{ $file->notes }}</p> @endif
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-orange-600 hover:text-orange-800 text-sm font-medium">Download</a>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-orange-600 mt-2">💡 Anda dapat mengupload file revisi baru jika diperlukan</p>
                </div>
                @endif

                <div class="bg-white rounded-lg p-4 border border-orange-200">
                    <h4 class="font-semibold text-gray-800 mb-3">Upload File Revisi Baru</h4>

                    @if(session('error'))
                    <div class="mb-3 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        {{ session('error') }}
                    </div>
                    @endif

                    {{-- Standard multipart form — file dikirim langsung saat submit,
                         tidak melalui Livewire tmp sehingga tidak ada risiko kadaluarsa --}}
                    <form action="{{ route('author.paper.revision', $paper) }}"
                          method="POST"
                          enctype="multipart/form-data"
                          id="revision-upload-form">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                File Revisi (.pdf, .doc, .docx, max 10MB)
                            </label>
                            <input type="file"
                                   name="revision_file"
                                   id="revision_file"
                                   accept=".pdf,.doc,.docx"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                                          @error('revision_file') border-red-400 bg-red-50 @enderror">
                            @error('revision_file')
                                <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            {{-- Progress bar muncul saat submit --}}
                            <div id="revision-upload-progress" class="hidden mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-orange-500 h-1.5 rounded-full animate-pulse w-full"></div>
                                </div>
                                <p class="text-orange-600 text-xs mt-1 flex items-center gap-1">
                                    <svg class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Mengunggah file, harap tunggu...
                                </p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Revisi (opsional)</label>
                            <textarea name="revision_notes"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                      placeholder="Jelaskan perubahan yang telah Anda lakukan...">{{ old('revision_notes') }}</textarea>
                        </div>
                        <button type="submit"
                                id="revision-submit-btn"
                                class="w-full bg-orange-600 text-white py-2.5 rounded-lg hover:bg-orange-700 text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Submit Revisi
                        </button>
                    </form>

                    <script>
                        document.getElementById('revision-upload-form').addEventListener('submit', function(e) {
                            var fileInput = document.getElementById('revision_file');
                            if (!fileInput.files || fileInput.files.length === 0) {
                                e.preventDefault();
                                fileInput.setCustomValidity('Pilih file terlebih dahulu.');
                                fileInput.reportValidity();
                                return;
                            }
                            var btn = document.getElementById('revision-submit-btn');
                            var progress = document.getElementById('revision-upload-progress');
                            btn.disabled = true;
                            btn.classList.add('opacity-60', 'cursor-not-allowed');
                            btn.innerHTML = '<svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengirim Revisi...';
                            progress.classList.remove('hidden');
                        });
                    </script>
                </div>

            </div>
            @endif

            {{-- Quick Actions --}}
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold text-gray-800 mb-3">Aksi</h3>
                <div class="space-y-2">
                    @if(in_array($paper->status, ['payment_pending','payment_uploaded']))
                        <a href="{{ route('author.paper.payment', $paper) }}" class="block w-full text-center bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 text-sm font-medium">Upload Pembayaran</a>
                    @endif
                    @if(in_array($paper->status, ['payment_verified','deliverables_pending','completed']))
                        <a href="{{ route('author.paper.deliverables', $paper) }}" class="block w-full text-center bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 text-sm font-medium">Upload Luaran</a>
                    @endif
                    @if(in_array($paper->status, ['payment_verified','deliverables_pending','completed']))
                        <a href="#video-section"
                           onclick="document.getElementById('video-section').scrollIntoView({behavior:'smooth'}); return false;"
                           class="flex items-center justify-center gap-2 w-full text-center bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 text-sm font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            {{ $paper->video_presentation_url ? 'Perbarui Video' : 'Submit Video Pemaparan' }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
