@extends('layouts.central')

@section('title', 'Login — Central Admin')

@section('content')
<div class="max-w-sm mx-auto bg-white rounded-xl shadow p-8 mt-16">
    <h1 class="text-xl font-semibold text-gray-800 mb-6">Central Admin Login</h1>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3 mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/admin/login">
        @csrf
        <label class="block text-sm font-medium text-gray-700 mb-1.5" for="password">Password</label>
        <input type="password" name="password" id="password" autofocus
            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">

        <button type="submit"
            class="w-full mt-5 bg-indigo-600 text-white py-2.5 rounded-lg font-semibold hover:bg-indigo-700 transition">
            Masuk
        </button>
    </form>
</div>
@endsection
