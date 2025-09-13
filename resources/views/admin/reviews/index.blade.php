<x-admin-layout>
    <x-slot name="header">
        Manajemen Ulasan
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Ulasan Pelanggan</h2>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mobil</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Komentar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($reviews as $review)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $review->user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $review->vehicle->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-500">
                                <div class="flex items-center">
                                    @for ($i = 0; $i < $review->rating; $i++)
                                        <span>&#9733;</span> <!-- Bintang Penuh -->
                                    @endfor
                                    @for ($i = $review->rating; $i < 5; $i++)
                                        <span>&#9734;</span> <!-- Bintang Kosong -->
                                    @endfor
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                {{ $review->comment ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $review->approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $review->approved ? 'Disetujui' : 'Pending' }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center justify-end space-x-2">

                                {{-- ▼▼▼ HAK AKSES DITAMBAHKAN DI SINI ▼▼▼ --}}
                                @can('update', $review)
                                    <form action="{{ route('admin.reviews.update', $review) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="px-3 py-1 rounded-md text-sm font-medium 
                                            {{ $review->approved ? 'bg-yellow-500 text-white hover:bg-yellow-600' : 'bg-green-600 text-white hover:bg-green-700' }}">
                                            {{ $review->approved ? 'Batal Setujui' : 'Setujui' }}
                                        </button>
                                    </form>
                                @endcan

                                {{-- ▼▼▼ HAK AKSES DITAMBAHKAN DI SINI ▼▼▼ --}}
                                @can('delete', $review)
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Yakin ingin menghapus ulasan ini secara permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 rounded-md text-sm font-medium bg-red-600 text-white hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada ulasan dari
                                pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    </div>
</x-admin-layout>
