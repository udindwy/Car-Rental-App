{{-- resources/views/components/review-card.blade.php --}}

@props(['review'])

<div class="flex space-x-4 border-b pb-4">
    {{-- Avatar Pengguna --}}
    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=0f172a&color=fff&rounded=true"
        alt="{{ $review->user->name }}" class="w-12 h-12 rounded-full flex-shrink-0">

    <div>
        {{-- Nama, Rating, dan Waktu --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
            <h4 class="font-bold text-dark-slate">{{ $review->user->name }}</h4>
            <div class="flex items-center text-amber-500">
                @for ($i = 0; $i < 5; $i++)
                    <i class="lucide-star text-sm {{ $i < $review->rating ? 'fill-current' : 'text-gray-300' }}"></i>
                @endfor
            </div>
            <span class="text-xs text-neutral-gray mt-1 sm:mt-0">{{ $review->created_at->diffForHumans() }}</span>
        </div>

        {{-- Komentar Ulasan --}}
        <p class="mt-2 text-neutral-gray">{{ $review->comment }}</p>
    </div>
</div>
