<x-admin-layout>
    <x-slot name="header">
        Pusat Laporan
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Unduh Laporan</h2>
        <p class="text-gray-600 mb-6">Pilih jenis laporan yang ingin Anda unduh dalam format CSV.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Kartu Laporan Pemesanan -->
            <div class="border border-gray-200 rounded-lg p-4 flex flex-col justify-between">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800">Laporan Pemesanan</h3>
                    <p class="text-sm text-gray-500 mt-1">Unduh semua data detail dari setiap pemesanan yang pernah ada.
                    </p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.reports.export.bookings') }}"
                        class="w-full text-center bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 block">
                        Unduh Laporan
                    </a>
                </div>
            </div>

            <!-- Kartu Laporan Pendapatan -->
            <div class="border border-gray-200 rounded-lg p-4 flex flex-col justify-between">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800">Laporan Pendapatan</h3>
                    <p class="text-sm text-gray-500 mt-1">Unduh log semua transaksi keuangan (pemasukan & refund).</p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.reports.export.revenue') }}"
                        class="w-full text-center bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition duration-300 block">
                        Unduh Laporan
                    </a>
                </div>
            </div>

            <!-- Kartu Laporan Okupansi (Placeholder) -->
            <div class="border border-gray-200 rounded-lg p-4 flex flex-col justify-between">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800">Laporan Okupansi</h3>
                    <p class="text-sm text-gray-500 mt-1">Analisis tingkat penggunaan setiap mobil selama 30 hari
                        terakhir.</p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.reports.export.occupancy') }}"
                        class="w-full text-center bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 transition duration-300 block">
                        Unduh Laporan
                    </a>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-4 flex flex-col justify-between">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800">Laporan Pemakaian Kupon</h3>
                    <p class="text-sm text-gray-500 mt-1">Analisis performa dan total diskon dari setiap kupon yang
                        pernah digunakan.</p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.reports.export.coupon_usage') }}"
                        class="w-full text-center bg-teal-600 text-white py-2 px-4 rounded-md hover:bg-teal-700 transition duration-300 block">
                        Unduh Laporan
                    </a>
                </div>
            </div>

        </div>
    </div>

</x-admin-layout>
