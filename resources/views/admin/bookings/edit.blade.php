<x-admin-layout>
    <x-slot name="header">
        Edit Pemesanan #{{ $booking->id }}
    </x-slot>

    <div class="space-y-8">
        <!-- Form Utama (Update Detail Pesanan) -->
        <div class="p-6 bg-white rounded-lg shadow-lg border-t-4 border-blue-500">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Detail Pemesanan</h2>
            <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div>
                        <div class="mb-4">
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Pelanggan</label>
                            <select id="user_id" name="user_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id', $booking->user_id) == $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="vehicle_id" class="block text-sm font-medium text-gray-700">Mobil</label>
                            <select id="vehicle_id" name="vehicle_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" @selected(old('vehicle_id', $booking->vehicle_id) == $vehicle->id)>
                                        {{ $vehicle->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status Pesanan</label>
                            <select id="status" name="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="pending" @selected(old('status', $booking->status) == 'pending')>Pending</option>
                                <option value="confirmed" @selected(old('status', $booking->status) == 'confirmed')>Confirmed</option>
                                <option value="on_rent" @selected(old('status', $booking->status) == 'on_rent')>On Rent</option>
                                <option value="completed" @selected(old('status', $booking->status) == 'completed')>Completed</option>
                                <option value="cancelled" @selected(old('status', $booking->status) == 'cancelled')>Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div>
                        <div class="mb-4">
                            <label for="pickup_datetime" class="block text-sm font-medium text-gray-700">Waktu
                                Penjemputan</label>
                            <input type="datetime-local" id="pickup_datetime" name="pickup_datetime"
                                value="{{ old('pickup_datetime', $booking->pickup_datetime->format('Y-m-d\TH:i')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="dropoff_datetime" class="block text-sm font-medium text-gray-700">Waktu
                                Pengembalian</label>
                            <input type="datetime-local" id="dropoff_datetime" name="dropoff_datetime"
                                value="{{ old('dropoff_datetime', $booking->dropoff_datetime->format('Y-m-d\TH:i')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan
                                Internal</label>
                            <textarea id="notes" name="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes', $booking->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.bookings.index') }}"
                        class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md mr-2 hover:bg-gray-300">Kembali</a>
                    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>

        <!-- Kartu Aksi Pembatalan & Refund -->
        <div class="p-6 bg-white rounded-lg shadow-lg border-t-4 border-red-500">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Aksi Pembatalan & Refund</h2>
            <p class="text-sm text-gray-600 mb-4">Gunakan form ini untuk membatalkan pesanan dan mencatat pengembalian
                dana. Aksi ini tidak dapat diurungkan.</p>

            <form action="{{ route('admin.bookings.refund', $booking) }}" method="POST"
                onsubmit="return confirm('Anda yakin ingin membatalkan dan melakukan refund untuk pesanan ini?');">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="refund_amount" class="block text-sm font-medium text-gray-700">Jumlah Refund
                            (Rp)</label>
                        <input type="number" name="refund_amount" id="refund_amount"
                            value="{{ old('refund_amount', $booking->grand_total) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>
                    <div>
                        <label for="refund_notes" class="block text-sm font-medium text-gray-700">Catatan Refund
                            (Opsional)</label>
                        <input type="text" name="notes" id="refund_notes"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: Pembatalan H-1">
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">
                        Batalkan & Proses Refund
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-admin-layout>
