<x-admin-layout>
    <x-slot name="header">
        Pengaturan Situs & Kontak
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                <!-- Bagian Branding & Tampilan -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Branding & Tampilan</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="site_name" class="block text-sm font-medium text-gray-700">Nama Rental</label>
                            <input type="text" name="site_name" id="site_name"
                                value="{{ old('site_name', $settings->site_name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="theme_color" class="block text-sm font-medium text-gray-700">Warna Tema
                                Utama</label>
                            <input type="color" name="theme_color" id="theme_color"
                                value="{{ old('theme_color', $settings->theme_color) }}"
                                class="mt-1 h-10 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label for="logo" class="block text-sm font-medium text-gray-700">Logo Situs</label>

                            @if ($settings->logo && Illuminate\Support\Facades\Storage::disk('public')->exists($settings->logo))
                                <div class="mt-2 flex items-center gap-4">
                                    <img src="{{ Illuminate\Support\Facades\Storage::url($settings->logo) }}"
                                        alt="Logo saat ini" class="h-16 w-auto bg-gray-100 p-2 rounded">

                                    {{-- Tombol Hapus Logo --}}
                                    <a href="{{ route('admin.settings.remove-logo') }}"
                                        onclick="return confirm('Anda yakin ingin menghapus logo ini?');"
                                        class="px-3 py-1.5 rounded-md text-xs font-medium text-white bg-red-600 hover:bg-red-700 transition">
                                        Hapus Logo
                                    </a>
                                </div>
                            @endif

                            <input type="file" name="logo" id="logo"
                                class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">Format: PNG, JPG, SVG. Ukuran Maks: 2MB. Biarkan
                                kosong jika tidak ingin mengubah logo.</p>
                        </div>
                    </div>
                </div>

                <!-- Bagian Informasi Kontak -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Informasi Kontak</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="whatsapp" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" id="whatsapp"
                                value="{{ old('whatsapp', $settings->whatsapp) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="Contoh: 6281234567890">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Telepon Kantor</label>
                            <input type="text" name="phone" id="phone"
                                value="{{ old('phone', $settings->phone) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="Contoh: (021) 123-456">
                        </div>
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $settings->email) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="Contoh: kontak@rentalanda.com">
                        </div>
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Alamat
                                Kantor/Garasi</label>
                            <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('address', $settings->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Bagian Media Sosial -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Media Sosial</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="facebook_url" class="block text-sm font-medium text-gray-700">URL
                                Facebook</label>
                            <input type="url" name="facebook_url" id="facebook_url"
                                value="{{ old('facebook_url', $settings->facebook_url) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="https://facebook.com/namarental">
                        </div>
                        <div>
                            <label for="instagram_url" class="block text-sm font-medium text-gray-700">URL
                                Instagram</label>
                            <input type="url" name="instagram_url" id="instagram_url"
                                value="{{ old('instagram_url', $settings->instagram_url) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                placeholder="https://instagram.com/namarental">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

</x-admin-layout>
