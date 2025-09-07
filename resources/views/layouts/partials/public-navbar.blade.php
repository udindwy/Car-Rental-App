<nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 10)"
    :class="{ 'bg-white shadow-md': scrolled, 'bg-transparent': !scrolled }"
    class="fixed w-full top-0 z-50 transition-all duration-300 ease-in-out">

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}">
                    <h1 class="text-2xl font-bold text-blue-600">CarRental</h1>
                </a>
            </div>

            {{-- Navigasi Desktop --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                <a href="{{ route('home') }}"
                    class="px-1 pt-1 text-sm font-medium transition border-b-2
                    {{ request()->routeIs('home')
                        ? 'border-blue-600 text-slate-900'
                        : 'border-transparent text-slate-500 hover:border-blue-300 hover:text-slate-700' }}">
                    Home
                </a>
                <a href="{{ route('catalog') }}"
                    class="px-1 pt-1 text-sm font-medium transition border-b-2
                    {{ request()->routeIs('catalog')
                        ? 'border-blue-600 text-slate-900'
                        : 'border-transparent text-slate-500 hover:border-blue-300 hover:text-slate-700' }}">
                    Katalog
                </a>
                <a href="#"
                    class="px-1 pt-1 text-sm font-medium transition border-b-2 border-transparent text-slate-500 hover:border-blue-300 hover:text-slate-700">
                    Tentang Kami
                </a>
            </div>

            {{-- Tombol Login (Desktop) --}}
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-lg transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-lg transition">
                        Login
                    </a>
                @endauth
            </div>

            {{-- Tombol Hamburger (Mobile) --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-700 transition">
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
            <a href="{{ route('home') }}"
                class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium
                {{ request()->routeIs('home')
                    ? 'bg-blue-50 border-blue-600 text-blue-700'
                    : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800' }}">
                Home
            </a>
            <a href="{{ route('catalog') }}" class="block pl-3 pr-4 py-2 border-l
