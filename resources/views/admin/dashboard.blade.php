<x-admin-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    {{-- Kartu Selamat Datang --}}
    <div class="mb-8 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-white shadow-lg"
        data-aos="fade-down">
        <h2 class="text-3xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="mt-2 text-blue-200">Ini adalah ringkasan performa rental mobil Anda.</p>
    </div>

    {{-- Grid untuk Kartu KPI (Key Performance Indicators) --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

        {{-- KPI: Total Pendapatan (Hanya untuk Admin) --}}
        @can('viewRevenue', \App\Models\User::class)
            <div class="flex items-center rounded-2xl bg-white p-6 shadow-lg transition-transform duration-300 hover:-translate-y-1"
                data-aos="fade-up">
                <div
                    class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600">
                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-6">
                    <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalRevenue) }}</p>
                </div>
            </div>
        @endcan

        {{-- KPI: Total Pemesanan --}}
        <div class="flex items-center rounded-2xl bg-white p-6 shadow-lg transition-transform duration-300 hover:-translate-y-1"
            data-aos="fade-up" data-aos-delay="100">
            <div
                class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-1.125 0-2.25.9-2.25 2.25v11.25c0 1.243 1.009 2.25 2.25 2.25H18a2.25 2.25 0 002.25-2.25V16.5" />
                </svg>
            </div>
            <div class="ml-6">
                <p class="text-sm font-medium text-gray-500">Total Pemesanan</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalBookings }}</p>
            </div>
        </div>

        {{-- KPI: Tingkat Okupansi --}}
        <div class="flex items-center rounded-2xl bg-white p-6 shadow-lg transition-transform duration-300 hover:-translate-y-1"
            data-aos="fade-up" data-aos-delay="200">
            <div
                class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 003.375-3.375h1.5a1.125 1.125 0 011.125 1.125v-1.5c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 003.375 3.375v1.875a2.25 2.25 0 01-2.25 2.25H5.625a2.25 2.25 0 01-2.25-2.25z" />
                </svg>
            </div>
            <div class="ml-6">
                <p class="text-sm font-medium text-gray-500">Tingkat Okupansi</p>
                <p class="text-3xl font-bold text-gray-800">{{ number_format($occupancyRate, 1) }}%</p>
            </div>
        </div>

        {{-- KPI: Pesanan Hari Ini --}}
        <div class="flex items-center rounded-2xl bg-white p-6 shadow-lg transition-transform duration-300 hover:-translate-y-1"
            data-aos="fade-up" data-aos-delay="300">
            <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M12 15.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <div class="ml-6">
                <p class="text-sm font-medium text-gray-500">Pesanan Hari Ini</p>
                <p class="text-3xl font-bold text-gray-800">{{ $todayBookings }}</p>
            </div>
        </div>
    </div>

    <!-- Grafik dan Aktivitas Terbaru -->
    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-lg lg:col-span-2" data-aos="fade-up">
            <h3 class="mb-4 text-lg font-semibold text-gray-700">Pemesanan 7 Hari Terakhir</h3>
            <canvas id="bookingsChart"></canvas>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-lg" data-aos="fade-up" data-aos-delay="100">
            <h3 class="mb-4 text-lg font-semibold text-gray-700">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                @forelse ($activities as $activity)
                    <div class="flex items-start space-x-4 last:border-b-0 border-b border-gray-100 pb-4">
                        <div class="flex-shrink-0">
                            @if ($activity instanceof \App\Models\Booking)
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-1.125 0-2.25.9-2.25 2.25v11.25c0 1.243 1.009 2.25 2.25 2.25H18a2.25 2.25 0 002.25-2.25V16.5" />
                                    </svg>
                                </div>
                            @elseif ($activity instanceof \App\Models\Vehicle)
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-green-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 003.375-3.375h1.5a1.125 1.125 0 011.125 1.125v-1.5c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 003.375 3.375v1.875a2.25 2.25 0 01-2.25 2.25H5.625a2.25 2.25 0 01-2.25-2.25z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">
                                @if ($activity instanceof \App\Models\Booking)
                                    Booking Baru: {{ $activity->vehicle?->name ?? 'N/A' }} oleh
                                    {{ $activity->user?->name ?? 'N/A' }}
                                @elseif ($activity instanceof \App\Models\Vehicle)
                                    Mobil Baru Ditambahkan: {{ $activity->name }}
                                @endif
                            </p>
                            <p class="text-sm text-gray-500" title="{{ $activity->created_at->format('d M Y H:i:s') }}">
                                {{ $activity->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada aktivitas terbaru.</p>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('bookingsChart');
                if (ctx) {
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($chartLabels),
                            datasets: [{
                                label: 'Jumlah Pemesanan',
                                data: @json($chartData),
                                fill: true,
                                borderColor: 'rgb(59, 130, 246)',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.4,
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
            });
        </script>
    @endpush

</x-admin-layout>
