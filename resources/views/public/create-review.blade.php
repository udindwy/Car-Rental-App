<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Tulis Ulasan untuk Pesanan #{{ $booking->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl p-6 md:p-8">

                {{-- Detail Mobil yang Diulas --}}
                <div class="flex items-center space-x-4 p-4 bg-slate-50 rounded-lg border">
                    <img src="{{ $booking->vehicle->images->first() ? Storage::url($booking->vehicle->images->first()->path) : 'https://via.placeholder.com/150' }}"
                        alt="{{ $booking->vehicle->name }}" class="w-28 h-20 object-cover rounded-md">
                    <div>
                        <p class="text-sm text-slate-500">{{ $booking->vehicle->brand->name }}</p>
                        <h3 class="font-bold text-lg text-slate-800">{{ $booking->vehicle->name }}</h3>
                    </div>
                </div>

                {{-- Form Ulasan --}}
                <form action="{{ route('review.store') }}" method="POST" class="mt-6 space-y-6"
                    x-data="{ rating: 0, hoverRating: 0 }">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                    {{-- Rating Bintang Interaktif --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Rating Anda</label>
                        <div class="mt-2 flex items-center" @mouseleave="hoverRating = 0">
                            <template x-for="star in 5">
                                <svg @mouseenter="hoverRating = star" @click="rating = star"
                                    class="h-8 w-8 cursor-pointer"
                                    :class="(hoverRating >= star || rating >= star) ? 'text-amber-400' : 'text-slate-300'"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27l-5.18 2.73 1-5.77-4.18-4.08 5.81-.84L12 4.63l2.54 5.68 5.81.84-4.18 4.08 1 5.77z" />
                                </svg>
                            </template>
                        </div>
                        <input type="hidden" name="rating" x-model="rating">
                        @error('rating')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Komentar --}}
                    <div>
                        <label for="comment" class="block text-sm font-medium text-slate-700">Ulasan Anda
                            (Opsional)</label>
                        <textarea name="comment" id="comment" rows="5" placeholder="Bagikan pengalaman Anda..."
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        @error('comment')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end pt-4 border-t">
                        <a href="{{ route('dashboard') }}"
                            class="bg-white py-2 px-4 rounded-md shadow-sm text-sm font-medium text-slate-700 border border-slate-300 hover:bg-slate-50">
                            Batal
                        </a>
                        <button type="submit"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Kirim Ulasan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
