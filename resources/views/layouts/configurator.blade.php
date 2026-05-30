<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>UrbanLace Configurator</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Pickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/>
    </head>
    <body class="font-sans antialiased bg-[#f5f5f5] text-brand-black overflow-hidden h-screen flex flex-col">
        <!-- Minimal Header -->
        <header class="w-full h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-50 flex-shrink-0">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center text-gray-500 hover:text-brand-black mr-6 border-r border-gray-200 pr-6">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back
                </a>
                <span class="font-display font-black text-xl tracking-tighter italic">URBANLACE<span class="text-green-500">.</span> STUDIO</span>
            </div>
            <div class="font-bold text-lg">
                @yield('price_display')
            </div>
        </header>

        <!-- Configurator Workspace -->
        <main class="flex-grow flex relative overflow-hidden">
            {{ $slot }}
        </main>
    </body>
</html>
