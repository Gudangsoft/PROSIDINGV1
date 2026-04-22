@extends('layouts.guest')

@section('title', 'Verify Email - ' . \App\Models\Setting::getValue('site_name', config('app.name')))

@section('content')
<div class="bg-white shadow-2xl p-8 sm:p-12 max-w-lg mx-auto" style="border-radius: 16px;">
    <div class="flex justify-center mb-6">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
    </div>

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Verifikasi Email Anda</h2>
    
    <div class="text-sm text-gray-600 mb-6 text-center leading-relaxed">
        Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda. Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan ulang.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-medium text-sm text-green-700 bg-green-50 border border-green-200 p-4 rounded-lg text-center">
            Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat registrasi.
        </div>
    @endif

    <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4 w-full">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all shadow-md text-sm">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full sm:w-auto text-sm text-gray-600 hover:text-gray-900 underline flex justify-center py-2">
                Log Out
            </button>
        </form>
    </div>
</div>
@endsection
