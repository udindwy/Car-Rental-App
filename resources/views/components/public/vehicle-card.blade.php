@props(['vehicle'])

<div class="bg-white rounded-xl shadow-md overflow-hidden group transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
    data-aos="fade-up">
    <a href="{{ route('vehicle.show', $vehicle->slug) }}">
        {{-- Gambar --}}
        <div class="overflow-hidden h-48">
            @if ($vehicle->images->isNotEmpty())
                <img src="{{ Storage::url($vehicle->images->first()->path) }}" alt="{{ $vehicle->name }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            @else
                <img src="https://via.placeholder.com/400x300.png/0f172a/ffffff?text=No+Image" alt="No Image Available"
                    class="w-full h-full object-cover">
            @endif
        </div>

        <div class="p-5">
            {{-- Brand + Nama + Rating --}}
            <div class="flex justify-between items-start mb-3">
                <div class="pr-2">
                    <p class="text-sm text-gray-500 truncate">{{ $vehicle->brand->name }}</p>
                    <h3 class="text-lg font-semibold text-slate-800 line-clamp-2">
                        {{ $vehicle->name }}
                    </h3>
                </div>
                <div class="flex items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="h-4 w-4 {{ $vehicle->average_rating >= $i ? 'text-amber-400' : 'text-gray-300' }}"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921
                                     1.902 0l1.07 3.292a1 1 0
                                     00.95.69h3.462c.969 0
                                     1.371 1.24.588 1.81l-2.8
                                     2.034a1 1 0 00-.364
                                     1.118l1.07 3.292c.3.921-
                                     .755 1.688-1.54 1.118l-2.8-
                                     2.034a1 1 0 00-1.175 0l-2.8
                                     2.034c-.784.57-1.838-.197-
                                     1.539-1.118l1.07-3.292a1 1 0
                                     00-.364-1.118L2.98 8.72c-
                                     .783-.57-.38-1.81.588-1.81h3.461a1
                                     1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @endfor
                    <span class="ml-1 text-sm font-medium text-slate-700">
                        {{ $vehicle->average_rating > 0 ? $vehicle->average_rating : 'N/A' }}
                    </span>
                </div>
            </div>

            {{-- Info singkat --}}
            <div class="grid grid-cols-3 gap-3 text-center text-xs text-gray-600 my-4 border-t border-b py-3">
                <div title="Kursi">
                    <svg class="h-5 w-5 mx-auto mb-1 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0
                                 018 0zM12 14a7 7 0
                                 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>{{ $vehicle->seats }} Kursi</span>
                </div>
                <div title="Transmisi">
                    <svg class="h-5 w-5 mx-auto mb-1 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10.29 3.86L1.82 18a2 2 0
                                 001.71 3h16.94a2 2 0
                                 001.71-3L13.71 3.86a2 2 0
                                 00-3.42 0z" />
                    </svg>
                    <span>{{ ucfirst($vehicle->transmission) }}</span>
                </div>
                <div title="Bagasi">
                    <svg class="h-5 w-5 mx-auto mb-1 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 8h14M5 8a2 2 0
                                 110-4h14a2 2 0 110 4M5 8v10a2 2 0
                                 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    <span>{{ $vehicle->luggage ?? 0 }} Bagasi</span>
                </div>
            </div>

            {{-- Harga + Tombol --}}
            <div class="flex justify-between items-end mt-4">
                <div>
                    <p class="text-sm text-gray-500">Mulai dari</p>
                    <p class="text-slate-900 font-extrabold text-xl">
                        Rp {{ number_format($vehicle->base_price_day, 0, ',', '.') }}
                        <span class="text-sm text-gray-500 font-normal">/hari</span>
                    </p>
                </div>
                <a href="{{ route('vehicle.show', $vehicle->slug) }}"
                    class="bg-emerald-500 text-white px-5 py-2.5 rounded-lg font-semibold shadow-sm
                          hover:bg-emerald-600 hover:scale-105 transition transform duration-300">
                    Lihat Detail
                </a>
            </div>
        </div>
    </a>
</div>
