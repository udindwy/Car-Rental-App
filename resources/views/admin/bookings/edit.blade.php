<x-admin-layout>
    <x-slot name="header">
        Detail Pemesanan #{{ $booking->id }}
    </x-slot>

    @php
        // Kalkulasi ringkasan pembayaran di sini agar mudah digunakan
        $totalPaid = $booking->payments->where('status', 'paid')->sum('amount');
        $totalRefunded = $booking->payments->where('status', 'refunded')->sum('amount');
        $netPaid = $totalPaid - $totalRefunded;
        $outstanding = $booking->grand_total - $netPaid;
    @endphp

    <div class="space-y-6">
        <!-- Form Utama: Edit Detail Pesanan -->
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Edit Detail Pesanan</h2>
                <span
                    class="px-3 py-1 text-sm font-semibold rounded-full 
                @switch($booking->payment_status)
                    @case('paid') bg-green-100 text-green-800 @break
                    @case('partial') bg-yellow-100 text-yellow-800 @break
                    @default bg-red-100 text-red-800
                @endswitch">
                    Pembayaran: {{ ucfirst($booking->payment_status) }}
                </span>
            </div>

            <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div>
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Pelanggan</label>
                            <select name="user_id" id="user_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected($booking->user_id == $user->id)>{{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="pickup_datetime" class="block text-sm font-medium text-gray-700">Waktu
                                Penjemputan</label>
                            <input type="datetime-local" name="pickup_datetime" id="pickup_datetime"
                                value="{{ old('pickup_datetime', $booking->pickup_datetime->format('Y-m-d\TH:i')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mt-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status Pesanan</o>
                                <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="pending" @selected($booking->status == 'pending')>Pending</option>
                                    <option value="confirmed" @selected($booking->status == 'confirmed')>Confirmed</option>
                                    <option value="on_rent" @selected($booking->status == 'on_rent')>On Rent</option>
                                    <option value="completed" @selected($booking->status == 'completed')>Completed</option>
                                    <option value="cancelled" @selected($booking->status == 'cancelled')>Cancelled</option>
                                </select>
                        </div>
                    </div>
                    <!-- Kolom Kanan -->
                    <div>
                        <div>
                            <label for="vehicle_id" class="block text-sm font-medium text-gray-700">Mobil</label>
                            <select name="vehicle_id" id="vehicle_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" @selected($booking->vehicle_id == $vehicle->id)>
                                        {{ $vehicle->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="dropoff_datetime" class="block text-sm font-medium text-gray-700">Waktu
                                Pengembalian</label>
                            <input type="datetime-local" name="dropoff_datetime" id="dropoff_datetime"
                                value="{{ old('dropoff_datetime', $booking->dropoff_datetime->format('Y-m-d\TH:i')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mt-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan
                                Internal</label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes', $booking->notes) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>

        <!-- Bagian Pembayaran -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Riwayat Pembayaran -->
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Riwayat Pembayaran</h2>
                <div class="space-y-3">
                    @forelse($booking->payments as $payment)
                        <div
                            class="flex justify-between items-center p-3 rounded-md {{ $payment->status == 'refunded' ? 'bg-red-50' : 'bg-green-50' }}">
                            <div>
                                <p
                                    class="font-semibold {{ $payment->status == 'refunded' ? 'text-red-700' : 'text-green-700' }}">
                                    {{ $payment->status == 'refunded' ? 'Refund' : 'Pembayaran Diterima' }}
                                </p>
                                <small class="text-gray-500">{{ ucfirst($payment->method) }} -
                                    {{ $payment->paid_at->format('d M Y, H:i') }}</small>
                            </div>
                            <p
                                class="font-bold {{ $payment->status == 'refunded' ? 'text-red-700' : 'text-green-700' }}">
                                {{ $payment->status == 'refunded' ? '-' : '+' }} Rp
                                {{ number_format($payment->amount) }}
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada riwayat pembayaran.</p>
                    @endforelse
                </div>
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between font-bold">
                        <span>Total Tagihan:</span>
                        <span>Rp {{ number_format($booking->grand_total) }}</span>
                    </div>
                    <div class="flex justify-between text-green-600">
                        <span>Total Terbayar:</span>
                        <span>Rp {{ number_format($netPaid) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-red-600">
                        <span>Sisa Pembayaran:</span>
                        <span>Rp {{ number_format($outstanding) }}</span>
                    </div>
                </div>
            </div>

            <!-- Form Catat Pembayaran Baru -->
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Catat Pembayaran Baru</h2>
                <form action="{{ route('admin.bookings.payments.store', $booking) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="payment_amount" class="block text-sm font-medium text-gray-700">Jumlah Bayar
                                (Rp)</label>
                            <input type="number" name="payment_amount" id="payment_amount"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode
                                Bayar</label>
                            <select name="payment_method" id="payment_method"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                                <option value="gateway">Gateway</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="payment_notes" class="block text-sm font-medium text-gray-700">Catatan
                            (Opsional)</label>
                        <input type="text" name="notes" id="payment_notes"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Contoh: Pembayaran DP">
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">Simpan
                            Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Aksi Pembatalan & Refund -->
        <div class="p-6 bg-white rounded-lg shadow-lg border-t-4 border-red-500">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Aksi Pembatalan & Refund</h2>
            <form action="{{ route('admin.bookings.refund', $booking) }}" method="POST"
                onsubmit="return confirm('Anda yakin ingin membatalkan dan melakukan refund untuk pesanan ini?');">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="refund_amount" class="block text-sm font-medium text-gray-700">Jumlah Refund
                            (Rp)</label>
                        <input type="number" name="refund_amount" id="refund_amount"
                            value="{{ old('refund_amount', $netPaid) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label for="refund_method" class="block text-sm font-medium text-gray-700">Metode
                            Refund</label>
                        <select name="refund_method" id="refund_method"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                    <div>
                        <label for="refund_notes" class="block text-sm font-medium text-gray-700">Catatan
                            Refund</label>
                        <input type="text" name="notes" id="refund_notes"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Contoh: Pembatalan H-1">
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">Batalkan & Proses
                        Refund</button>
                </div>
            </form>
        </div>
    </div>

</x-admin-layout>
