<x-admin-layout>
<x-slot name="header">
Tambah Mobil Baru
</x-slot>

<form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-6 space-y-6">
    @csrf
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nama Mobil -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Mobil</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Cabang -->
        <div>
            <label for="branch_id" class="block text-sm font-medium text-gray-700">Cabang</label>
            <select name="branch_id" id="branch_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
        </div>
        
        <!-- Brand -->
        <div>
            <label for="brand_id" class="block text-sm font-medium text-gray-700">Brand</label>
            <select name="brand_id" id="brand_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('brand_id')" class="mt-2" />
        </div>

        <!-- Kategori -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                 @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>
        
        <!-- Harga per Hari -->
        <div>
            <label for="base_price_day" class="block text-sm font-medium text-gray-700">Harga per Hari (Rp)</label>
            <input type="number" name="base_price_day" id="base_price_day" value="{{ old('base_price_day') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            <x-input-error :messages="$errors->get('base_price_day')" class="mt-2" />
        </div>

        <!-- Status -->
         <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="maintenance">Maintenance</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
    </div>

    <hr>

    <h3 class="text-lg font-medium text-gray-900">Spesifikasi Detail</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Transmisi, Bahan Bakar, Kursi, Pintu, dll. -->
        <div>
            <label for="transmission" class="block text-sm font-medium text-gray-700">Transmisi</label>
            <select name="transmission" id="transmission" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                <option value="AT">Automatic</option>
                <option value="MT">Manual</option>
            </select>
        </div>
         <div>
            <label for="fuel" class="block text-sm font-medium text-gray-700">Bahan Bakar</label>
            <select name="fuel" id="fuel" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                <option value="bensin">Bensin</option>
                <option value="diesel">Diesel</option>
                <option value="hybrid">Hybrid</option>
                <option value="ev">Listrik</option>
            </select>
        </div>
         <div>
            <label for="seats" class="block text-sm font-medium text-gray-700">Kursi</label>
            <input type="number" name="seats" id="seats" value="{{ old('seats') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <!-- ...tambahkan input untuk doors, luggage, year, plate_number ... -->
    </div>

    <!-- Deskripsi -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea>
    </div>
    
    <hr>
    
    <!-- Fitur -->
    <div>
        <label class="block text-lg font-medium text-gray-900">Fitur</label>
        <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($features as $feature)
            <div class="flex items-center">
                <input type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature-{{ $feature->id }}" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="feature-{{ $feature->id }}" class="ml-2 text-sm text-gray-700">{{ $feature->name }}</label>
            </div>
            @endforeach
        </div>
    </div>

    <hr>

    <!-- Galeri Foto -->
    <div>
        <label for="images" class="block text-lg font-medium text-gray-900">Galeri Foto</label>
        <input type="file" name="images[]" id="images" multiple class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
    </div>
    
    <!-- Tombol Aksi -->
    <div class="flex justify-end pt-4">
        <a href="{{ route('admin.vehicles.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md mr-2 hover:bg-gray-300">Batal</a>
        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Simpan Mobil</button>
    </div>
</form>

</x-admin-layout>