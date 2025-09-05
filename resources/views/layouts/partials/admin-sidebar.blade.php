<!-- Background overlay for mobile -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-cloak>
</div>

<!-- Sidebar -->
<aside
    :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen,
        'lg:translate-x-0': !sidebarCollapsed,
        'lg:-translate-x-full': sidebarCollapsed
    }"
    class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col justify-between
           overflow-y-auto bg-gradient-to-b from-blue-700 to-blue-800 
           text-white transition-transform duration-300">

    <div>
        <!-- Logo & Title -->
        <div class="flex h-20 items-center justify-center border-b border-blue-600/50 bg-blue-800 px-6">
            <div class="flex items-center space-x-3">
                <!-- Logo Mobil -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13l2-5.5A2 2 0 017 6h10a2 2 0
                             011.9 1.5L21 13m-18 0h18m-18 0v4a2 2 0
                             002 2h1a2 2 0 002-2v-1h8v1a2 2 0
                             002 2h1a2 2 0 002-2v-4" />
                    <circle cx="7.5" cy="17.5" r="1.5" fill="currentColor" />
                    <circle cx="16.5" cy="17.5" r="1.5" fill="currentColor" />
                </svg>

                <!-- Title -->
                <span class="text-lg font-bold tracking-wider text-white">
                    Admin Panel
                </span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-4 space-y-2 px-4">

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center rounded-lg py-2 px-4 transition-colors duration-200 
                      {{ request()->routeIs('admin.dashboard')
                          ? 'bg-blue-600 font-semibold text-white'
                          : 'text-blue-100 hover:bg-blue-600 hover:text-white' }}">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439
                             1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125
                             c0 .621.504 1.125 1.125 1.125H9.75v-4.875
                             c0-.621.504-1.125 1.125-1.125h2.25
                             c.621 0 1.125.504 1.125 1.125V21h4.125
                             c.621 0 1.125-.504 1.125-1.125V9.75
                             M8.25 21h7.5" />
                </svg>
                <span class="ml-4 whitespace-nowrap">Dashboard</span>
            </a>

            <!-- Pemesanan -->
            <a href="{{ route('admin.bookings.index') }}"
                class="flex items-center rounded-lg py-2 px-4 transition-colors duration-200 
                      {{ request()->routeIs('admin.bookings.*')
                          ? 'bg-blue-600 font-semibold text-white'
                          : 'text-blue-100 hover:bg-blue-600 hover:text-white' }}">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75
                             m3 .75H18a2.25 2.25 0 002.25-2.25V6.108
                             c0-1.135-.845-2.098-1.976-2.192
                             a48.424 48.424 0 00-1.123-.08m-5.801 0
                             c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5
                             a.75.75 0 00.75-.75 2.25 2.25 0
                             00-.1-.664m-5.8 0A2.251 2.251
                             0 0113.5 2.25H15c1.012 0 1.867.668
                             2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08
                             C9.095 4.01 8.25 4.973 8.25 6.108V8.25
                             m0 0H4.875c-1.125 0-2.25.9-2.25
                             2.25v11.25c0 1.243 1.009 2.25
                             2.25 2.25H18a2.25 2.25 0
                             002.25-2.25V16.5" />
                </svg>
                <span class="ml-4 whitespace-nowrap">Pemesanan</span>
            </a>

            <!-- Pembayaran -->
            <a href="{{ route('admin.payments.index') }}"
                class="flex items-center rounded-lg py-2 px-4 transition-colors duration-200 
                      {{ request()->routeIs('admin.payments.*')
                          ? 'bg-blue-600 font-semibold text-white'
                          : 'text-blue-100 hover:bg-blue-600 hover:text-white' }}">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5
                             m-16.5 5.25h6m-6 2.25h3
                             m-3.75 3h15a2.25 2.25 0
                             002.25-2.25V6.75A2.25 2.25
                             0 0019.5 4.5h-15a2.25 2.25
                             0 00-2.25 2.25v10.5A2.25 2.25
                             0 004.5 21z" />
                </svg>
                <span class="ml-4 whitespace-nowrap">Pembayaran</span>
            </a>



            <!-- Kupon -->
            <a href="{{ route('admin.coupons.index') }}"
                class="flex items-center rounded-lg py-2 px-4 transition-colors duration-200 
          {{ request()->routeIs('admin.coupons.*')
              ? 'bg-blue-600 font-semibold text-white'
              : 'text-blue-100 hover:bg-blue-600 hover:text-white' }}">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0
                 3V18m-9-5.25h5.25M7.5 15h3M3.375
                 5.25c-.621 0-1.125.504-1.125
                 1.125v3.026a2.999 2.999 0
                 010 5.198v3.026c0 .621.504
                 1.125 1.125 1.125h17.25c.621
                 0 1.125-.504 1.125-1.125v-3.026
                 a2.999 2.999 0 010-5.198V6.375
                 c0-.621-.504-1.125-1.125-1.125H3.375z" />
                </svg>
                <span class="ml-4 whitespace-nowrap">Kupon & Promo</span>
            </a>

            <!-- Layanan Tambahan -->
            <a href="{{ route('admin.extras.index') }}"
                class="flex items-center rounded-lg py-2 px-4 transition-colors duration-200 
          {{ request()->routeIs('admin.extras.*')
              ? 'bg-blue-600 font-semibold text-white'
              : 'text-blue-100 hover:bg-blue-600 hover:text-white' }}">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879
               3.07.879 4.242 0 1.172-.879 1.172-2.303
               0-3.182C13.536 12.219 12.768 12
               12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303
               0-3.182s2.9-.879 4.006 0l.415.33M21
               12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="ml-4 whitespace-nowrap">Layanan Tambahan</span>
            </a>

            <!-- Ulasan & Review -->
            <a href="{{ route('admin.reviews.index') }}"
                class="flex items-center rounded-lg py-2 px-4 transition-colors duration-200 
          {{ request()->routeIs('admin.reviews.*')
              ? 'bg-blue-600 font-semibold text-white'
              : 'text-blue-100 hover:bg-blue-600 hover:text-white' }}">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6
               1.123 2.994 2.707 3.227 1.129.166 2.27.293
               3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14
               1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233
               2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394
               48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746
               2.25 5.14 2.25 6.741v6.018z" />
                </svg>
                <span class="ml-4 whitespace-nowrap">Ulasan & Review</span>
            </a>

            <!-- Armada Dropdown -->
            <div x-data="{ open: {{ request()->routeIs([
                'admin.vehicles.*',
                'admin.brands.*',
                'admin.categories.*',
                'admin.features.*',
                'admin.branches.*',
            ])
                ? 'true'
                : 'false' }} }">

                <button @click="open = !open"
                    class="flex w-full items-center justify-between rounded-lg py-2 px-4 
                               transition-colors duration-200 
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0
                                     m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375
                                     a1.125 1.125 0 01-1.125-1.125V14.25
                                     m17.25 4.5a1.5 1.5 0 01-3 0m3 0
                                     a1.5 1.5 0 00-3 0m3 0h1.125
                                     c.621 0 1.125-.504 1.125-1.125V14.25
                                     m-17.25 4.5v-1.875a3.375 3.375
                                     0 003.375-3.375h1.5a1.125 1.125
                                     0 011.125 1.125v-1.5c0-.621.504-1.125
                                     1.125-1.125h3.75c.621 0 1.125.504
                                     1.125 1.125v1.5c0 .621.504 1.125
                                     1.125 1.125h1.5a3.375 3.375
                                     0 003.375 3.375v1.875a2.25 2.25
                                     0 01-2.25 2.25H5.625a2.25 2.25
                                     0 01-2.25-2.25z" />
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
                        class="block rounded-lg py-2 px-4 text-sm 
                              {{ request()->routeIs('admin.vehicles.*') ? 'font-semibold text-white' : 'text-blue-200 hover:text-white' }}">
                        Daftar Mobil
                    </a>
                    <a href="{{ route('admin.brands.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm 
                              {{ request()->routeIs('admin.brands.*') ? 'font-semibold text-white' : 'text-blue-200 hover:text-white' }}">
                        Brand
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm 
                              {{ request()->routeIs('admin.categories.*') ? 'font-semibold text-white' : 'text-blue-200 hover:text-white' }}">
                        Kategori
                    </a>
                    <a href="{{ route('admin.branches.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm 
                              {{ request()->routeIs('admin.branches.*') ? 'font-semibold text-white' : 'text-blue-200 hover:text-white' }}">
                        Cabang
                    </a>
                    <a href="{{ route('admin.features.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm 
                              {{ request()->routeIs('admin.features.*') ? 'font-semibold text-white' : 'text-blue-200 hover:text-white' }}">
                        Fitur
                    </a>
                </div>
            </div>

            <!-- TAMBAHKAN LINK PENGGUNA DI SINI -->
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center rounded-lg py-2 px-4 transition-colors duration-200 
        {{ request()->routeIs('admin.users.*')
            ? 'bg-blue-600 font-semibold text-white'
            : 'text-blue-100 hover:bg-blue-600 hover:text-white' }}">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372
               9.337 9.337 0 004.121-.952
               4.125 4.125 0 00-7.533-2.493M15 19.128v-.003
               c0-1.113-.285-2.16-.786-3.07M15 19.128v.106
               A12.318 12.318 0 018.624 21
               c-2.331 0-4.512-.645-6.374-1.766l-.001-.109
               a6.375 6.375 0 0111.964-4.663M12 12.375
               a3.375 3.375 0 100-6.75
               3.375 3.375 0 000 6.75z" />
                </svg>
                <span class="ml-4 whitespace-nowrap">Pengguna</span>
            </a>


            <!-- Dropdown Pengaturan -->
            <div x-data="{ open: {{ request()->routeIs(['admin.pages.*', 'admin.settings.*']) ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="flex w-full items-center justify-between rounded-lg py-2 px-4 transition-colors duration-200 
            {{ request()->routeIs(['admin.pages.*', 'admin.settings.*'])
                ? 'bg-blue-600 font-semibold text-white'
                : 'text-blue-100 hover:bg-blue-600 hover:text-white' }}">
                    <div class="flex items-center">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-1.007 1.11-1.226l.28-.082c.55-.16 1.15.026
                       1.565.44l.287.287c.414.415.602.965.44 1.565l-.082.28c-.22.55-.685
                       1.02-1.227 1.11a48.454 48.454 0 01-2.822 0c-.542-.09-.997-.56-1.226-1.11l-.082-.28c-.16-.55.026-1.15.44-1.565l.287-.287c.415-.414.965-.602 1.565-.44l.28.082zM15.157
                       15.157c.09.542.56 1.007 1.11 1.226l.28.082c.55.16 1.15-.026
                       1.565-.44l.287-.287c.414-.415.602-.965.44-1.565l-.082-.28c-.22-.55-.685-1.02-1.227-1.11a48.455
                       48.455 0 01-2.822 0c-.542.09-.997.56-1.226
                       1.11l-.082.28c-.16.55.026-1.15.44-1.565l.287-.287c.415-.414.965-.602
                       1.565-.44l.28.082zM8.843 15.157c.09.542.56 1.007
                       1.11 1.226l.28.082c.55.16 1.15-.026
                       1.565-.44l.287-.287c.414-.415.602-.965.44-1.565l-.082-.28c-.22-.55-.685-1.02-1.227-1.11a48.455
                       48.455 0 01-2.822 0c-.542.09-.997.56-1.226
                       1.11l-.082.28c-.16.55.026-1.15.44-1.565l.287-.287c.415-.414.965-.602
                       1.565-.44l.28.082z" />
                        </svg>
                        <span class="ml-4 whitespace-nowrap">Pengaturan</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="h-5 w-5 transform transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-cloak class="mt-2 space-y-2 pl-6">
                    <a href="{{ route('admin.pages.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm 
                  {{ request()->routeIs('admin.pages.*') ? 'font-semibold text-white' : 'text-blue-200 hover:text-white' }}">
                        Halaman
                    </a>
                    <a href="{{ route('admin.settings.index') }}"
                        class="block rounded-lg py-2 px-4 text-sm text-blue-200 hover:text-white">
                        Situs & Kontak
                    </a>
                </div>
            </div>
        </nav>
    </div>
</aside>
