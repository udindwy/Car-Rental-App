<x-admin-layout>
    <x-slot name="header">
        Edit Layanan
    </x-slot>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('admin.extras.update', $extra) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Layanan -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Layanan</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $extra->name) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        placeholder="Contoh: Supir Profesional" required>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Tipe Tarif -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipe Tarif</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        required>
                        <option value="per_day" {{ old('type', $extra->type) == 'per_day' ? 'selected' : '' }}>Per Hari
                        </option>
                        <option value="per_booking" {{ old('type', $extra->type) == 'per_booking' ? 'selected' : '' }}>
                            Per Pemesanan</option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <!-- Harga -->
                <div class="md:col-span-2">
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $extra->price) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: 150000"
                        required>
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.extras.index') }}"
                    class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md mr-2 hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
