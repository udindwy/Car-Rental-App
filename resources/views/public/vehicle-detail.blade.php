<x-public-layout>
    {{-- Pembungkus utama untuk AlpineJS agar data bisa dibagi antara kalkulator desktop dan mobile bar --}}
    <div x-data="priceCalculator('{{ route('api.vehicles.calculate-price', $vehicle) }}')">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

                {{-- KOLOM KIRI: GALERI, SPESIFIKASI, ULASAN --}}
                <div class="lg:col-span-2 space-y-8">

                    <div data-aos="fade-up">
                        <img src="{{ $vehicle->images->first() ? Storage::url($vehicle->images->first()->path) : 'https://via.placeholder.com/800x500' }}"
                            alt="{{ $vehicle->name }}" class="w-full h-auto object-cover rounded-xl shadow-lg">
                    </div>

                    <div data-aos="fade-up" data-aos-delay="100">
                        <p class="text-neutral-gray font-semibold">{{ $vehicle->brand->name }}</p>
                        <h1 class="text-3xl md:text-4xl font-bold text-dark-slate">{{ $vehicle->name }}</h1>

                        {{-- Tampilkan rating rata-rata --}}
                        <div class="flex items-center mt-2">
                            <div class="flex items-center text-amber-500">
                                @for ($i = 0; $i < 5; $i++)
                                    <i
                                        class="lucide-star text-sm {{ $i < floor($vehicle->average_rating ?? 0) ? 'fill-current' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <span class="ml-2 text-neutral-gray">{{ $vehicle->average_rating ?? 0 }}
                                ({{ $vehicle->reviews->count() }} ulasan)</span>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="text-2xl font-semibold text-dark-slate mb-4">Spesifikasi & Fitur</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-2 text-neutral-gray">
                            <div class="flex items-center space-x-2"><i class="lucide-users text-blue-600"></i>
                                <span>{{ $vehicle->seats }} Kursi</span>
                            </div>
                            <div class="flex items-center space-x-2"><i
                                    class="lucide-sliders-horizontal text-blue-600"></i>
                                <span>{{ $vehicle->transmission }}</span>
                            </div>
                            <div class="flex items-center space-x-2"><i class="lucide-fuel text-blue-600"></i>
                                <span>{{ ucfirst($vehicle->fuel) }}</span>
                            </div>
                            <div class="flex items-center space-x-2"><i class="lucide-briefcase text-blue-600"></i>
                                <span>{{ $vehicle->luggage ?? 0 }} Bagasi</span>
                            </div>
                            @foreach ($vehicle->features as $feature)
                                <div class="flex items-center space-x-2"><i
                                        class="lucide-check-circle-2 text-blue-600"></i>
                                    <span>{{ $feature->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="text-2xl font-semibold text-dark-slate mb-4">Deskripsi</h2>
                        <p class="text-neutral-gray prose max-w-full">
                            {{ $vehicle->description ?? 'Tidak ada deskripsi.' }}</p>
                    </div>

                    <div id="ulasan" class="bg-white p-6 rounded-xl shadow-md" data-aos="fade-up"
                        data-aos-delay="400">
                        <h2 class="text-2xl font-semibold text-dark-slate mb-4">Ulasan Pelanggan</h2>
                        <div class="space-y-6">
                            @forelse($vehicle->reviews->where('approved', true) as $review)
                                <x-review-card :review="$review" />
                            @empty
                                <p class="text-neutral-gray">Belum ada ulasan untuk mobil ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: KALKULATOR HARGA (Hanya tampil di Desktop) --}}
                <div class="lg:col-span-1 hidden lg:block">
                    <div class="sticky top-24 bg-white p-6 rounded-xl shadow-lg border border-gray-100"
                        data-aos="zoom-in">
                        <div class="mb-4">
                            <span class="text-neutral-gray">Mulai dari</span>
                            <p>
                                <span class="text-3xl font-extrabold text-dark-slate">Rp
                                    {{ number_format($vehicle->base_price_day, 0, ',', '.') }}</span>
                                <span class="text-neutral-gray">/hari</span>
                            </p>
                        </div>

                        <div class="space-y-4 border-t pt-4">
                            <h3 class="text-lg font-semibold text-dark-slate">Cek Ketersediaan & Harga</h3>
                            <div>
                                <label for="pickup_date" class="block text-sm font-medium text-neutral-gray">Tanggal &
                                    Jam Ambil</label>
                                <input type="datetime-local" id="pickup_date" x-model="pickupDate"
                                    @change="calculatePrice"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="dropoff_date" class="block text-sm font-medium text-neutral-gray">Tanggal &
                                    Jam Kembali</label>
                                <input type="datetime-local" id="dropoff_date" x-model="dropoffDate"
                                    @change="calculatePrice"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        @if ($vehicle->extras->count() > 0)
                            <div class="space-y-3 border-t pt-4 mt-4">
                                <h3 class="text-lg font-semibold text-dark-slate">Layanan Tambahan</h3>
                                @foreach ($vehicle->extras as $extra)
                                    <label for="extra-{{ $extra->id }}"
                                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                                        <div>
                                            <span class="font-semibold text-dark-slate">{{ $extra->name }}</span>
                                            <p class="text-sm text-neutral-gray">
                                                Rp {{ number_format($extra->price, 0, ',', '.') }} /
                                                {{ $extra->price_type == 'per_hari' ? 'hari' : 'sewa' }}
                                            </p>
                                        </div>
                                        <input type="checkbox" id="extra-{{ $extra->id }}" x-model="selectedExtras"
                                            @change="calculatePrice" value="{{ $extra->id }}"
                                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        <div x-show="isLoading" class="mt-6 text-center">
                            <p class="text-neutral-gray animate-pulse">Menghitung...</p>
                        </div>

                        <div x-show="summary.total_price && !isLoading" x-transition
                            class="mt-6 border-t pt-4 space-y-2">
                            <h4 class="font-semibold text-dark-slate">Ringkasan Biaya</h4>
                            <div class="flex justify-between">
                                <span class="text-neutral-gray">Sewa Mobil (<span
                                        x-text="`${summary.duration} hari`"></span>)</span>
                                <span class="font-semibold"
                                    x-text="`Rp ${summary.subtotal.toLocaleString('id-ID')}`"></span>
                            </div>
                            <div x-show="summary.extras_cost > 0" class="flex justify-between">
                                <span class="text-neutral-gray">Layanan Tambahan</span>
                                <span class="font-semibold"
                                    x-text="`Rp ${summary.extras_cost.toLocaleString('id-ID')}`"></span>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-dark-slate pt-2 border-t mt-2">
                                <span>Total Biaya</span>
                                <span x-text="`Rp ${summary.total_price.toLocaleString('id-ID')}`"></span>
                            </div>
                        </div>

                        <div x-show="error" x-transition
                            class="mt-4 text-center p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                            <p x-text="error"></p>
                        </div>

                        <div class="mt-6">
                            <a x-bind:href="'{{ route('checkout.show') }}?' + new URLSearchParams({
                                vehicle_id: {{ $vehicle->id }},
                                pickup_datetime: pickupDate,
                                dropoff_datetime: dropoffDate,
                                'extras[]': selectedExtras
                            }).toString()"
                                x-show="summary.total_price && !isLoading" x-transition
                                class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg">
                                Lanjutkan Pemesanan
                            </a>
                            <div x-show="!summary.total_price && !isLoading" x-transition
                                class="w-full text-center py-3 px-4 rounded-lg bg-gray-100 text-gray-500 font-medium">
                                Pilih tanggal untuk melanjutkan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MOBILE CTA BAR (Sticky di bawah, hanya muncul jika harga sudah terhitung) --}}
        <div x-show="summary.total_price && !isLoading" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="transform translate-y-full" x-transition:enter-end="transform translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="transform translate-y-0"
            x-transition:leave-end="transform translate-y-full"
            class="fixed bottom-0 left-0 w-full bg-white p-4 border-t border-gray-200 shadow-lg lg:hidden">
            <div class="container mx-auto flex justify-between items-center">
                <div>
                    <p class="text-sm text-neutral-gray">Total Biaya</p>
                    <p class="font-bold text-xl text-dark-slate"
                        x-text="`Rp ${summary.total_price.toLocaleString('id-ID')}`"></p>
                </div>
                <a x-bind:href="'{{ route('checkout.show') }}?' + new URLSearchParams({
                    vehicle_id: {{ $vehicle->id }},
                    pickup_datetime: pickupDate,
                    dropoff_datetime: dropoffDate,
                    'extras[]': selectedExtras
                }).toString()"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                    Pesan
                </a>
            </div>
        </div>
    </div>

    {{-- SCRIPT UTAMA UNTUK HALAMAN INI --}}
    <script>
        function priceCalculator(apiUrl) {
            return {
                pickupDate: '',
                dropoffDate: '',
                selectedExtras: [],
                summary: {},
                isLoading: false,
                error: '',
                calculatePrice() {
                    if (!this.pickupDate || !this.dropoffDate) return;

                    this.isLoading = true;
                    this.summary = {};
                    this.error = '';

                    fetch(apiUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                pickup_date: this.pickupDate,
                                dropoff_date: this.dropoffDate,
                                extras: this.selectedExtras
                            })
                        })
                        .then(response => {
                            if (!response.ok) return response.json().then(data => Promise.reject(data));
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                this.summary = data;
                            } else if (data.error) {
                                this.error = data.error;
                            }
                        })
                        .catch(err => {
                            this.error = err.error || 'Terjadi kesalahan. Silakan coba lagi.';
                        })
                        .finally(() => {
                            this.isLoading = false;
                        });
                }
            }
        }
    </script>
</x-public-layout>
