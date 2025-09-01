<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-cloak></div>

<aside
    :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen,
        'lg:translate-x-0': !sidebarCollapsed,
        'lg:-translate-x-full': sidebarCollapsed
    }"
    class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col justify-between overflow-y-auto border-r border-gray-200 bg-white text-slate-700 transition-transform duration-300">

    <div>
        <div class="flex h-24 flex-col items-center justify-center border-b border-gray-200 bg-gray-50/50 px-6">
            <svg class="mb-2 h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 003.375-3.375h1.5a1.125 1.125 0 011.125 1.125v-1.5c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 003.375 3.375v1.875a2.25 2.25 0 01-2.25 2.25H5.625a2.25 2.25 0 01-2.25-2.25z" />
            </svg>
            <span class="text-lg font-bold tracking-wide text-slate-800">Admin Panel</span>
        </div>

        <nav class="mt-4 space-y-2 px-4">
            <a class="flex items-center rounded-lg py-2 px-4 transition-colors duration-200 
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-blue-50 font-semibold text-blue-600'
                    : 'text-slate-500 hover:bg-gray-100 hover:text-slate-800' }}"
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
                        ? 'bg-blue-50 font-semibold text-blue-600'
                        : 'text-slate-500 hover:bg-gray-100 hover:text-slate-800' }}">
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
                        class="block rounded-lg py-2 px-4 text-sm {{ request()->routeIs('admin.vehicles.*') ? 'font-semibold text-blue-600' : 'text-slate-500 hover:text-slate-800' }}">Daftar
                        Mobil</a>
                    <a href="{{ route('admin.brands.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm {{ request()->routeIs('admin.brands.*') ? 'font-semibold text-blue-600' : 'text-slate-500 hover:text-slate-800' }}">Brand</a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm {{ request()->routeIs('admin.categories.*') ? 'font-semibold text-blue-600' : 'text-slate-500 hover:text-slate-800' }}">Kategori</a>
                    <a href="{{ route('admin.branches.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm {{ request()->routeIs('admin.branches.*') ? 'font-semibold text-blue-600' : 'text-slate-500 hover:text-slate-800' }}">Cabang</a>
                    <a href="{{ route('admin.features.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm {{ request()->routeIs('admin.features.*') ? 'font-semibold text-blue-600' : 'text-slate-500 hover:text-slate-800' }}">Fitur</a>
                </div>
            </div>
        </nav>
    </div>
</aside>
