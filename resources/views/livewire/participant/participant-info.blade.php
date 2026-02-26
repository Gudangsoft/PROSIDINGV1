<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Participant Information</h1>
        <p class="text-gray-500 text-sm mt-1">Summary of your registration data and status</p>
    </div>

    {{-- Profile Card --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="font-semibold text-gray-800">Personal Data</h2>
        </div>
        <div class="p-6">
            <div class="flex items-start gap-6">
                {{-- Photo --}}
                <div class="shrink-0">
                    @if($user->photo)
                        <img src="{{ asset('storage/'.$user->photo) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover border-2 border-gray-200">
                    @else
                        <div class="w-24 h-24 rounded-full bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-2xl border-2 border-gray-200">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                {{-- Info Grid --}}
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</p>
                        <p class="text-sm text-gray-800 mt-0.5 font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</p>
                        <p class="text-sm text-gray-800 mt-0.5">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</p>
                        <p class="text-sm text-gray-800 mt-0.5">{{ $user->gender === 'male' ? 'Male' : ($user->gender === 'female' ? 'Female' : '-') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</p>
                        <p class="text-sm text-gray-800 mt-0.5">{{ $user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Institution</p>
                        <p class="text-sm text-gray-800 mt-0.5">{{ $user->institution ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Country</p>
                        <p class="text-sm text-gray-800 mt-0.5">{{ $user->country ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Research Interest</p>
                        <p class="text-sm text-gray-800 mt-0.5">{{ $user->research_interest ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Other Information</p>
                        <p class="text-sm text-gray-800 mt-0.5">{{ $user->other_info ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Signature --}}
            @if($user->signature)
            <div class="mt-6 pt-4 border-t">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Signature</p>
                <img src="{{ asset('storage/'.$user->signature) }}" alt="Signature" class="max-h-24 border rounded bg-gray-50 p-2">
            </div>
            @endif

            <div class="mt-4 pt-4 border-t">
                <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 text-sm text-teal-600 hover:text-teal-800 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    {{-- Payment Status --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="font-semibold text-gray-800">Payment Status</h2>
        </div>
        <div class="p-6">
            @if($payment)
            <div class="flex items-center gap-4">
                <div class="shrink-0">
                    @if($payment->status === 'verified')
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                    @elseif($payment->status === 'uploaded')
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    @elseif($payment->status === 'rejected')
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">
                        @if($payment->status === 'verified') Payment Verified
                        @elseif($payment->status === 'uploaded') Awaiting Verification
                        @elseif($payment->status === 'rejected') Payment Rejected
                        @else Proof Not Yet Uploaded @endif
                    </p>
                    <div class="text-sm text-gray-500 mt-0.5 space-y-0.5">
                        <p>Invoice: <span class="font-mono">{{ $payment->invoice_number }}</span></p>
                        @if($payment->registrationPackage)
                            <p>
                                Paket: <strong class="text-teal-600">{{ $payment->registrationPackage->name }}</strong>
                            </p>
                        @endif
                        <p>Amount: <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong></p>
                        @if($payment->payment_method)
                            <p>Method: {{ $payment->payment_method }}</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('participant.payment') }}" class="text-sm text-teal-600 hover:text-teal-800 font-medium">View Details →</a>
            </div>
            @else
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">No payment data yet</p>
                    <p class="text-sm text-gray-500 mt-0.5">Please upload your payment proof.</p>
                </div>
                <a href="{{ route('participant.payment') }}" class="text-sm text-teal-600 hover:text-teal-800 font-medium">Upload →</a>
            </div>
            @endif
        </div>
    </div>

    {{-- Conference Info --}}
    @if($conference)
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="font-semibold text-gray-800">Event Information</h2>
        </div>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800">{{ $conference->name }}</h3>
            @if($conference->theme)
                <p class="text-sm text-gray-500 mt-1">{{ $conference->theme }}</p>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 text-sm">
                @if($conference->start_date)
                <div class="flex items-center gap-2 text-gray-600">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $conference->date_range }}
                </div>
                @endif
                <div class="flex items-center gap-2 text-gray-600">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $conference->venue_display ?? '-' }}
                </div>
                @if($conference->organizer)
                <div class="flex items-center gap-2 text-gray-600">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    {{ $conference->organizer }}
                </div>
                @endif
            </div>

            {{-- Important Dates --}}
            @php $dates = $conference->importantDates()->orderBy('date')->get(); @endphp
            @if($dates->count())
            <div class="mt-5 pt-4 border-t">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Important Dates</h4>
                <div class="space-y-2">
                    @foreach($dates as $d)
                    <div class="flex items-center gap-3 text-sm {{ $d->is_past ? 'text-gray-400' : 'text-gray-700' }}">
                        <span class="w-2 h-2 rounded-full {{ $d->is_past ? 'bg-gray-300' : 'bg-teal-500' }} shrink-0"></span>
                        <span class="font-medium w-24 shrink-0">{{ $d->date->format('d M Y') }}</span>
                        <span class="{{ $d->is_past ? 'line-through' : '' }}">{{ $d->title }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Registration Date --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="font-semibold text-gray-800">Account Information</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Registration Date</p>
                    <p class="text-gray-800 mt-0.5">{{ $user->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Role</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-700 mt-0.5">Participant</span>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Account Status</p>
                    @if($payment && $payment->status === 'verified')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 mt-0.5">Active</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 mt-0.5">Awaiting Verification</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
