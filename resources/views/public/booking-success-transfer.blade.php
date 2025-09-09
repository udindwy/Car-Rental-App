<x-public-layout>
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-xl text-center">

            {{-- Icon sukses --}}
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>

            {{-- Judul --}}
            <h1 class="mt-5 text-2xl md:text-3xl font-bold text-slate-800">
                Pesanan Anda Telah Kami Terima!
            </h1>
            <p class="mt-3 text-gray-600">
                Pesanan Anda dengan ID <span class="font-semibold text-slate-800">#{{ $booking->id }}</span> telah
                berhasil dibuat dan saat ini <span class="font-medium text-blue-600">menunggu pembayaran</span>.
            </p>

            {{-- Instruksi Pembayaran --}}
            <div class="mt-8 text-left bg-gray-50 p-6 rounded-xl border border-gray-200">
                <h2 class="text-lg font-semibold text-slate-800">Instruksi Pembayaran</h2>
                <p class="mt-2 text-sm text-gray-600">Silakan lakukan transfer sejumlah:</p>

                <p class="text-3xl font-extrabold text-blue-600 my-3">
                    Rp {{ number_format($booking->grand_total, 0, ',', '.') }}
                </p>
                <p class="text-xs text-red-500">⚠️ Mohon transfer sesuai dengan jumlah di atas, jangan dibulatkan.</p>

                <div class="mt-5 space-y-4 border-t pt-4">
                    <p class="text-sm text-gray-600">Transfer ke salah satu rekening berikut:</p>

                    <div class="bg-white p-4 rounded-lg border shadow-sm flex justify-between items-center">
                        <div>
                            <p class="font-bold text-slate-800">BCA</p>
                            <p class="text-sm">No. Rekening: <span id="rekening-bca"
                                    class="font-semibold">1234567890</span></p>
                            <p class="text-sm">Atas Nama: <span class="font-medium">PT Rental Mobil Keren</span></p>
                        </div>
                        <button onclick="copyRekening('rekening-bca')"
                            class="ml-3 p-2 bg-gray-100 hover:bg-gray-200 rounded-full text-gray-600 shadow-sm transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16h8M8 12h8m-6-8h6a2 2 0 012 2v12a2 2 0 01-2 2H8a2 2 0 01-2-2V6a2 2 0 012-2z" />
                            </svg>
                        </button>
                    </div>

                    <div class="bg-white p-4 rounded-lg border shadow-sm flex justify-between items-center mt-3">
                        <div>
                            <p class="font-bold text-slate-800">Bank Mandiri</p>
                            <p class="text-sm">No. Rekening: <span id="rekening-mandiri"
                                    class="font-semibold">0987654321</span></p>
                            <p class="text-sm">Atas Nama: <span class="font-medium">PT Rental Mobil Keren</span></p>
                        </div>
                        <button onclick="copyRekening('rekening-mandiri')"
                            class="ml-3 p-2 bg-gray-100 hover:bg-gray-200 rounded-full text-gray-600 shadow-sm transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16h8M8 12h8m-6-8h6a2 2 0 012 2v12a2 2 0 01-2 2H8a2 2 0 01-2-2V6a2 2 0 012-2z" />
                            </svg>
                        </button>
                    </div>

                    {{-- Script Copy --}}
                    <script>
                        function copyRekening(id) {
                            const rekening = document.getElementById(id).innerText;
                            navigator.clipboard.writeText(rekening).then(() => {
                                alert("Nomor rekening berhasil disalin: " + rekening);
                            });
                        }
                    </script>

                </div>

                <div class="mt-6 border-t pt-4">
                    <p class="text-sm text-gray-600">
                        Setelah melakukan pembayaran, pesanan Anda akan <span class="font-medium">dikonfirmasi
                            manual</span> oleh tim kami.
                        Anda akan menerima notifikasi melalui email.
                    </p>
                </div>
            </div>

            {{-- Tombol kembali --}}
            <a href="{{ route('home') }}"
                class="inline-block mt-8 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition">
                Kembali ke Halaman Utama
            </a>
        </div>
    </div>
</x-public-layout>
