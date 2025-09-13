<x-admin-layout>
    <x-slot name="header">
        Manajemen Fitur
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Fitur Mobil</h2>
            @can('create', \App\Models\Feature::class)
                <a href="{{ route('admin.features.create') }}"
                    class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    + Tambah Fitur
                </a>
            @endcan
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
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            Fitur</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($features as $feature)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $feature->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    @can('update', $feature)
                                        <a href="{{ route('admin.features.edit', $feature) }}"
                                            class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                                            Edit
                                        </a>
                                    @endcan
                                    @can('delete', $feature)
                                        <form action="{{ route('admin.features.destroy', $feature) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus fitur ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-red-600 hover:bg-red-700 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data fitur.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $features->links() }}
        </div>
    </div>

</x-admin-layout>
