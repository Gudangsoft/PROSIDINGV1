<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Prosiding SaaS — Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between">
        <span class="font-semibold">Prosiding SaaS — Central Admin</span>
        @if(session('central_admin_authenticated'))
            <form method="POST" action="/admin/logout">
                @csrf
                <button type="submit" class="text-sm text-gray-300 hover:text-white">Logout</button>
            </form>
        @endif
    </nav>
    <main class="max-w-5xl mx-auto px-6 py-8">
        @yield('content')
        {{ $slot ?? '' }}
    </main>
    @livewireScripts
</body>
</html>
