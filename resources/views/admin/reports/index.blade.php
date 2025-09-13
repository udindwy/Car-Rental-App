<x-admin-layout>
    <x-slot name="header">
        Pusat Laporan
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Unduh Laporan</h2>
        <p class="text-gray-600 mb-6">Pilih jenis laporan yang ingin Anda unduh dalam format CSV.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Kartu Laporan Pemesanan (Terlihat oleh Staf & Admin) --}}
            @can('exportBookings', \App\Models\Report::class)
                <div
                    class="border border-gray-200 rounded-lg p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-1.125 0-2.25.9-2.25 2.25v11.25c0 1.243 1.009 2.25 2.25 2.25H18a2.25 2.25 0 002.25-2.25V16.5" />
                            </svg>
                        </div>
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
            @endcan

            {{-- Kartu Laporan Pendapatan (HANYA TERLIHAT OLEH ADMIN) --}}
            @can('exportRevenue', \App\Models\Report::class)
                <div
                    class="border border-gray-200 rounded-lg p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
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
            @endcan

            {{-- Kartu Laporan Okupansi (Terlihat oleh Staf & Admin) --}}
            @can('exportOccupancy', \App\Models\Report::class)
                <div
                    class="border border-gray-200 rounded-lg p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div>
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 text-purple-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h15.75c.621 0 1.125.504 1.125 1.125v6.75c0 .621-.504 1.125-1.125 1.125H4.125c-.621 0-1.125-.504-1.125-1.125v-6.75zM4.125 12A2.25 2.25 0 001.875 9.75v-3.75c0-.621.504-1.125 1.125-1.125h15.75c.621 0 1.125.504 1.125 1.125v3.75A2.25 2.25 0 0019.875 12h-15.75z" />
                            </svg>
                        </div>
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
            @endcan

            {{-- Kartu Laporan Pemakaian Kupon (Terlihat oleh Staf & Admin) --}}
            @can('exportCouponUsage', \App\Models\Report::class)
                <div
                    class="border border-gray-200 rounded-lg p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-100 text-teal-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                            </svg>
                        </div>
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
            @endcan

        </div>
    </div>

</x-admin-layout>
