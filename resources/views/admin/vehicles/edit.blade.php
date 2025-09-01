<x-admin-layout>
<x-slot name="header">
Edit Mobil: {{ $vehicle->name }}
</x-slot>

<form action="{{ route('admin.vehicles.update', $vehicle) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-6 space-y-6">
    @csrf
    @method('PUT')
    
    {{-- Formnya sama persis dengan create.blade.php, hanya saja valuenya diisi dari $vehicle --}}
    {{-- Contoh untuk input Nama Mobil --}}
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Mobil</label>
        <input type="text" name="name" id="name" value="{{ old('name', $vehicle->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    {{-- Contoh untuk select Brand --}}
    <div>
        <label for="brand_id" class="block text-sm font-medium text-gray-700">Brand</label>
        <select name="brand_id" id="brand_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" @selected(old('brand_id', $vehicle->brand_id) == $brand->id)>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>
    </div>
    
    {{-- Contoh untuk checkbox Fitur --}}
    @php
        $vehicleFeatures = old('features', $vehicle->features->pluck('id')->toArray());
    @endphp
    <div>
        <label class="block text-lg font-medium text-gray-900">Fitur</label>
        <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($features as $feature)
            <div class="flex items-center">
                <input type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature-{{ $feature->id }}" @checked(in_array($feature->id, $vehicleFeatures)) class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="feature-{{ $feature->id }}" class="ml-2 text-sm text-gray-700">{{ $feature->name }}</label>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Tampilkan Gambar yang Sudah Ada --}}
    <div class="mt-6">
        <h3 class="text-lg font-medium text-gray-900">Gambar Saat Ini</h3>
        <div class="mt-2 grid grid-cols-3 md:grid-cols-5 gap-4">
            @foreach($vehicle->images as $image)
                <div class="relative">
                    <img src="{{ Storage::url($image->path) }}" alt="Image" class="h-32 w-full object-cover rounded-md">
                    {{-- Fitur hapus gambar bisa ditambahkan di sini --}}
                </div>
            @endforeach
        </div>
    </div>

    {{-- Upload Gambar Baru --}}
    <div>
        <label for="images" class="block text-lg font-medium text-gray-900">Tambah Gambar Baru</label>
        <input type="file" name="images[]" id="images" multiple class="mt-2 block w-full text-sm ...">
    </div>
    
    {{-- Salin sisa form dari create.blade.php dan sesuaikan value-nya --}}
    
    <div class="flex justify-end pt-4">
        <a href="{{ route('admin.vehicles.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md mr-2 hover:bg-gray-300">Batal</a>
        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Simpan Perubahan</button>
    </div>
</form>

</x-admin-layout>