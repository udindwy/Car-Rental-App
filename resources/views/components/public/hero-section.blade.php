{{-- File: resources/views/components/public/hero-section.blade.php --}}

{{-- DIUBAH: Gradien latar belakang dan tata letak utama --}}
<div class="relative min-h-[600px] overflow-hidden bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center">
    <div class="container mx-auto px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">

            {{-- ========== KIRI: Konten Utama ========== --}}
            {{-- DIUBAH: Perataan teks menjadi 'text-left' --}}
            <div class="z-10 text-left">

                {{-- Brand --}}
                <div data-aos="fade-right">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white mb-4 sm:text-5xl">
                        {{-- Nama Rental Dinamis --}}
                        {{ $settings->site_name ?? 'CarRental' }}
                    </h1>
                </div>

                {{-- Deskripsi --}}
                {{-- DIUBAH: Warna teks deskripsi disesuaikan --}}
                <p class="mt-4 max-w-2xl text-lg text-blue-100" data-aos="fade-right" data-aos-delay="100">
                    Solusi terpercaya untuk kebutuhan transportasi Anda di Jogja. Nikmati perjalanan yang nyaman dengan
                    armada terbaik dan driver berpengalaman.
                </p>

                {{-- Keunggulan --}}
                <div class="mt-8 grid max-w-sm grid-cols-1 gap-4 sm:grid-cols-2" data-aos="fade-right"
                    data-aos-delay="200">
                    @foreach (['Driver Berpengalaman', 'Armada Terawat', 'Harga Terjangkau', 'Support 24/7'] as $item)
                        {{-- DIUBAH: Desain item keunggulan dengan efek glassmorphism dan hover --}}
                        <div
                            class="flex items-center gap-3 rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm transition-all duration-300 hover:bg-white/20 hover:border-white/30 hover:-translate-y-1">
                            <i class="lucide-check-circle text-lg text-amber-400"></i>
                            <span>{{ $item }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Tombol CTA --}}
                <div class="mt-12" data-aos="fade-up" data-aos-delay="300">
                    {{-- DIUBAH: Desain tombol CTA disesuaikan --}}
                    <a href="{{ route('catalog') }}"
                        class="inline-flex items-center justify-center rounded-lg border-2 border-transparent 
                        bg-amber-400 px-8 py-3 text-base font-bold leading-none text-slate-900 
                        shadow-lg shadow-amber-500/30 transition-all duration-300 hover:scale-105 hover:bg-amber-500 
                        focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 focus:ring-offset-indigo-600">
                        Booking Sekarang
                    </a>
                </div>

            </div>

            {{-- ========== KANAN: Gambar Mobil & Latar ========== --}}
            {{-- DIUBAH: Elemen dekoratif dihapus, hanya menyisakan gambar mobil --}}
            <div class="relative flex h-[350px] items-center justify-center sm:h-[450px] lg:h-auto lg:justify-end">

                {{-- Gambar Armada dengan animasi float --}}
                <img src="{{ Storage::url('vehicles/home.png') }}" alt="Armada CarRental"
                    class="animate-float relative z-10 w-full max-w-xl object-contain drop-shadow-2xl"
                    data-aos="fade-left" data-aos-delay="400">
            </div>
        </div>
    </div>
</div>

{{-- DIUBAH: Animasi diubah dari pulse-slow menjadi float --}}
<style>
    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .animate-float {
        animation: float 4s infinite ease-in-out;
    }
</style>
