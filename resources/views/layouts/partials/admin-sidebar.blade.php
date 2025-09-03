<!-- Background overlay for mobile -->

<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-cloak></div>

<!-- Sidebar -->

<aside
    :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen,
        'lg:translate-x-0': !sidebarCollapsed,
        'lg:-translate-x-full': sidebarCollapsed
    }"
    class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col justify-between overflow-y-auto bg-gradient-to-b from-blue-700 to-blue-800 text-white transition-transform duration-300">

    <div>
        <!-- Logo & Title -->
        <div class="flex h-20 items-center justify-center border-b border-blue-600/50 bg-blue-800 px-6">
            <div class="flex items-center">
                <svg class="h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 003.375-3.375h1.5a1.125 1.125 0 011.125 1.125v-1.5c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 003.375 3.375v1.875a2.25 2.25 0 01-2.25 2.25H5.625a2.25 2.25 0 01-2.25-2.25z" />
                </svg>
                <span class="ml-3 text-lg font-bold tracking-wider">Admin Panel</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-4 space-y-2 px-4">
            <a class="flex items-center rounded-lg py-2 px-4 transition-colors duration-200 
            {{ request()->routeIs('admin.dashboard')
                ? 'bg-blue-600 font-semibold text-white'
                : 'text-blue-100 hover:bg-blue-600 hover:text-white' }}"
                href="{{ route('admin.dashboard') }}">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" />
                </svg>
                <span class="ml-4 whitespace-nowrap">Dashboard</span>
            </a>

            <div x-data="{ open: {{ request()->routeIs(['admin.vehicles.*', 'admin.brands.*', 'admin.categories.*', 'admin.features.*', 'admin.branches.*']) ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="flex w-full items-center justify-between rounded-lg py-2 px-4 transition-colors duration-200 
                {{ request()->routeIs([
                    'admin.vehicles.*',
                    'admin.brands.*',
                    'admin.categories.*',
                    'admin.features.*',
                    'admin.branches.*',
                ])
                    ? 'bg-blue-600 font-semibold text-white'
                    : 'text-blue-100 hover:bg-blue-600 hover:text-white' }}">
                    <div class="flex items-center">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 003.375-3.375h1.5a1.125 1.125 0 011.125 1.125v-1.5c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 003.375 3.375v1.875a2.25 2.25 0 01-2.25 2.25H5.625a2.25 2.25 0 01-2.25-2.25z" />
                        </svg>
                        <span class="ml-4 whitespace-nowrap">Armada</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="h-5 w-5 transform transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-cloak class="mt-2 space-y-2 pl-6">
                    <a href="{{ route('admin.vehicles.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm {{ request()->routeIs('admin.vehicles.*') ? 'font-semibold text-white' : 'text-blue-200 hover:text-white' }}">Daftar
                        Mobil</a>
                    <a href="{{ route('admin.brands.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm {{ request()->routeIs('admin.brands.*') ? 'font-semibold text-white' : 'text-blue-200 hover:text-white' }}">Brand</a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm {{ request()->routeIs('admin.categories.*') ? 'font-semibold text-white' : 'text-blue-200 hover:text-white' }}">Kategori</a>
                    <a href="{{ route('admin.branches.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm {{ request()->routeIs('admin.branches.*') ? 'font-semibold text-white' : 'text-blue-200 hover:text-white' }}">Cabang</a>
                    <a href="{{ route('admin.features.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm {{ request()->routeIs('admin.features.*') ? 'font-semibold text-white' : 'text-blue-200 hover:text-white' }}">Fitur</a>
                </div>
            </div>
        </nav>
    </div>

</aside>
