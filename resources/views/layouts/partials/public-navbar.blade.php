<nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 10)" {{-- DIUBAH: Latar belakang awal sekarang 'bg-white', bukan 'bg-transparent' --}}
    :class="{ 'bg-white/95 backdrop-blur shadow-md': scrolled, 'bg-white shadow-sm': !scrolled }"
    class="fixed w-full top-0 z-50 transition-all duration-300 ease-in-out">

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}">
                    {{-- DIUBAH: Warna logo sekarang selalu biru --}}
                    <h1 class="text-2xl font-bold text-blue-600 transition-colors duration-300">
                        CarRental
                    </h1>
                </a>
            </div>

            {{-- Navigasi Desktop --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                <a href="{{ route('home') }}"
                    class="px-1 pt-1 text-sm font-medium transition-all duration-300 border-b-2"
                    :class="{
                        'border-blue-600 text-slate-900': {{ request()->routeIs('home') ? 'true' : 'false' }},
                        'border-transparent text-slate-500 hover:text-slate-900 hover:border-slate-300': !
                            {{ request()->routeIs('home') ? 'true' : 'false' }}
                        {{-- DIUBAH: Logika warna disederhanakan karena latar belakang selalu terang --}}
                    }">
                    Home
                </a>
                <a href="{{ route('catalog') }}"
                    class="px-1 pt-1 text-sm font-medium transition-all duration-300 border-b-2"
                    :class="{
                        'border-blue-600 text-slate-900': {{ request()->routeIs('catalog') ? 'true' : 'false' }},
                        'border-transparent text-slate-500 hover:text-slate-900 hover:border-slate-300': !
                            {{ request()->routeIs('catalog') ? 'true' : 'false' }}
                        {{-- DIUBAH: Logika warna disederhanakan --}}
                    }">
                    Katalog
                </a>
                <a href="#"
                    class="px-1 pt-1 text-sm font-medium transition-all duration-300 border-b-2 border-transparent text-slate-500 hover:text-slate-900 hover:border-slate-300">
                    {{-- DIUBAH: Kelas dibuat statis dengan warna gelap --}}
                    Tentang Kami
                </a>
            </div>

            {{-- Tombol Login (Desktop) --}}
            <div class="hidden sm:flex sm:items-center">
                @guest
                    {{-- DIUBAH: Tombol login sekarang selalu biru --}}
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors duration-300 bg-blue-600 hover:bg-blue-700 text-white">
                        Login
                    </a>
                @else
                    <a href="{{ auth()->user()->isAdminOrStaff() ? route('admin.dashboard') : route('dashboard') }}"
                        class="text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-lg transition">
                        {{ auth()->user()->isAdminOrStaff() ? 'Dasbor Admin' : 'Dasbor Saya' }}
                    </a>
                @endguest
            </div>

            {{-- Tombol Hamburger (Mobile) --}}
            <div class="flex items-center sm:hidden">
                {{-- DIUBAH: Warna ikon hamburger selalu gelap --}}
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md transition text-slate-500 hover:bg-slate-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />


                        {{-- Menu Navigasi Mobile (sudah bagus, tidak perlu diubah) --}}
                        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white shadow-lg">
                            <div class="pt-2 pb-3 space-y-1">
                                <a href="{{ route('home') }}"
                                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('home') ? 'bg-blue-50 border-blue-600 text-blue-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800' }}">
                                    Home
                                </a>
                                <a href="{{ route('catalog') }}"
                                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('catalog') ? 'bg-blue-50 border-blue-600 text-blue-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800' }}">
                                    Katalog
                                </a>
                                <a href="#"
                                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800">
                                    Tentang Kami
                                </a>
                            </div>
                            <div class="pt-4 pb-3 border-t border-slate-200">
                                <div class="px-2">
                                    @auth
                                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                                            <a href="{{ route('admin.dashboard') }}"
                                                class="block w-full text-left bg-blue-600 text-white py-2 px-3 rounded-lg font-semibold hover:bg-blue-700 transition">Dasbor
                                                Admin</a>
                                        @else
                                            <a href="{{ route('dashboard') }}"
                                                class="block w-full text-left bg-blue-600 text-white py-2 px-3 rounded-lg font-semibold hover:bg-blue-700 transition">Dasbor
                                                Saya</a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="block w-full text-left bg-blue-600 text-white py-2 px-3 rounded-lg font-semibold hover:bg-blue-700 transition">Login</a>
                                    @endauth
                                </div>
                            </div>
                        </div>

                        {{-- Menu Navigasi Mobile (sudah bagus, tidak perlu diubah) --}}
                        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white shadow-lg">
                            <div class="pt-2 pb-3 space-y-1">
                                <a href="{{ route('home') }}"
                                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('home') ? 'bg-blue-50 border-blue-600 text-blue-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800' }}">
                                    Home
                                </a>
                                <a href="{{ route('catalog') }}"
                                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('catalog') ? 'bg-blue-50 border-blue-600 text-blue-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800' }}">
                                    Katalog
                                </a>
                                <a href="#"
                                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800">
                                    Tentang Kami
                                </a>
                            </div>
                            <div class="pt-4 pb-3 border-t border-slate-200">
                                <div class="px-2">
                                    @auth
                                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                                            <a href="{{ route('admin.dashboard') }}"
                                                class="block w-full text-left bg-blue-600 text-white py-2 px-3 rounded-lg font-semibold hover:bg-blue-700 transition">Dasbor
                                                Admin</a>
                                        @else
                                            <a href="{{ route('dashboard') }}"
                                                class="block w-full text-left bg-blue-600 text-white py-2 px-3 rounded-lg font-semibold hover:bg-blue-700 transition">Dasbor
                                                Saya</a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="block w-full text-left bg-blue-600 text-white py-2 px-3 rounded-lg font-semibold hover:bg-blue-700 transition">Login</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
</nav>
