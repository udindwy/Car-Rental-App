<x-admin-layout>
    <x-slot name="header">
        Edit Pemesanan #{{ $booking->id }}
    </x-slot>

    <div class="space-y-6">
        <!-- Form Utama untuk Edit Booking -->
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Pemesanan</h2>
            <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Pelanggan -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Pelanggan</label>
                        <select name="user_id" id="user_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected(old('user_id', $booking->user_id) == $user->id)>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                    </div>

                    <!-- Kolom Mobil -->
                    <div>
                        <label for="vehicle_id" class="block text-sm font-medium text-gray-700">Mobil</label>
                        <select name="vehicle_id" id="vehicle_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" @selected(old('vehicle_id', $booking->vehicle_id) == $vehicle->id)>
                                    {{ $vehicle->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('vehicle_id')" class="mt-2" />
                    </div>

                    <!-- Kolom Waktu Ambil -->
                    <div>
                        <label for="pickup_datetime" class="block text-sm font-medium text-gray-700">Waktu Ambil</label>
                        <input type="datetime-local" name="pickup_datetime" id="pickup_datetime"
                            value="{{ old('pickup_datetime', $booking->pickup_datetime->format('Y-m-d\TH:i')) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <x-input-error :messages="$errors->get('pickup_datetime')" class="mt-2" />
                    </div>

                    <!-- Kolom Waktu Kembali -->
                    <div>
                        <label for="dropoff_datetime" class="block text-sm font-medium text-gray-700">Waktu
                            Kembali</label>
                        <input type="datetime-local" name="dropoff_datetime" id="dropoff_datetime"
                            value="{{ old('dropoff_datetime', $booking->dropoff_datetime->format('Y-m-d\TH:i')) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <x-input-error :messages="$errors->get('dropoff_datetime')" class="mt-2" />
                    </div>

                    <!-- Kolom Status Pesanan -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status Pesanan</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="pending" @selected($booking->status == 'pending')>Pending</option>
                            <option value="confirmed" @selected($booking->status == 'confirmed')>Confirmed</option>
                            <option value="on_rent" @selected($booking->status == 'on_rent')>On Rent</option>
                            <option value="completed" @selected($booking->status == 'completed')>Completed</option>
                            <option value="cancelled" @selected($booking->status == 'cancelled')>Cancelled</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <!-- Kolom Catatan -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes', $booking->notes) }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.bookings.index') }}"
                        class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md mr-2 hover:bg-gray-300">Batal</a>
                    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>

        <!-- Form untuk Aksi Refund/Pembatalan -->
        <div class="p-6 bg-white rounded-lg shadow-lg border-t-4 border-red-500">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Aksi Pembatalan & Refund</h2>
            <p class="text-sm text-gray-600 mb-4">Gunakan form ini untuk membatalkan pesanan dan mencatat pengembalian
                dana. Aksi ini tidak dapat diurungkan.</p>

            <form action="{{ route('admin.bookings.refund', $booking) }}" method="POST"
                onsubmit="return confirm('Anda yakin ingin membatalkan dan melakukan refund untuk pesanan ini?');">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="refund_amount" class="block text-sm font-medium text-gray-700">Jumlah Refund
                            (Rp)</label>
                        <input type="number" name="refund_amount" id="refund_amount"
                            value="{{ old('refund_amount', $booking->grand_total) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <x-input-error :messages="$errors->get('refund_amount')" class="mt-2" />
                    </div>
                    <div>
                        <label for="refund_method" class="block text-sm font-medium text-gray-700">Metode
                            Pembayaran</label>
                        <select name="refund_method" id="refund_method"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                            <option value="gateway">Gateway</option>
                        </select>
                        <x-input-error :messages="$errors->get('refund_method')" class="mt-2" />
                    </div>
                    <div>
                        <label for="refund_notes" class="block text-sm font-medium text-gray-700">Catatan Refund
                            (Opsional)</label>
                        <input type="text" name="notes" id="refund_notes"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Contoh: Pembatalan H-1">
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
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
