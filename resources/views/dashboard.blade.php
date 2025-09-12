<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Riwayat Pesanan Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 md:p-8">

                    {{-- Konten Tabel --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        ID Pesanan
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Mobil
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Total Harga
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Status Booking
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Status Pembayaran
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse ($bookings as $booking)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                            #{{ $booking->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                            {{ $booking->vehicle->brand->name }} {{ $booking->vehicle->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                            Rp {{ number_format($booking->grand_total, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span @class([
                                                'px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                'bg-green-100 text-green-800' => $booking->status == 'confirmed',
                                                'bg-yellow-100 text-yellow-800' => $booking->status == 'pending',
                                                'bg-red-100 text-red-800' => $booking->status == 'cancelled',
                                                'bg-blue-100 text-blue-800' => $booking->status == 'completed',
                                                'bg-indigo-100 text-indigo-800' => $booking->status == 'on_rent',
                                            ])>
                                                {{ Str::ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($booking->payment)
                                                <span @class([
                                                    'px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                    'bg-green-100 text-green-800' => $booking->payment->status == 'paid',
                                                    'bg-yellow-100 text-yellow-800' => $booking->payment->status == 'unpaid',
                                                    'bg-red-100 text-red-800' => $booking->payment->status == 'failed',
                                                ])>
                                                    {{ Str::ucfirst($booking->payment->status) }}
                                                </span>
                                            @else
                                                <span
                                                    class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800">
                                                    N/A
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                            {{-- ▼▼▼ LOGIKA KONDISIONAL UNTUK TOMBOL AKSI ▼▼▼ --}}
                                            @if ($booking->status === 'completed' && !$booking->review)
                                                {{-- Jika booking 'completed' DAN belum ada review, tampilkan tombol "Tulis Ulasan" --}}
                                                <a href="{{ route('review.create', $booking->id) }}"
                                                    class="inline-block px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                                    Tulis Ulasan
                                                </a>
                                            @else
                                                {{-- Untuk kasus lainnya, tampilkan tombol "Lihat Detail" --}}
                                                <a href="{{ route('booking.show', $booking->id) }}"
                                                    class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                                    Lihat Detail
                                                </a>
                                            @endif
                                            {{-- ▲▲▲ AKHIR LOGIKA KONDISIONAL ▲▲▲ --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-500">
                                            Anda belum memiliki riwayat pesanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginasi --}}
                    @if ($bookings->hasPages())
                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
