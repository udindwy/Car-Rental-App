<x-admin-layout>
    <x-slot name="header">
        Manajemen Armada
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Mobil</h2>
            <a href="{{ route('admin.vehicles.create') }}"
                class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                + Tambah Mobil
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Mobil</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga/Hari</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($vehicles as $vehicle)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $vehicle->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $vehicle->brand->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp
                                {{ number_format($vehicle->base_price_day) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vehicle->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($vehicle->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <!-- Tombol Ketersediaan -->
                                    <a href="{{ route('admin.vehicles.availability', $vehicle) }}"
                                        class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-orange-500 hover:bg-orange-600 transition">
                                        Ketersediaan
                                    </a>

                                    <!-- Tombol Harga -->
                                    <a href="{{ route('admin.vehicles.pricing', $vehicle) }}"
                                        class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-green-500 hover:bg-green-600 transition">
                                        Atur Harga
                                    </a>

                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.vehicles.edit', $vehicle) }}"
                                        class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                                        Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST"
                                        class="inline-flex"
                                        onsubmit="return confirm('Yakin ingin menghapus mobil ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-red-500 hover:bg-red-600 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <!-- Tombol Ketersediaan -->
                                    <a href="{{ route('admin.vehicles.availability', $vehicle) }}"
                                        class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-orange-500 hover:bg-orange-600 transition">
                                        Ketersediaanh
                                    </a>

                                    <!-- Tombol Harga -->
                                    <a href="{{ route('admin.vehicles.pricing', $vehicle) }}"
                                        class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-green-500 hover:bg-green-600 transition">
                                        Atur Harga
                                    </a>

                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.vehicles.edit', $vehicle) }}"
                                        class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                                        Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST"
                                        class="inline-flex"
                                        onsubmit="return confirm('Yakin ingin menghapus mobil ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-red-500 hover:bg-red-600 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $vehicles->links() }}
        </div>
    </div>

</x-admin-layout>
