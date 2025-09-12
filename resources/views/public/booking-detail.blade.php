<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Detail Pesanan #{{ $booking->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 md:p-8">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {{-- KOLOM KIRI: DETAIL BOOKING & BIAYA --}}
                        <div class="md:col-span-2 space-y-6">
                            {{-- Status --}}
                            <div class="flex items-center space-x-4">
                                <div>
                                    <span class="text-sm text-slate-500">Status Booking</span>
                                    <p>
                                        {{-- Kode @class[...] Anda asumsikan sudah benar --}}
                                        <span @class(['status-class-placeholder'])> {{ Str::ucfirst($booking->status) }} </span>
                                    </p>
                                </div>
                                <div>
                                    <span class="text-sm text-slate-500">Status Pembayaran</span>
                                    <p>
                                        {{-- [FIXED] Menggunakan null coalescing operator untuk keamanan --}}
                                        <span @class(['status-class-placeholder'])>
                                            {{ Str::ucfirst($booking->payment->status ?? 'Belum Dibayar') }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            {{-- Jadwal & Lokasi --}}
                            <div class="border-t pt-4">
                                <h3 class="font-semibold text-slate-800">Jadwal & Lokasi</h3>
                                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-slate-500">Waktu Ambil</p>
                                        <p class="font-medium text-slate-700">
                                            {{ $booking->pickup_datetime->format('d M Y, H:i') }}</p>
                                        {{-- [FIXED] Menggunakan null safe operator (?->) untuk keamanan --}}
                                        <p class="text-xs text-slate-500">{{ $booking->pickupBranch?->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-500">Waktu Kembali</p>
                                        <p class="font-medium text-slate-700">
                                            {{ $booking->dropoff_datetime->format('d M Y, H:i') }}</p>
                                        {{-- [FIXED] Menggunakan null safe operator (?->) untuk keamanan --}}
                                        <p class="text-xs text-slate-500">{{ $booking->dropoffBranch?->name }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Rincian Biaya --}}
                            <div class="border-t pt-4">
                                <h3 class="font-semibold text-slate-800">Rincian Biaya</h3>
                                <div class="mt-2 space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Sewa Mobil ({{ $booking->duration_days }}
                                            hari)</span>
                                        <span class="font-medium text-slate-700">Rp
                                            {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    @if ($booking->extras->isNotEmpty())
                                        <div class="flex justify-between">
                                            <span class="text-slate-500">Layanan Tambahan</span>
                                            <span class="font-medium text-slate-700">Rp
                                                {{ number_format($booking->extras_total, 0, ',', '.') }}</span>
                                        </div>
                                        <ul class="pl-4 text-xs">
                                            @foreach ($booking->extras as $extra)
                                                <li class="text-slate-500">- {{ $extra->name }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <div class="flex justify-between font-bold text-slate-900 text-base pt-2 border-t">
                                        <span>Total Pembayaran</span>
                                        <span>Rp {{ number_format($booking->grand_total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: DETAIL MOBIL --}}
                        <div class="md:col-span-1 space-y-4">
                            <img src="{{ $booking->vehicle->images->first() ? Storage::url($booking->vehicle->images->first()->path) : 'https://via.placeholder.com/400' }}"
                                alt="{{ $booking->vehicle->name }}"
                                class="w-full h-auto object-cover rounded-lg shadow">
                            <div>
                                {{-- [FIXED] Menggunakan null safe operator (?->) untuk keamanan --}}
                                <p class="text-sm text-slate-500">{{ $booking->vehicle->brand?->name }}</p>
                                <h3 class="text-lg font-bold text-slate-800">{{ $booking->vehicle->name }}</h3>
                            </div>
                            <a href="{{ route('dashboard') }}"
                                class="w-full text-center block bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2 px-4 rounded-lg">
                                Kembali ke Riwayat
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
