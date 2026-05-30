<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UrbanLace Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f5f5f5] text-brand-black">
    <!-- Admin Header -->
    <header class="bg-brand-black text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('admin.dashboard') }}" class="font-display font-black text-xl tracking-tighter italic">
                        URBANLACE<span class="text-green-400">.</span> ADMIN
                    </a>
                    <nav class="hidden md:flex space-x-6">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold uppercase tracking-wider text-white/80 hover:text-white transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-white' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.orders') }}" class="text-sm font-bold uppercase tracking-wider text-white/80 hover:text-white transition-colors {{ request()->routeIs('admin.orders') ? 'text-white' : '' }}">Orders</a>
                    </nav>
                </div>
                <a href="{{ route('home') }}" class="text-sm text-white/60 hover:text-white transition-colors">← Back to Site</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 text-sm font-medium px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
        @endif

        {{ $slot }}
    </main>
</body>
</html>
