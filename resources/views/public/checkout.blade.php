<x-public-layout>
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl md:text-4xl font-bold text-center text-dark-slate mb-8">Checkout Pesanan</h1>

        <form x-data="checkoutForm" @submit.prevent="submit" enctype="multipart/form-data" id="checkoutForm">
            @csrf

            {{-- Menampilkan error validasi dari server --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6"
                    role="alert">
                    <strong class="font-bold">Oops! Terjadi kesalahan validasi.</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Hidden inputs untuk membawa data pesanan --}}
            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
            <input type="hidden" name="pickup_datetime" value="{{ $pickupDate }}">
            <input type="hidden" name="dropoff_datetime" value="{{ $dropoffDate }}">
            @foreach ($extraIds as $extraId)
                <input type="hidden" name="extras[]" value="{{ $extraId }}">
            @endforeach
            {{-- Nilai grand_total diupdate oleh AlpineJS --}}
            <input type="hidden" name="grand_total" :value="finalTotal">
            {{-- Menyimpan kode kupon yang valid untuk dikirim ke controller --}}
            <input type="hidden" name="coupon_code" x-model="appliedCouponCode">


            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

                {{-- KOLOM KIRI: FORM DATA PELANGGAN & PEMBAYARAN --}}
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
                    {{-- Ganti input telepon Anda dengan ini --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" placeholder="Contoh: 08123456789"
                            {{-- Isi value dari profil user, jika ada --}} value="{{ auth()->user()->phone_number }}" {{-- Jika sudah ada, buat readonly dan beri style abu-abu --}}
                            @if (auth()->user()->phone_number) readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100"
        @else
            {{-- Jika belum ada, beri style normal dan wajib diisi --}}
            required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" @endif>
                    </div>

                    {{-- ====================================================== --}}
                    {{-- ▼▼▼ BLOK UPLOAD DOKUMEN YANG SUDAH DIPERBARUI ▼▼▼ --}}
                    {{-- ====================================================== --}}
                    <div class="border-t pt-6 space-y-6">
                        <h3 class="text-lg font-medium text-slate-700">Dokumen Identitas</h3>

                        @if (auth()->user()->ktp_path && auth()->user()->sim_path)
                            {{-- TAMPILAN JIKA DOKUMEN SUDAH ADA --}}
                            <div x-data="{ showUpload: false }" class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                                <p class="text-sm font-semibold text-blue-800">Anda sudah memiliki dokumen tersimpan.
                                </p>
                                <p class="text-xs text-blue-700">Anda bisa menggunakan dokumen ini atau mengunggah yang
                                    baru.</p>
                                <button type="button" @click="showUpload = !showUpload"
                                    class="mt-2 text-sm font-bold text-blue-600 hover:underline">
                                    <span x-show="!showUpload">Unggah Dokumen Baru</span>
                                    <span x-show="showUpload">Gunakan Dokumen Tersimpan</span>
                                </button>

                                <div x-show="showUpload" x-transition class="mt-4 space-y-4">
                                    {{-- Form upload opsional jika dokumen sudah ada --}}
                                    <div>
                                        <label for="ktp_new" class="block text-sm font-medium text-slate-700">Upload
                                            Foto KTP Baru</label>
                                        <input type="file" id="ktp_new" name="ktp"
                                            class="mt-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        <p class="text-xs text-neutral-gray mt-1">Format: JPG, PNG. Max: 2MB.</p>
                                    </div>
                                    <div>
                                        <label for="sim_new" class="block text-sm font-medium text-slate-700">Upload
                                            Foto SIM A Baru</label>
                                        <input type="file" id="sim_new" name="sim"
                                            class="mt-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        <p class="text-xs text-neutral-gray mt-1">Format: JPG, PNG. Max: 2MB.</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- TAMPILAN JIKA DOKUMEN BELUM ADA (WAJIB UPLOAD) --}}
                            <div class="space-y-4">
                                <div>
                                    <label for="ktp" class="block text-sm font-medium text-slate-700">Upload Foto
                                        KTP</label>
                                    <input type="file" id="ktp" name="ktp"
                                        class="mt-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        required>
                                    <p class="text-xs text-neutral-gray mt-1">Format: JPG, PNG. Max: 2MB.</p>
                                </div>
                                <div>
                                    <label for="sim" class="block text-sm font-medium text-slate-700">Upload Foto
                                        SIM A</label>
                                    <input type="file" id="sim" name="sim"
                                        class="mt-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        required>
                                    <p class="text-xs text-neutral-gray mt-1">Format: JPG, PNG. Max: 2MB.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- ====================================================== --}}
                    {{-- ▲▲▲ AKHIR BLOK UPLOAD DOKUMEN ▲▲▲ --}}
                    {{-- ====================================================== --}}

                    <div class="border-t pt-6">
                        <h2 class="text-xl font-semibold text-dark-slate">Pilih Metode Pembayaran</h2>
                        <div class="mt-4 space-y-4">
                            <label for="payment_gateway"
                                class="flex items-center p-4 border rounded-lg cursor-pointer has-[:checked]:bg-blue-50 has-[:checked]:border-blue-600">
                                <input id="payment_gateway" name="payment_method" type="radio" value="gateway"
                                    class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" checked>
                                <div class="ml-3 text-sm">
                                    <p class="font-bold text-gray-900">Pembayaran Online</p>
                                    <p class="text-gray-500">Kartu Kredit, GoPay, Virtual Account, dll.</p>
                                </div>
                            </label>
                            <label for="payment_transfer"
                                class="flex items-center p-4 border rounded-lg cursor-pointer has-[:checked]:bg-blue-50 has-[:checked]:border-blue-600">
                                <input id="payment_transfer" name="payment_method" type="radio" value="transfer"
                                    class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <div class="ml-3 text-sm">
                                    <p class="font-bold text-gray-900">Transfer Bank (Manual)</p>
                                    <p class="text-gray-500">Perlu konfirmasi manual setelah transfer.</p>
                                </div>
                            </label>
                            <label for="payment_cash"
                                class="flex items-center p-4 border rounded-lg cursor-pointer has-[:checked]:bg-blue-50 has-[:checked]:border-blue-600">
                                <input id="payment_cash" name="payment_method" type="radio" value="cash"
                                    class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <div class="ml-3 text-sm">
                                    <p class="font-bold text-gray-900">Bayar di Tempat (Cash)</p>
                                    <p class="text-gray-500">Siapkan uang tunai saat pengambilan mobil.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: RINGKASAN PESANAN --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 bg-white p-6 rounded-xl shadow-lg">
                        <h3 class="text-xl font-bold text-dark-slate border-b pb-4">Ringkasan Pesanan</h3>

                        <div class="mt-4 flex items-center space-x-4">
                            <img src="{{ $vehicle->images->first() ? Storage::url($vehicle->images->first()->path) : 'https://via.placeholder.com/150' }}"
                                class="w-24 h-16 object-cover rounded-lg">
                            <div>
                                <p class="font-semibold text-dark-slate">{{ $vehicle->name }}</p>
                                <p class="text-sm text-neutral-gray">{{ $vehicle->brand->name }}</p>
                            </div>
                        </div>

                        <div class="mt-4 border-t pt-4 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-neutral-gray">Sewa Mobil ({{ $priceDetails['duration'] }}
                                    hari)</span>
                                <span class="font-medium text-slate-700">Rp
                                    {{ number_format($priceDetails['subtotal'], 0, ',', '.') }}</span>
                            </div>
                            @if ($priceDetails['extras_cost'] > 0)
                                <div class="flex justify-between">
                                    <span class="text-neutral-gray">Layanan Tambahan</span>
                                    <span class="font-medium text-slate-700">Rp
                                        {{ number_format($priceDetails['extras_cost'], 0, ',', '.') }}</span>
                                </div>
                            @endif

                            <template x-if="discountAmount > 0">
                                <div x-transition class="flex justify-between text-green-600">
                                    <span class="font-medium">Diskon (<span x-text="appliedCouponCode"></span>)</span>
                                    <span class="font-bold"
                                        x-text="`- Rp ${new Intl.NumberFormat('id-ID').format(discountAmount)}`"></span>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 border-t pt-4">
                            <label for="coupon" class="block text-sm font-semibold text-slate-700">Kode
                                Kupon</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="coupon" id="coupon" x-model="couponCode"
                                    placeholder="Masukkan kode promo"
                                    class="flex-1 block w-full rounded-none rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <button @click.prevent="applyCoupon" type="button"
                                    class="inline-flex items-center px-4 py-2 border border-l-0 border-blue-600 rounded-r-md bg-blue-600 text-white hover:bg-blue-700">
                                    Terapkan
                                </button>
                            </div>
                            <p x-show="couponMessage" :class="isCouponSuccess ? 'text-green-600' : 'text-red-600'"
                                class="text-sm mt-2" x-text="couponMessage"></p>
                        </div>

                        <div class="mt-4 border-t pt-4 flex justify-between items-center">
                            <span class="text-lg font-bold text-dark-slate">Total Biaya</span>
                            <span class="text-xl font-extrabold text-blue-600"
                                x-text="`Rp ${new Intl.NumberFormat('id-ID').format(finalTotal)}`"></span>
                        </div>

                        <button type="submit" x-text="buttonLabel" :disabled="isLoading"
                            class="mt-6 w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-bold py-3 px-4 rounded-lg transition">
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

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('checkoutForm', () => ({
                    isLoading: false,
                    buttonLabel: 'Lanjutkan Pesanan',
                    errorMessage: '',

                    couponCode: '',
                    appliedCouponCode: '',
                    couponMessage: '',
                    isCouponSuccess: false,
                    baseTotal: {{ $priceDetails['total_price'] }},
                    discountAmount: 0,

                    get finalTotal() {
                        const total = this.baseTotal - this.discountAmount;
                        return total > 0 ? total : 0;
                    },

                    applyCoupon() {
                        this.couponMessage = 'Memvalidasi...';
                        this.isCouponSuccess = false;

                        fetch('{{ route('api.coupons.validate') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                                },
                                body: JSON.stringify({
                                    coupon_code: this.couponCode,
                                    total_price: this.baseTotal
                                })
                            })
                            .then(res => res.json().then(data => ({
                                ok: res.ok,
                                data
                            })))
                            .then(({
                                ok,
                                data
                            }) => {
                                if (!ok) throw data;
                                this.isCouponSuccess = true;
                                this.couponMessage = `Kupon "${data.coupon.code}" berhasil diterapkan!`;
                                this.discountAmount = parseFloat(data.discount_amount);
                                this.appliedCouponCode = data.coupon.code;
                            })
                            .catch(error => {
                                this.isCouponSuccess = false;
                                this.couponMessage = error.message || 'Kupon tidak valid.';
                                this.discountAmount = 0;
                                this.appliedCouponCode = '';
                            });
                    },

                    submit(event) {
                        this.isLoading = true;
                        this.buttonLabel = 'Memproses...';
                        this.errorMessage = '';

                        const form = event.target;
                        const formData = new FormData(form);
                        const self = this;

                        fetch(form.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': form.querySelector('input[name=_token]').value
                                }
                            })
                            .then(res => res.json().then(data => ({
                                ok: res.ok,
                                data
                            })))
                            .then(({
                                ok,
                                data
                            }) => {
                                if (!ok) throw data;

                                if (data.snap_token) {
                                    snap.pay(data.snap_token, {
                                        onSuccess: (result) => window.location.href =
                                            `/?booking_ref=${result.order_id}&status=success`,
                                        onPending: (result) => window.location.href =
                                            `/?booking_ref=${result.order_id}&status=pending`,
                                        onError: (result) => {
                                            self.errorMessage = 'Pembayaran gagal.';
                                            self.resetButton();
                                        },
                                        onClose: () => self.resetButton()
                                    });
                                } else if (data.redirect_url) {
                                    window.location.href = data.redirect_url;
                                } else {
                                    throw new Error('Respons tidak valid dari server.');
                                }
                            })
                            .catch(error => {
                                this.errorMessage = error.message || 'Terjadi kesalahan.';
                                if (error.errors) this.errorMessage = Object.values(error.errors)[0][0];
                                this.resetButton();
                            });
                    },

                    resetButton() {
                        this.isLoading = false;
                        this.buttonLabel = 'Lanjutkan Pesanan';
                    }
                }));
            });
        </script>
    @endpush
</x-public-layout>
