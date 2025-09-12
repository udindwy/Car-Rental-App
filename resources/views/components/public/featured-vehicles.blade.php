@props(['vehicles'])

<div class="bg-blue-50 py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Judul Utama --}}
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold tracking-tight text-dark-slate sm:text-5xl">
                Armada Pilihan Kami
            </h2>
            <p class="mt-4 text-lg text-neutral-gray">
                Temukan mobil yang paling sesuai untuk kebutuhan perjalanan Anda.
            </p>
            <div class="mt-6 h-1 w-24 bg-blue-600 mx-auto rounded-full"></div>
        </div>

        {{-- Vehicle Grid --}}
        @if ($vehicles->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($vehicles as $vehicle)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <x-public.vehicle-card :vehicle="$vehicle" />
                    </div>
                @endforeach
            </div>

            {{-- Tombol "Lihat Semua" di Bawah dengan Ikon --}}
            <div class="text-center mt-16">
                <a href="{{ route('catalog') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-8 py-3 text-base font-semibold text-white shadow-md transition duration-300 hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <span>Lihat Semua Mobil</span>
                    {{-- Ikon panah dari Heroicons --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd"
                            d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        @else
            <div class="text-center py-16">
                <p class="text-neutral-gray">Saat ini belum ada mobil unggulan yang tersedia.</p>
            </div>
        @endif

    </div>
</div>
