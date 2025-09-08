<x-public-layout>
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl md:text-4xl font-bold text-center text-dark-slate mb-8">Checkout Pesanan</h1>

        {{-- Tambahkan x-data dan @submit.prevent --}}
        <form x-data="checkoutForm" @submit.prevent="submit" enctype="multipart/form-data">
            @csrf
            {{-- Hidden inputs untuk membawa data pesanan --}}
            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
            <input type="hidden" name="pickup_datetime" value="{{ $pickupDate }}">
            <input type="hidden" name="dropoff_datetime" value="{{ $dropoffDate }}">
            @foreach ($extraIds as $extraId)
                <input type="hidden" name="extras[]" value="{{ $extraId }}">
            @endforeach
            <input type="hidden" name="grand_total" value="{{ $priceDetails['total_price'] }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

                {{-- KOLOM KIRI: FORM DATA PELANGGAN --}}
                <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow-md space-y-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-dark-slate">Data Penyewa</h2>
                        <p class="text-sm text-neutral-gray mt-1">Pastikan data sesuai dengan KTP/SIM Anda.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ auth()->user()?->name }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700">Alamat Email</label>
                            <input type="email" id="email" name="email" value="{{ auth()->user()?->email }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                        </div>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" placeholder="Contoh: 08123456789"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                    </div>

                    {{-- Upload Dokumen --}}
                    <div class="border-t pt-6 space-y-4">
                        <div>
                            <label for="ktp" class="block text-sm font-medium text-slate-700">Upload Foto
                                KTP</label>
                            <input type="file" id="ktp" name="ktp"
                                class="mt-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                required>
                            <p class="text-xs text-neutral-gray mt-1">Format: JPG, PNG. Max: 2MB.</p>
                        </div>
                        <div>
                            <label for="sim" class="block text-sm font-medium text-slate-700">Upload Foto SIM
                                A</label>
                            <input type="file" id="sim" name="sim"
                                class="mt-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                required>
                            <p class="text-xs text-neutral-gray mt-1">Format: JPG, PNG. Max: 2MB.</p>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: RINGKASAN PESANAN --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 bg-white p-6 rounded-xl shadow-lg">
                        <h3 class="text-xl font-bold text-dark-slate border-b pb-4">Ringkasan Pesanan</h3>


                        {{-- Info Mobil --}}
                        <div class="flex items-center space-x-4">
                            <img src="{{ $vehicle->images->first() ? Storage::url($vehicle->images->first()->path) : asset('images/default-vehicle.jpg') }}"
                                class="w-24 h-16 object-cover rounded-lg shadow">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $vehicle->name }}</p>
                                <p class="text-sm text-gray-500">{{ $vehicle->brand->name }}</p>
                            </div>
                        </div>

                        {{-- Detail Biaya --}}
                        <div class="border-t pt-4 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Sewa Mobil ({{ $priceDetails['duration'] }} hari)</span>
                                <span class="font-medium">Rp
                                    {{ number_format($priceDetails['subtotal'], 0, ',', '.') }}</span>
                            </div>
                            @if ($priceDetails['extras_cost'] > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Layanan Tambahan</span>
                                    <span class="font-medium">Rp
                                        {{ number_format($priceDetails['extras_cost'], 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Total --}}
                        <div class="border-t pt-4 flex justify-between items-center">
                            <span class="text-lg font-bold text-slate-800">Total Biaya</span>
                            <span class="text-xl font-extrabold text-blue-600">Rp
                                {{ number_format($priceDetails['total_price'], 0, ',', '.') }}</span>
                        </div>


                        <button type="submit" x-text="buttonLabel" :disabled="isLoading"
                            class="mt-6 w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-bold py-3 px-4 rounded-lg transition">
                            Lanjutkan ke Pembayaran
                        </button>

                        <div x-show="errorMessage"
                            class="mt-4 text-center p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                            <p x-text="errorMessage"></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ▼▼▼ TAMBAHKAN BLOK SCRIPT INI ▼▼▼ --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('checkoutForm', () => ({
                isLoading: false,
                buttonLabel: 'Lanjutkan ke Pembayaran',
                errorMessage: '',

                submit(event) {
                    this.isLoading = true;
                    this.buttonLabel = 'Memproses...';
                    this.errorMessage = '';

                    const form = event.target;
                    const formData = new FormData(form);

                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                // Jika validasi gagal atau ada error server
                                return response.json().then(data => Promise.reject(data));
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.snap_token) {
                                // Buka pop-up pembayaran Midtrans
                                snap.pay(data.snap_token, {
                                    onSuccess: function(result) {
                                        alert("Pembayaran berhasil!");
                                        window.location.href =
                                            '/'; // Arahkan ke halaman lain
                                    },
                                    onPending: function(result) {
                                        alert("Menunggu pembayaran Anda!");
                                        window.location.href = '/';
                                    },
                                    onError: function(result) {
                                        alert("Pembayaran gagal!");
                                        this.resetButton();
                                    },
                                    onClose: function() {
                                            alert(
                                                'Anda menutup pop-up tanpa menyelesaikan pembayaran'
                                                );
                                            this.resetButton();
                                        }.bind(
                                            this
                                            ) // bind 'this' agar bisa panggil resetButton
                                });
                            } else {
                                this.errorMessage = 'Gagal mendapatkan token pembayaran.';
                                this.resetButton();
                            }
                        })
                        .catch(error => {
                            this.errorMessage = error.message ||
                                'Terjadi kesalahan. Cek kembali isian Anda.';
                            if (error.errors) {
                                // Tampilkan error validasi pertama
                                this.errorMessage = Object.values(error.errors)[0][0];
                            }
                            this.resetButton();
                        });
                },

                resetButton() {
                    this.isLoading = false;
                    this.buttonLabel = 'Lanjutkan ke Pembayaran';
                }
            }));
        });
    </script>
</x-public-layout>
