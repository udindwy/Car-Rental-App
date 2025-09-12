<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-800">
    
    <div class="relative min-h-screen">
        {{-- Latar Belakang Abstrak --}}
        <div class="absolute top-0 left-0 w-full h-full -z-10 overflow-hidden">
            <div class="absolute top-0 -left-1/4 w-96 h-96 md:w-[500px] md:h-[500px] bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-pulse"></div>
            <div class="absolute bottom-0 -right-1/4 w-96 h-96 md:w-[500px] md:h-[500px] bg-amber-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-pulse" style="animation-delay: 2s;"></div>
        </div>
        
        {{-- Panggil Navbar --}}
        @include('layouts.partials.public-navbar')

        {{-- Spacer agar konten tidak tertutup navbar --}}
        <div class="h-20"></div>

        {{-- Konten Utama --}}
        <main>
            {{ $slot }}
        </main>

        {{-- Panggil Footer --}}
        @include('layouts.partials.public-footer')
    </div>

    @stack('scripts')
</body>
</html>