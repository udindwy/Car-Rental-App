@props(['vehicle'])

@php
    // Bulatkan rating agar mudah digunakan
    $rating = round($vehicle->average_rating, 1);
@endphp

<div class="flex h-full flex-col overflow-hidden rounded-xl bg-white shadow-md transition-all duration-300 group hover:-translate-y-1 hover:shadow-xl"
    data-aos="fade-up">
    <a href="{{ route('vehicle.show', $vehicle->slug) }}" class="flex h-full flex-col">
        {{-- Gambar --}}
        <div class="h-48 overflow-hidden">
            @if ($vehicle->images->isNotEmpty())
                <img src="{{ Storage::url($vehicle->images->first()->path) }}" alt="{{ $vehicle->name }}"
                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            @else
                <img src="https://via.placeholder.com/400x300.png/0f172a/ffffff?text={{ urlencode($vehicle->name) }}"
                    alt="{{ $vehicle->name }}" class="h-full w-full object-cover">
            @endif
        </div>

        <div class="flex flex-1 flex-col p-5">
            {{-- Bagian Atas: Brand, Nama, & Rating --}}
            <div class="flex items-start justify-between">
                <div class="flex-1 pr-2">
                    <p class="truncate text-sm text-gray-500">{{ $vehicle->brand->name }}</p>
                    <h3 class="min-h-[3.5rem] text-lg font-semibold text-slate-800 line-clamp-2">
                        {{ $vehicle->name }}
                    </h3>
                </div>
                <div class="flex flex-shrink-0 items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="h-5 w-5 text-amber-400">
                        <path fill-rule="evenodd"
                            d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium text-slate-700">
                        {{ $rating > 0 ? number_format($rating, 1) : 'N/A' }}
                    </span>
                </div>
            </div>

            {{-- Bagian Tengah (akan memanjang untuk mengisi ruang) --}}
            <div class="flex-1">
                {{-- Info Singkat (Kursi, Transmisi, Bagasi) --}}
                <div class="my-4 flex justify-around border-t border-b py-3 text-sm text-gray-600">
                    <div class="text-center" title="Kursi">
                        <div class="mx-auto mb-1 flex h-8 w-8 items-center justify-center rounded-full bg-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-slate-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-4.67c.625-.926 1.282-1.94 2.024-3.09M15 19.128a9.38 9.38 0 00-2.625-.372M15 19.128c-.288.042-.578.085-.87.127a9.38 9.38 0 01-2.625-.372m-1.548 2.016a5.25 5.25 0 01-7.424 0m7.424 0a5.25 5.25 0 00-7.424 0M12 6a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5zm-3.75 3.75a3.75 3.75 0 007.5 0M12 12.75a3.75 3.75 0 010-7.5 3.75 3.75 0 010 7.5z" />
                            </svg>
                        </div>
                        <span class="text-xs">{{ $vehicle->seats }} Kursi</span>
                    </div>
                    <div class="text-center" title="Transmisi">
                        <div class="mx-auto mb-1 flex h-8 w-8 items-center justify-center rounded-full bg-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-slate-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                            </svg>
                        </div>
                        <span class="text-xs">{{ $vehicle->transmission }}</span>
                    </div>
                    <div class="text-center" title="Bagasi">
                        <div class="mx-auto mb-1 flex h-8 w-8 items-center justify-center rounded-full bg-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-slate-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 9.563C9 9.252 9.252 9 9.563 9h4.874c.311 0 .563.252.563.563v4.874c0 .311-.252.563-.563.563H9.563A.562.562 0 019 14.437V9.564z" />
                            </svg>
                        </div>
                        <span class="text-xs">{{ $vehicle->luggage ?? 0 }} Bagasi</span>
                    </div>
                </div>
            </div>

            {{-- Bagian Bawah: Harga & Tombol --}}
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-sm text-gray-500">Mulai dari</p>
                    <p class="text-xl font-extrabold text-slate-900">
                        Rp {{ number_format($vehicle->base_price_day, 0, ',', '.') }}
                        <span class="font-normal text-sm text-gray-500">/hari</span>
                    </p>
                </div>
                <div
                    class="rounded-lg bg-blue-600 px-5 py-2.5 font-semibold text-white shadow-sm transition duration-300 group-hover:bg-blue-700">
                    Lihat Detail
                </div>
            </div>
        </div>
    </a>
</div>
