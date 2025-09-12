{{-- File: resources/views/components/public/hero-section.blade.php --}}

<div
    class="relative min-h-[600px] overflow-hidden bg-gradient-to-r from-slate-900 via-blue-900 to-blue-800 flex items-center">
    <div class="container mx-auto px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">

            {{-- ========== KIRI: Konten Utama ========== --}}
            <div class="z-10 text-left">

                {{-- Brand --}}
                <div data-aos="fade-right">
                    <h1 class="text-4xl font-extrabold tracking-tight text-blue-600 mb-4">
                        CarRental
                    </h1>
                </div>

                {{-- Deskripsi --}}
                <p class="mt-4 max-w-2xl text-lg text-slate-600" data-aos="fade-right" data-aos-delay="100">
                    Solusi terpercaya untuk kebutuhan transportasi Anda di Jogja. Nikmati perjalanan yang nyaman dengan
                    armada terbaik dan driver berpengalaman.
                </p>

                {{-- Keunggulan --}}
                <div class="mt-8 grid max-w-sm grid-cols-1 gap-4 sm:grid-cols-2" data-aos="fade-right"
                    data-aos-delay="200">
                    @foreach (['Driver Berpengalaman', 'Armada Terawat', 'Harga Terjangkau', 'Support 24/7'] as $item)
                        <div
                            class="flex items-center gap-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700">
                            <i class="lucide-check-circle text-lg text-blue-600"></i>
                            <span>{{ $item }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Tombol CTA --}}
                <div class="mt-12" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('catalog') }}"
                        class="inline-flex items-center justify-center rounded-full border-2 border-transparent 
              bg-blue-600 px-8 py-3 text-base font-bold leading-none text-white 
              transition-all duration-300 hover:bg-blue-700 focus:outline-none 
              focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Booking Sekarang
                    </a>
                </div>


            </div>

            {{-- ========== KANAN: Gambar Mobil & Latar ========== --}}
            <div
                class="relative flex h-[350px] items-center justify-center overflow-hidden sm:h-[450px] lg:h-auto lg:justify-end">

                {{-- Lingkaran animasi --}}
                <div
                    class="animate-pulse-slow absolute -right-16 top-1/2 h-[450px] w-[450px] -translate-y-1/2 rounded-full bg-amber-400 mix-blend-screen opacity-70">
                </div>

                {{-- Ikon gedung dekoratif --}}
                <div class="absolute bottom-0 right-0 z-0 opacity-40">
                    <i class="lucide-building text-[250px] text-slate-800/50"></i>
                </div>

                {{-- Gambar Armada --}}
                <img src="{{ Storage::url('vehicles/home.png') }}" alt="Armada CarRental"
                    class="relative z-10 w-full max-w-xl object-contain drop-shadow-2xl" data-aos="zoom-in"
                    data-aos-delay="400">
            </div>
        </div>
    </div>
</div>

{{-- Animasi Lingkaran --}}
<style>
    @keyframes pulse-slow {

        0%,
        100% {
            transform: scale(0.95) translateY(-50%);
            opacity: 0.7;
        }

        50% {
            transform: scale(1.05) translateY(-50%);
            opacity: 0.85;
        }
    }

    .animate-pulse-slow {
        animation: pulse-slow 6s infinite ease-in-out;
    }
</style>
