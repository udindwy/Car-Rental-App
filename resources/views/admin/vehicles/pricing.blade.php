<x-admin-layout>
    <x-slot name="header">
        Aturan Harga untuk: {{ $vehicle->name }}
    </x-slot>

    <div class="space-y-6">
        <!-- Daftar Aturan yang Sudah Ada -->
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Aturan Harga</h2>
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Detail</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penyesuaian</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($rules as $rule)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ ucfirst(str_replace('_', ' ', $rule->type)) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if ($rule->type == 'long_rent')
                                        Min. {{ $rule->min_days }} hari
                                    @elseif($rule->type == 'date_range')
                                        {{ \Carbon\Carbon::parse($rule->start_date)->format('d M Y') }} -
                                        {{ \Carbon\Carbon::parse($rule->end_date)->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm {{ $rule->percent_adjustment > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $rule->percent_adjustment > 0 ? '+' : '' }}{{ $rule->percent_adjustment }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('admin.pricing-rules.destroy', $rule) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus aturan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <!-- PERUBAHAN DI SINI: Tombol Hapus dibuat lebih rapi -->
                                        <button type="submit"
                                            class="bg-red-500 text-white text-xs font-semibold py-1 px-3 rounded-md hover:bg-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada aturan
                                    harga khusus.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form Tambah Aturan Baru -->
        <div class="p-6 bg-white rounded-lg shadow-lg" x-data="{ type: 'long_rent' }">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Aturan Baru</h2>
            <form action="{{ route('admin.vehicles.storePricing', $vehicle) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Tipe Aturan -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipe Aturan</label>
                        <select x-model="type" name="type" id="type"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="long_rent">Diskon Jangka Panjang</option>
                            <option value="date_range">Harga Musiman (Per Tanggal)</option>
                            <option value="weekend">Harga Akhir Pekan</option>
                        </select>
                    </div>

                    <!-- Input Dinamis -->
                    <div class="col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div x-show="type === 'long_rent'" x-cloak>
                            <label for="min_days" class="block text-sm font-medium text-gray-700">Minimal Hari
                                Sewa</label>
                            <input type="number" name="min_days" id="min_days"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: 7">
                        </div>
                        <div x-show="type === 'date_range'" x-cloak class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal
                                    Mulai</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal
                                    Selesai</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                        <div>
                            <label for="percent_adjustment" class="block text-sm font-medium text-gray-700">Penyesuaian
                                Harga (%)</label>
                            <input type="number" step="0.01" name="percent_adjustment" id="percent_adjustment"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="Contoh: -10 atau 15" required>
                            <p class="text-xs text-gray-500 mt-1">Gunakan nilai negatif untuk diskon (misal: -10).</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.vehicles.index') }}"
                        class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md mr-2 hover:bg-gray-300">Batal</a>
                    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Simpan
                        Aturan</button>
                </div>
            </form>
        </div>
    </div>

</x-admin-layout>
