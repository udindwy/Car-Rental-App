<x-public-layout>

    {{-- Memanggil komponen dari folder public --}}
    <x-public.hero-section />

    {{-- Memanggil komponen dari folder public --}}
    <x-public.advantages-section />

    {{-- Memanggil komponen dari folder public dan mengirimkan datanya --}}
    <x-public.featured-vehicles :vehicles="$featuredVehicles" />

    <x-public.testimonial-section :reviews="$reviews" />

</x-public-layout>
