<x-admin-layout>
    <x-slot name="header">
        Import Jadwal Blokir dari CSV
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('import_errors'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Ditemukan beberapa error pada file Anda:</p>
                <ul>
                    @foreach (session('import_errors') as $failure)
                        <li>Baris {{ $failure->row() }}: {{ implode(', ', $failure->errors()) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <h3 class="font-semibold text-gray-800">Format File CSV</h3>
            <p class="text-sm text-gray-600">
                Pastikan file CSV Anda memiliki header kolom:
                <code>id_mobil</code>, <code>waktu_mulai</code>, <code>waktu_selesai</code>, <code>alasan</code>.
            </p>
            <p class="text-sm text-gray-600">
                Format tanggal harus <strong>DD-MM-YYYY HH:MM</strong> (Contoh: 31-12-2025 23:59).
            </p>
        </div>

        <form action="{{ route('admin.blackouts.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700">Pilih File CSV</label>
                <input type="file" name="file" id="file"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    required>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    Import Data
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
