<x-admin-layout>
    <x-slot name="header">
        Tambah Kupon Baru
    </x-slot>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Kode Kupon</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipe Diskon</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <option value="percent">Persentase (%)</option>
                        <option value="flat">Potongan Tetap (Flat)</option>
                    </select>
                </div>
                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700">Nilai</label>
                    <input type="number" name="value" id="value" value="{{ old('value') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="min_total" class="block text-sm font-medium text-gray-700">Minimal Transaksi (Rp)</label>
                    <input type="number" name="min_total" id="min_total" value="{{ old('min_total') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="max_usage" class="block text-sm font-medium text-gray-700">Batas Penggunaan</label>
                    <input type="number" name="max_usage" id="max_usage" value="{{ old('max_usage') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                 <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.coupons.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md mr-2 hover:bg-gray-300">Batal</a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Simpan Kupon</button>
            </div>
        </form>
    </div>
</x-admin-layout>