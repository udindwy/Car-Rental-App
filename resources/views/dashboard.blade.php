<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dasbor Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">{{ __('Anda berhasil login!') }}</h3>
                    <p class="mt-2 text-gray-600">
                        Selamat datang di panel pelanggan. Fitur untuk melihat riwayat pemesanan Anda dan mengelola akun
                        akan segera hadir di halaman ini.
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
