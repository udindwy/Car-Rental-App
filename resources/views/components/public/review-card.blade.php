@props(['review'])

<div
    class="relative flex h-full w-full flex-col rounded-2xl border border-slate-200 bg-white p-8 
            transition-all duration-300 ease-in-out hover:shadow-xl hover:-translate-y-2 hover:border-blue-500">
    <div class="relative z-10 flex h-full flex-col">
        {{-- Bintang Rating --}}
        <div class="mb-2 flex items-center"> {{-- Menambahkan mb-2 untuk jarak bawah --}}
            @for ($i = 0; $i < 5; $i++)
                <svg class="h-5 w-5 {{ $i < $review->rating ? 'text-amber-400' : 'text-slate-300' }}"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
            @endfor
        </div>

        {{-- Isi Ulasan (dengan grow agar area ini memanjang) --}}
        <p class="grow text-base text-slate-700">"{{ $review->comment }}"</p> {{-- text-base untuk font biasa --}}

        {{-- Info Pengguna --}}
        <div class="mt-6 flex items-center gap-4 border-t border-slate-200 pt-6">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100">
                {{-- Warna ikon lingkaran diseragamkan ke biru --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="font-semibold text-dark-slate">{{ $review->user?->name ?? 'Pengguna' }}</p>
                <p class="text-sm text-neutral-gray">Menyewa {{ $review->vehicle?->name ?? 'Mobil' }}</p>
            </div>
        </div>
    </div>
</div>
