<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-t">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 text-slate-800">

    {{-- Navbar --}}
    <nav x-data="{ open: false }" class="bg-white/90 backdrop-blur shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-2xl font-extrabold text-blue-600 tracking-tight">
                        {{ config('app.name', 'CarRental') }}
                    </a>
                </div>

                {{-- Menu Desktop (Tersembunyi di mobile) --}}
                <div class="hidden md:flex md:items-center md:space-x-8">
                    {{-- PERUBAHAN DI SINI --}}
                    <a href="{{ route('home') }}"
                        class="font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Home
                    </a>
                    <a href="{{ route('catalog') }}"
                        class="font-medium transition-colors duration-200 {{ request()->routeIs('catalog') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Katalog
                    </a>
                    <a href="#"
                        class="font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                        Tentang Kami
                    </a>
                </div>

                {{-- Tombol Login/Dasbor (Desktop) --}}
                <div class="hidden md:flex md:items-center">
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Dasbor
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Login
                        </a>
                    @endauth
                </div>

                {{-- Tombol Hamburger (Hanya muncul di mobile) --}}
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg x-show="!open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        <svg x-show="open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        {{-- Menu Mobile (Muncul saat tombol hamburger diklik) --}}
        <div x-show="open" @click.away="open = false" class="md:hidden" id="mobile-menu" style="display: none;">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                {{-- PERUBAHAN DI SINI --}}
                <a href="{{ route('home') }}"
                    class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('home') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    Home
                </a>
                <a href="{{ route('catalog') }}"
                    class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('catalog') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    Katalog
                </a>
                <a href="#" class="block text-gray-700 hover:bg-gray-50 font-medium px-3 py-2 rounded-md">
                    Tentang Kami
                </a>
            </div>
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="px-2">
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="block w-full text-left bg-blue-600 text-white py-2 px-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Dasbor
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full text-left bg-blue-600 text-white py-2 px-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Konten --}}
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    @include('layouts.partials.public-footer')

    @stack('scripts')
</body>

</html>
