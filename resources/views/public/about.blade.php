<x-public-layout>
    {{-- Hero Section Slider --}}
    <div x-data="slider()" x-init="startLoop()"
        class="relative min-h-[60vh] sm:min-h-[80vh] flex items-center justify-center overflow-hidden">

        {{-- Slide Images & Overlay --}}
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index + 1" x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="absolute inset-0">

                {{-- Background Image --}}
                <img src="{{ Storage::url('vehicles/aboutme.jpg') }}" alt="Rental Mobil Terbaik di Yogyakarta"
                    class="w-full h-full object-cover">
                {{-- Overlay Gelap --}}
                <div class="absolute inset-0 bg-slate-900/60"></div>

                {{-- Teks Overlay --}}
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white p-4">
                    <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight" x-text="slide.title"
                        data-aos="fade-down"></h1>
                    <p class="mt-4 text-lg md:text-xl max-w-3xl" x-text="slide.subtitle" data-aos="fade-up"
                        data-aos-delay="100"></p>
                </div>
            </div>
        </template>

        {{-- Tombol Navigasi (Kiri & Kanan) --}}
        <div class="absolute z-10 flex justify-between w-full px-4 sm:px-10">
            <button @click="prev()"
                class="bg-white/20 hover:bg-white/40 text-white rounded-full h-10 w-10 sm:h-12 sm:w-12 flex items-center justify-center transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="next()"
                class="bg-white/20 hover:bg-white/40 text-white rounded-full h-10 w-10 sm:h-12 sm:w-12 flex items-center justify-center transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        {{-- Titik Paginasi --}}
        <div class="absolute z-10 bottom-8 flex space-x-3">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="goTo(index + 1)" class="h-2 w-2 rounded-full transition-all duration-300"
                    :class="{
                        'bg-blue-500 w-6': activeSlide === index + 1,
                        {{-- Diubah dari amber menjadi biru --}} 'bg-white/50 hover:bg-white/80': activeSlide !== index + 1
                    }">
                </button>
            </template>
        </div>
    </div>

    {{-- Konten Utama (BARU DITAMBAHKAN) --}}
    <div class="bg-white py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">

                {{-- Menampilkan konten dari database --}}
                <div class="prose max-w-none prose-lg prose-indigo" data-aos="fade-up">
                    {{-- Kita akan memuat konten dinamis di sini dari controller --}}
                    @if (isset($page))
                        {!! $page->content !!}
                    @else
                        <p>Konten tentang kami belum tersedia. Silakan cek kembali nanti.</p>
                    @endif
                </div>

                {{-- Bagian Tambahan (Opsional) --}}
                <div class="mt-16 text-center" data-aos="zoom-in">
                    <h2 class="text-3xl font-bold text-dark-slate">Siap Memulai Perjalanan Anda?</h2>
                    <p class="mt-4 text-neutral-gray">
                        Lihat armada kami yang tersedia dan pesan mobil impian Anda hari ini.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('catalog') }}"
                            class="inline-block bg-blue-600 text-white font-semibold px-8 py-3 rounded-lg hover:bg-blue-700 transition">
                            Lihat Semua Mobil
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-public-layout>

{{-- SCRIPT untuk AlpineJS --}}
<script>
    function slider() {
        return {
            activeSlide: 1,
            interval: null,
            // ▼▼▼ KUSTOMISASI GAMBAR DAN TEKS DI SINI ▼▼▼
            slides: [{
                    image: '{{ Storage::url('vehicles/about1.jpg') }}',
                    title: 'Armada Terlengkap di Yogyakarta',
                    subtitle: 'Berbagai pilihan kendaraan untuk setiap kebutuhan perjalanan Anda.'
                },
                {
                    image: '{{ Storage::url('vehicles/about2.jpg') }}',
                    title: 'Harga Terbaik & Transparan',
                    subtitle: 'Dapatkan penawaran harga sewa mobil paling kompetitif tanpa biaya tersembunyi.'
                },
                {
                    image: '{{ Storage::url('vehicles/about3.jpg') }}',
                    title: 'Driver Profesional & Berpengalaman',
                    subtitle: 'Nikmati perjalanan yang aman dan nyaman bersama driver kami yang ramah.'
                },
                {
                    image: '{{ Storage::url('vehicles/about4.jpg') }}',
                    title: 'Pesan Mudah & Cepat',
                    subtitle: 'Proses booking yang simpel melalui website kami, siap dalam hitungan menit.'
                }
            ],
            startLoop() {
                this.interval = setInterval(() => {
                    this.next();
                }, 5000); // Ganti slide setiap 5 detik
            },
            next() {
                this.activeSlide = (this.activeSlide % this.slides.length) + 1;
                this.resetLoop();
            },
            prev() {
                this.activeSlide = (this.activeSlide - 2 + this.slides.length) % this.slides.length + 1;
                this.resetLoop();
            },
            goTo(slideNumber) {
                this.activeSlide = slideNumber;
                this.resetLoop();
            },
            resetLoop() {
                clearInterval(this.interval);
                this.startLoop();
            }
        }
    }
</script>
