<x-admin-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="mb-6 rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 p-6 text-white shadow-lg">
        <h2 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="mt-1 text-blue-100">Ini adalah ringkasan performa rental mobil Anda.</p>
    </div>

        <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="flex items-center rounded-lg bg-white p-4 shadow-md">
                <div class="rounded-full bg-blue-100 p-3 text-blue-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="flex items-center rounded-lg bg-white p-4 shadow-md">
                <div class="rounded-full bg-green-100 p-3 text-green-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-1.125 0-2.25.9-2.25 2.25v11.25c0 1.243 1.009 2.25 2.25 2.25H18a2.25 2.25 0 002.25-2.25V16.5" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Pemesanan</p>
                    <p class="text-xl font-bold text-gray-800">{{ $totalBookings }}</p>
                </div>
            </div>
            <div class="flex items-center rounded-lg bg-white p-4 shadow-md">
                <div class="rounded-full bg-amber-100 p-3 text-amber-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 003.375-3.375h1.5a1.125 1.125 0 011.125 1.125v-1.5c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 003.375 3.375v1.875a2.25 2.25 0 01-2.25 2.25H5.625a2.25 2.25 0 01-2.25-2.25z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Tingkat Okupansi</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($occupancyRate, 1) }}%</p>
                </div>
            </div>
            <div class="flex items-center rounded-lg bg-white p-4 shadow-md">
                <div class="rounded-full bg-red-100 p-3 text-red-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M12 15.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Pesanan Hari Ini</p>
                    <p class="text-xl font-bold text-gray-800">{{ $todayBookings }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-lg bg-white p-6 shadow-md">
                <h3 class="mb-4 text-lg font-semibold text-gray-700">Pemesanan 7 Hari Terakhir</h3>
                <canvas id="bookingsChart"></canvas>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-md">
                <h3 class="mb-4 text-lg font-semibold text-gray-700">Aktivitas Terbaru</h3>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="ml-4">
                            <p class="font-medium text-gray-800">Booking Baru: Avanza oleh Budi</p>
                            <p class="text-sm text-gray-500">Dibuat pada 02 Sep 2025</p>
                        </div>
                    </div>
                    <div class="flex items-center border-t pt-4">
                        <div class="ml-4">
                            <p class="font-medium text-gray-800">Mobil Baru Ditambahkan: Innova Reborn</p>
                            <p class="text-sm text-gray-500">Dibuat pada 01 Sep 2025</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                const ctx = document.getElementById('bookingsChart');
                if (ctx) {
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($chartLabels),
                            datasets: [{
                                label: 'Jumlah Pemesanan',
                                data: @json($chartData),
                                fill: false,
                                borderColor: '#10b981',
                                tension: 0.1,
                                backgroundColor: '#10b981',
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                }
            </script>
        @endpush
</x-admin-layout>