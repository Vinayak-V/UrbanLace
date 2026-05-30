<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'UrbanLace') }} @yield('title')</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js (included in Breeze/Vite usually, but ensure it's loaded) -->
    </head>
    <body class="font-sans antialiased bg-brand-offwhite text-brand-black flex flex-col min-h-screen">
        <x-header />

        <!-- Page Content -->
        <main class="flex-grow pt-20"> <!-- pt-20 accounts for fixed header -->
            {{ $slot }}
        </main>
        
        <x-footer />
    </body>
</html>
