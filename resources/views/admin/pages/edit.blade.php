<x-admin-layout>
    <x-slot name="header">
        Edit Halaman: {{ $page->title }}
    </x-slot>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('admin.pages.update', $page) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Judul Halaman -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Halaman</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Konten Halaman -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Konten</label>
                    <textarea name="content" id="content" rows="10"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('content', $page->content) }}</textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <!-- Status Publikasi -->
                <div>
                    <label for="published" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="published" id="published"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="1" @selected(old('published', $page->published) == 1)>Published (Tampilkan di Website)</option>
                        <option value="0" @selected(old('published', $page->published) == 0)>Draft (Simpan sebagai Draf)</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.pages.index') }}"
                    class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md mr-2 hover:bg-gray-300">Batal</a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Simpan
                    Perubahan</button>
            </div>
        </form>
    </div>

</x-admin-layout>
