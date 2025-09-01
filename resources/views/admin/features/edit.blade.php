<x-admin-layout>
<x-slot name="header">
Edit Fitur
</x-slot>

<div class="bg-white rounded-lg shadow-lg p-6">
    <form action="{{ route('admin.features.update', $feature) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Fitur</label>
            <div class="mt-1">
                <input type="text" name="name" id="name" value="{{ old('name', $feature->name) }}"
                       class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                       placeholder="Contoh: AC, Bluetooth, GPS" required>
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.features.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md mr-2 hover:bg-gray-300">Batal</a>
            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Simpan Perubahan</button>
        </div>
    </form>
</div>

</x-admin-layout>