@props(['vehicles'])

<div class="py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-dark-slate">Armada Pilihan Kami</h2>
            <p class="mt-2 text-neutral-gray">Temukan mobil yang paling sesuai untuk kebutuhan Anda.</p>
        </div>
        @if ($vehicles->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($vehicles as $vehicle)
                    <x-public.vehicle-card :vehicle="$vehicle" />
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('catalog') }}"
                    class="inline-block bg-blue-600 text-white font-semibold px-8 py-3 rounded-lg hover:bg-blue-700 transition">
                    Lihat Semua Mobil
                </a>
            </div>
        @else
            <p class="text-center text-neutral-gray">Saat ini belum ada mobil unggulan yang tersedia.</p>
        @endif
    </div>
</div>
