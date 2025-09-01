<x-admin-layout>
<x-slot name="header">
Tambah Cabang Baru
</x-slot>

<div class="bg-white rounded-lg shadow-lg p-6">
    <form action="{{ route('admin.branches.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Cabang</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">Kota</label>
                <input type="text" name="city" id="city" value="{{ old('city') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('address') }}</textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.branches.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md mr-2 hover:bg-gray-300">Batal</a>
            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>

</x-admin-layout>