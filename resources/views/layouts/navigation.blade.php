<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur shadow-md border-b border-slate-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-extrabold text-blue-600 tracking-tight">
                    CarRental
                </a>
            </div>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="{{ route('dashboard') }}"
                    class="font-medium transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                    Dasbor Saya
                </a>
                <a href="{{ route('catalog') }}"
                    class="font-medium transition-colors duration-200 {{ request()->routeIs('catalog') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                    Katalog
                </a>
                <a href="{{ route('home') }}"
                    class="font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                    Kembali ke Home
                </a>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-600 bg-white hover:text-slate-800 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profil
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out">
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

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                Dasbor Saya
            </a>
            <a href="{{ route('catalog') }}"
                class="block px-3 py-2 rounded-md font-medium {{ request()->routeIs('catalog') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                Katalog
            </a>
            <a href="{{ route('home') }}"
                class="block text-gray-700 hover:bg-gray-50 font-medium px-3 py-2 rounded-md">
                Kembali ke Home
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil
                </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
