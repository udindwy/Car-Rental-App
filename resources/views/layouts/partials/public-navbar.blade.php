<nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 10)"
    :class="{ 'bg-white/95 backdrop-blur shadow-md': scrolled, 'bg-transparent': !scrolled }"
    class="fixed w-full top-0 z-50 transition-all duration-300 ease-in-out">

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            {{-- Logo Dinamis --}}
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}">
                    @if ($settings->logo)
                        <img src="{{ Storage::url($settings->logo) }}" alt="{{ $settings->site_name }}"
                            class="h-10 w-auto">
                    @else
                        <h1 class="text-2xl font-bold transition-colors duration-300"
                            :class="scrolled ? 'text-slate-800' : 'text-white'"
                            style="color: var(--theme-color-primary, #2563eb)">
                            {{ $settings->site_name ?? 'CarRental' }}
                        </h1>
                    @endif
                </a>
            </div>

            {{-- Navigasi Desktop --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                {{-- Link 1: Home --}}
                <a href="{{ route('home') }}" @class([
                    'px-1 pt-1 text-sm font-medium transition-all duration-300 border-b-2',
                    'border-blue-600 text-slate-900' => request()->routeIs('home'),
                    'border-transparent text-slate-500 hover:text-slate-900 hover:border-slate-300' => !request()->routeIs(
                        'home'),
                ])>
                    Home
                </a>

                {{-- Link 2: Tentang Kami --}}
                <a href="{{ route('about') }}" @class([
                    'px-1 pt-1 text-sm font-medium transition-all duration-300 border-b-2',
                    'border-blue-600 text-slate-900' => request()->routeIs('about'),
                    'border-transparent text-slate-500 hover:text-slate-900 hover:border-slate-300' => !request()->routeIs(
                        'about'),
                ])>
                    Tentang Kami
                </a>

                {{-- Link 3: Katalog --}}
                <a href="{{ route('catalog') }}" @class([
                    'px-1 pt-1 text-sm font-medium transition-all duration-300 border-b-2',
                    'border-blue-600 text-slate-900' => request()->routeIs('catalog'),
                    'border-transparent text-slate-500 hover:text-slate-900 hover:border-slate-300' => !request()->routeIs(
                        'catalog'),
                ])>
                    Katalog
                </a>
            </div>

            {{-- Tombol Login (Desktop) --}}
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' || auth()->user()->role === 'staff' ? route('admin.dashboard') : route('dashboard') }}"
                        class="text-sm font-semibold text-white px-5 py-2.5 rounded-lg transition"
                        style="background-color: var(--theme-color-primary, #2563eb)">
                        Dasbor
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-white px-5 py-2.5 rounded-lg transition"
                        style="background-color: var(--theme-color-primary, #2563eb)">
                        Login
                    </a>
                @endauth
            </div>

            {{-- Tombol Hamburger (Mobile) --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md transition"
                    :class="scrolled ? 'text-slate-500 hover:bg-slate-100' : 'text-slate-300 hover:bg-white/10'">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu Navigasi Mobile --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white shadow-lg">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">Tentang Kami</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('catalog')" :active="request()->routeIs('catalog')">Katalog</x-responsive-nav-link>
        </div>
        <div class="pt-4 pb-3 border-t border-slate-200">
            <div class="px-2">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' || auth()->user()->role === 'staff' ? route('admin.dashboard') : route('dashboard') }}"
                        class="block w-full text-left text-white py-2 px-3 rounded-lg font-semibold transition"
                        style="background-color: var(--theme-color-primary, #2563eb)">
                        Dasbor
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="block w-full text-left text-white py-2 px-3 rounded-lg font-semibold transition"
                        style="background-color: var(--theme-color-primary, #2563eb)">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
