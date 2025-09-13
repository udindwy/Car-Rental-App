<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gradient-to-br from-blue-50 to-indigo-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased">
    <main class="flex min-h-full items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-md space-y-8">

            {{-- Kartu Form --}}
            <div class="bg-white p-8 sm:p-12 rounded-2xl shadow-xl">

                {{-- Header dengan Ikon dan Judul --}}
                <div class="text-center">
                    <div class="inline-block rounded-full bg-blue-100 p-4">
                        <svg class="h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m21.75 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m21.75 0V6.75M4.5 19.5l7.5-7.5 7.5 7.5" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-3xl font-extrabold text-slate-900">
                        Lupa Password Anda?
                    </h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Tidak masalah. Masukkan email Anda dan kami akan mengirimkan link untuk mengatur ulang password.
                    </p>
                </div>

                <div class="mt-6">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                </div>

                <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                value="{{ old('email') }}" autofocus
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 ease-in-out">
                            Kirim Link Reset Password
                        </button>
                    </div>
                </form>

            </div>

            {{-- Tombol Kembali ke Login --}}
            <p class="mt-8 text-center text-sm text-gray-600">
                Ingat password Anda?
                <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:underline">
                    Kembali ke Login
                </a>
            </p>
        </div>
    </main>
</body>

</html>
