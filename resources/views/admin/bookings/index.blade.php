<x-admin-layout>
    <x-slot name="header">
        Manajemen Pemesanan
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Pemesanan</h2>
        </div>

        <!-- Panel Filter Baru -->
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="mb-6" x-data
            @submit.prevent="$el.submit()">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <!-- Pencarian Real-time -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700">Cari</label>
                    <input type="text" name="search" id="search" placeholder="ID, Pelanggan, Mobil..."
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ request('search') }}"
                        x-on:input.debounce.500ms="$el.form.submit()">
                </div>

                <!-- Filter Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        x-on:change="$el.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                        <option value="confirmed" @selected(request('status') == 'confirmed')>Confirmed</option>
                        <option value="on_rent" @selected(request('status') == 'on_rent')>On Rent</option>
                        <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                        <option value="cancelled" @selected(request('status') == 'cancelled')>Cancelled</option>
                    </select>
                </div>

                <!-- Filter Tanggal -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Sewa</label>
                    <input type="date" name="start_date" id="start_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        value="{{ request('start_date') }}" x-on:change="$el.form.submit()">
                </div>

                <!-- Tombol Refresh -->
                <div class="flex items-center">
                    <a href="{{ route('admin.bookings.index') }}"
                        class="w-full text-center bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                        Refresh
                    </a>

                </div>
            </div>
        </form>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobil
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Sewa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $booking->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->vehicle->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->pickup_datetime->format('d M Y') }} -
                                {{ $booking->dropoff_datetime->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp
                                {{ number_format($booking->grand_total) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                        'on_rent' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-gray-100 text-gray-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$booking->status] ?? '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.bookings.invoice', $booking) }}" target="_blank"
                                        class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-green-600 hover:bg-green-700 transition">Invoice</a>
                                    <a href="{{ route('admin.bookings.edit', $booking) }}"
                                        class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition">Edit
                                        / Detail</a>
                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-red-600 hover:bg-red-700 transition">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada data pemesanan yang cocok dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    </div>

</x-admin-layout>
