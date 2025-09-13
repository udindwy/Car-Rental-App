<x-admin-layout>
    <x-slot name="header">
        Manajemen Armada
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Mobil</h2>
            @can('create', \App\Models\Vehicle::class)
                <a href="{{ route('admin.vehicles.create') }}"
                    class="inline-flex items-center bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Mobil
                </a>
            @endcan
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            Mobil</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Harga/Hari</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($vehicles as $vehicle)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $vehicle->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $vehicle->brand->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Rp {{ number_format($vehicle->base_price_day) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if ($vehicle->status == 'Tersedia') bg-green-100 text-green-800
                                    @elseif($vehicle->status == 'Disewa') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $vehicle->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-2">

                                    {{-- Form untuk update status --}}
                                    @can('updateStatus', $vehicle)
                                        <form action="{{ route('admin.vehicles.updateStatus', $vehicle) }}" method="POST">
                                            @csrf
                                            <select name="status"
                                                class="text-xs font-medium rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 
                                                @if ($vehicle->status == 'Tersedia') bg-green-100 text-green-800 border-green-300 
                                                @elseif($vehicle->status == 'Disewa') bg-yellow-100 text-yellow-800 border-yellow-300 
                                                @else bg-gray-100 text-gray-800 border-gray-300 @endif"
                                                onchange="this.form.submit()">
                                                <option value="Tersedia" @if ($vehicle->status == 'Tersedia') selected @endif>
                                                    Tersedia</option>
                                                <option value="Disewa" @if ($vehicle->status == 'Disewa') selected @endif>
                                                    Disewa</option>
                                                <option value="Dalam Perawatan"
                                                    @if ($vehicle->status == 'Dalam Perawatan') selected @endif>Dalam Perawatan
                                                </option>
                                            </select>
                                        </form>
                                    @endcan

                                    {{-- Tombol Edit (Hanya Admin) --}}
                                    @can('update', $vehicle)
                                        <a href="{{ route('admin.vehicles.edit', $vehicle) }}"
                                            class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                                            Edit
                                        </a>
                                    @endcan

                                    {{-- Tombol Kalender (Admin & Staff) --}}
                                    @can('viewAny', \App\Models\Availability::class)
                                        <a href="{{ route('admin.vehicles.availability', $vehicle) }}"
                                            class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 transition">
                                            Kalender
                                        </a>
                                    @endcan

                                    {{-- Tombol Hapus (Hanya Admin) --}}
                                    @can('delete', $vehicle)
                                        <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST"
                                            class="inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-red-500 hover:bg-red-600 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada data mobil ditemukan.
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
