@props(['vehicle'])

@php
    // Bulatkan rating agar mudah digunakan
    $rating = round($vehicle->average_rating, 1);
@endphp

<div class="bg-white rounded-xl shadow-md overflow-hidden group transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
    data-aos="fade-up">
    <a href="{{ route('vehicle.show', $vehicle->slug) }}" class="block">
        {{-- Gambar --}}
        <div class="overflow-hidden h-48">
            @if ($vehicle->images->isNotEmpty())
                <img src="{{ Storage::url($vehicle->images->first()->path) }}" alt="{{ $vehicle->name }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            @else
                <img src="https://via.placeholder.com/400x300.png/0f172a/ffffff?text={{ urlencode($vehicle->name) }}"
                    alt="{{ $vehicle->name }}" class="w-full h-full object-cover">
            @endif
        </div>

        <div class="p-5">
            {{-- Brand, Nama, & Rating --}}
            <div class="flex justify-between items-start">
                <div class="flex-1 pr-2">
                    <p class="text-sm text-gray-500 truncate">{{ $vehicle->brand->name }}</p>
                    <h3 class="text-lg font-semibold text-slate-800 line-clamp-2 h-14">
                        {{ $vehicle->name }}
                    </h3>
                </div>
                <div class="flex items-center space-x-1 flex-shrink-0">
                    <i class="lucide-star text-amber-400 fill-current w-4 h-4"></i>
                    <span class="text-sm font-medium text-slate-700">
                        {{ $rating > 0 ? number_format($rating, 1) : 'N/A' }}
                    </span>
                </div>
            </div>

            {{-- Info Singkat (Kursi, Transmisi, Bagasi) --}}
            <div class="grid grid-cols-3 gap-3 text-center text-xs text-gray-600 my-4 border-t border-b py-3">
                <div class="flex flex-col items-center" title="Kursi">
                    <i class="lucide-users mb-1 text-slate-500"></i>
                    <span>{{ $vehicle->seats }} Kursi</span>
                </div>
                <div class="flex flex-col items-center" title="Transmisi">
                    <i class="lucide-sliders-horizontal mb-1 text-slate-500"></i>
                    <span>{{ $vehicle->transmission }}</span>
                </div>
                <div class="flex flex-col items-center" title="Bagasi">
                    <i class="lucide-briefcase mb-1 text-slate-500"></i>
                    <span>{{ $vehicle->luggage ?? 0 }} Bagasi</span>
                </div>
            </div>

            {{-- Harga & Tombol --}}
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-sm text-gray-500">Mulai dari</p>
                    <p class="text-slate-900 font-extrabold text-xl">
                        Rp {{ number_format($vehicle->base_price_day, 0, ',', '.') }}
                        <span class="text-sm text-gray-500 font-normal">/hari</span>
                    </p>
                </div>
                <div
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-semibold shadow-sm group-hover:bg-blue-700 transition duration-300">
                    Lihat Detail
                </div>
            </div>
        </div>
    </a>
</div>
