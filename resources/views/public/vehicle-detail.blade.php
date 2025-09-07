<x-public-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <img src="{{ $vehicle->images->first() ? Storage::url($vehicle->images->first()->path) : 'https://via.placeholder.com/600x400' }}" 
                     alt="{{ $vehicle->name }}" 
                     class="w-full h-auto object-cover rounded-lg shadow-lg">
                </div>

            <div>
                <p class="text-sm text-gray-500">{{ $vehicle->brand->name }}</p>
                <h1 class="text-4xl font-bold text-slate-800">{{ $vehicle->name }}</h1>
                
                <div class="mt-4">
                    <span class="text-sm text-gray-500">Mulai dari</span><br>
                    <span class="text-slate-900 font-extrabold text-3xl">
                        Rp {{ number_format($vehicle->base_price_day, 0, ',', '.') }}
                    </span>
                    <span class="text-lg text-gray-500">/ hari</span>
                </div>

                <div class="mt-6 border-t pt-4">
                    <h3 class="text-lg font-semibold text-slate-700 mb-2">Spesifikasi</h3>
                    <div class="grid grid-cols-2 gap-4 text-gray-600">
                        <span><i class="fas fa-users mr-2"></i> {{ $vehicle->seats }} Kursi</span>
                        <span><i class="fas fa-cogs mr-2"></i> {{ $vehicle->transmission }}</span>
                        <span><i class="fas fa-gas-pump mr-2"></i> {{ ucfirst($vehicle->fuel) }}</span>
                        <span><i class="fas fa-suitcase mr-2"></i> {{ $vehicle->luggage ?? 0 }} Bagasi</span>
                    </div>
                </div>

                <div class="mt-6 border-t pt-4">
                    <h3 class="text-lg font-semibold text-slate-700 mb-2">Fitur</h3>
                    <div class="grid grid-cols-2 gap-2 text-gray-600">
                        @forelse($vehicle->features as $feature)
                            <span>- {{ $feature->name }}</span>
                        @empty
                            <span>-</span>
                        @endforelse
                    </div>
                </div>

                <div class="mt-8">
                    <a href="#" class="w-full block text-center bg-emerald-500 text-white py-3 px-6 rounded-lg font-semibold text-lg hover:bg-emerald-600 transition">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-2xl font-bold text-slate-800 mb-4">Ulasan Pelanggan</h2>
            <div class="space-y-6">
                @forelse($vehicle->reviews->where('approved', true) as $review)
                    <div class="border rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <span class="font-bold text-slate-700">{{ $review->user->name }}</span>
                            <div class="flex items-center ml-4 text-amber-400">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="h-5 w-5 {{ $i < $review->rating ? 'fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-600">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada ulasan untuk mobil ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-public-layout>