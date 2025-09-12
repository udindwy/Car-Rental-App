<x-public-layout>
    <div class="bg-white py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                {{-- Judul Halaman --}}
                <h1 class="text-4xl font-bold text-dark-slate text-center" data-aos="fade-down">
                    {{ $page->title }}
                </h1>

                {{-- Konten Halaman --}}
                <div class="prose max-w-none mt-8" data-aos="fade-up">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
