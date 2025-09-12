<footer class="bg-slate-900 text-slate-400">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Kolom 1: Tentang & Logo --}}
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="text-2xl font-extrabold text-white tracking-tight">
                    {{ $settings->site_name ?? 'CarRental' }}
                </a>
                <p class="mt-4 text-sm max-w-md">
                    Solusi terpercaya untuk kebutuhan transportasi Anda. Nikmati perjalanan yang nyaman dengan armada
                    terbaik.
                </p>
            </div>

            {{-- Kolom 2: Halaman --}}
            <div>
                <h3 class="text-sm font-semibold tracking-wider text-slate-300 uppercase">Halaman</h3>
                <ul class="mt-4 space-y-3">
                    {{-- Menambahkan link ke halaman statis --}}
                    @foreach ($pages as $page)
                        <li>
                            @php
                                $routeName = 'home'; 
                                if ($page->slug === 'tentang-kami') {
                                    $routeName = 'about';
                                }
                                if ($page->slug === 'syarat-ketentuan') {
                                    $routeName = 'terms';
                                }
                            @endphp
                            <a href="{{ route($routeName) }}"
                                class="text-sm hover:text-white transition">{{ $page->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>


            {{-- Kolom 3: Hubungi Kami --}}
            <div>
                <h3 class="font-semibold tracking-wider text-slate-300 uppercase">Hubungi Kami</h3>
                <ul class="mt-4 space-y-4 text-sm">
                    @if ($settings->address)
                        <li class="flex items-start gap-3">
                            {{-- Ikon Peta --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-5 w-5 text-blue-500 mt-1 flex-shrink-0">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            <span>{{ $settings->address }}</span>
                        </li>
                    @endif
                    @if ($settings->whatsapp)
                        <li class="flex items-start gap-3">
                            {{-- Ikon Telepon (untuk WA) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-5 w-5 text-blue-500 mt-1 flex-shrink-0">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                            <span>{{ $settings->whatsapp }} (WA)</span>
                        </li>
                    @endif
                    @if ($settings->phone)
                        <li class="flex items-start gap-3">
                            {{-- Ikon Telepon (untuk Kantor) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-5 w-5 text-blue-500 mt-1 flex-shrink-0">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                            <span>{{ $settings->phone }} (Kantor)</span>
                        </li>
                    @endif
                    @if ($settings->email)
                        <li class="flex items-start gap-3">
                            {{-- Ikon Email --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-5 w-5 text-blue-500 mt-1 flex-shrink-0">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                            <span>{{ $settings->email }}</span>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- Kolom 4: Media Sosial --}}
            <div>
                <h3 class="font-semibold tracking-wider text-slate-300 uppercase">Ikuti Kami</h3>
                <div class="mt-4 flex space-x-4">
                    @if ($settings->facebook_url)
                        <a href="{{ $settings->facebook_url }}" target="_blank" aria-label="Facebook"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-slate-400 transition hover:bg-blue-600 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-5 w-5">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                            </svg>
                        </a>
                    @endif
                    @if ($settings->instagram_url)
                        <a href="{{ $settings->instagram_url }}" target="_blank" aria-label="Instagram"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-slate-400 transition hover:bg-blue-600 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-5 w-5">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>
                        </a>
                    @endif
                    @if ($settings->youtube_url)
                        <a href="{{ $settings->youtube_url }}" target="_blank" aria-label="YouTube"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-slate-400 transition hover:bg-blue-600 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                <path
                                    d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17" />
                                <path d="m10 15 5-3-5-3z" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Bagian Copyright --}}
        <div class="border-t border-slate-800 py-6 text-center text-sm">
            <p>&copy; {{ date('Y') }} {{ $settings->site_name ?? 'CarRental' }}. Semua Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>
