@props(['reviews'])

<div class="overflow-hidden bg-white py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold tracking-tight text-dark-slate sm:text-5xl">
                Apa Kata Pelanggan Kami
            </h2>
            <p class="mt-4 text-lg text-neutral-gray">
                Kepuasan pelanggan adalah prioritas utama kami.
            </p>
            <div class="mt-6 h-1 w-24 bg-blue-600 mx-auto rounded-full"></div>
        </div>

        @if ($reviews->isNotEmpty())
            <div class="swiper testimonial-slider">
                <div class="swiper-wrapper py-4">
                    @foreach ($reviews as $review)
                        {{-- Pastikan ada 'flex h-auto' di swiper-slide --}}
                        <div class="swiper-slide flex h-auto">
                            <x-public.review-card :review="$review" />
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination !relative mt-12"></div>
            </div>
        @else
            <div class="text-center py-16 px-6 bg-slate-50 rounded-2xl">
                <p class="text-lg font-medium text-slate-700">Belum Ada Ulasan</p>
                <p class="text-slate-500">Jadilah yang pertama memberikan testimoni untuk layanan kami.</p>
            </div>
        @endif
    </div>
</div>
