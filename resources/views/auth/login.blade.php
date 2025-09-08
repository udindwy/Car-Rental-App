<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-dark-slate">Selamat Datang Kembali</h2>
        <p class="text-neutral-gray mt-1">Silakan masuk untuk melanjutkan pesanan Anda.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full text-center justify-center">
                Masuk
            </x-primary-button>
        </div>
    </form>

    {{-- Link ke Halaman Register --}}
    <div class="mt-6 text-center text-sm text-gray-600">
        <p>
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:underline">
                Daftar sekarang
            </a>
        </p>
    </div>
</x-guest-layout>
