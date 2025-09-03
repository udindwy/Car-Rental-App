<x-admin-layout>
    <x-slot name="header">
        Ketersediaan untuk: {{ $vehicle->name }}
    </x-slot>

    <div class="space-y-6">
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Daftar Tanggal Tidak Tersedia</h2>
                <div class="flex items-center space-x-2 mt-4 sm:mt-0">
                    <a href="{{ route('admin.blackouts.import.show') }}"
                        class="bg-blue-500 text-white py-2 px-4 rounded-md text-sm hover:bg-blue-600">
                        Import CSV
                    </a>
                    <a href="{{ route('admin.blackouts.export') }}"
                        class="bg-green-600 text-white py-2 px-4 rounded-md text-sm hover:bg-green-700">
                        Export CSV
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mulai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Selesai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alasan</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($blackouts as $blackout)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $blackout->start_datetime->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $blackout->end_datetime->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $blackout->reason ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('admin.blackouts.destroy', $blackout) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white text-xs font-semibold py-1 px-3 rounded-md hover:bg-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Mobil ini selalu
                                    tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Blokir Tanggal Baru</h2>
            <form action="{{ route('admin.vehicles.blackouts.store', $vehicle) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_datetime" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                        <input type="datetime-local" name="start_datetime" id="start_datetime"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label for="end_datetime" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                        <input type="datetime-local" name="end_datetime" id="end_datetime"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div class="md:col-span-2">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Alasan (Contoh: Perawatan
                            Rutin)</label>
                        <input type="text" name="reason" id="reason"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.vehicles.index') }}"
                        class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md mr-2 hover:bg-gray-300">Batal</a>
                    <button type="submit"
                        class="bg-orange-600 text-white py-2 px-4 rounded-md hover:bg-orange-700">Blokir Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>