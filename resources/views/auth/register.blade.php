<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">

<head>
    <meta charset="utf-t">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased">
    <main class="flex min-h-full items-center justify-center p-4 sm:p-6 lg:p-8">
        {{-- Komponen utama diatur oleh AlpineJS, dimulai dengan isLogin: false --}}
        <div x-data="{ isLogin: false }"
            class="relative w-full max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden md:grid md:grid-cols-2">

            {{-- PANEL BIRU ANIMASI --}}
            <div class="absolute top-0 left-0 h-full w-full md:w-1/2 bg-blue-600 transition-transform duration-700 ease-in-out z-20"
                :class="{ 'md:translate-x-full': isLogin, 'md:translate-x-0': !isLogin }">

                <div class="flex flex-col items-center justify-center h-full text-center text-white p-12">
                    {{-- Konten untuk sisi Registrasi --}}
                    <div x-show="isLogin" x-transition:enter="transition ease-out duration-300 delay-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="w-full">
                        <h2 class="text-3xl font-bold">Hello, Welcome!</h2>
                        <p class="mt-4">Belum punya akun? Daftar sekarang untuk memulai.</p>
                        <button @click="isLogin = false"
                            class="mt-8 px-6 py-2 font-semibold text-blue-600 bg-white rounded-full hover:bg-slate-100 transition">
                            Register
                        </button>
                    </div>

                    {{-- Konten untuk sisi Login --}}
                    <div x-show="!isLogin" x-transition:enter="transition ease-out duration-300 delay-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="w-full">
                        <h2 class="text-3xl font-bold">Welcome Back!</h2>
                        <p class="mt-4">Sudah punya akun? Login untuk melanjutkan.</p>
                        <button @click="isLogin = true"
                            class="mt-8 px-6 py-2 font-semibold text-blue-600 bg-white rounded-full hover:bg-slate-100 transition">
                            Login
                        </button>
                    </div>
                </div>
            </div>

            {{-- WADAH UNTUK KEDUA FORM --}}
            <div class="relative grid grid-cols-1 md:grid-cols-2 col-span-2">

                {{-- FORM LOGIN --}}
                <div class="p-8 sm:p-12">
                    <h2 class="text-3xl font-bold text-slate-900">Login</h2>
                    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="sr-only">Email</label>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                value="{{ old('email') }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Email">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="text-right text-sm">
                            <a href="{{ route('password.request') }}"
                                class="font-medium text-blue-600 hover:text-blue-500">
                                Lupa password?
                            </a>
                        </div>
                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Login
                            </button>
