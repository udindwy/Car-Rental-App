<x-public-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <aside class="md:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-lg sticky top-24">
                    <h2 class="text-xl font-bold mb-4">Filter</h2>
                    <form action="{{ route('catalog') }}" method="GET">
                        <div class="mb-4">
                            <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                            <select name="brand" id="brand" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Semua Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected(request('brand') == $brand->id)>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
            </aside>

            <main class="md:col-span-3">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Katalog Mobil</h1>
                    <form action="{{ route('catalog') }}" method="GET">
                        @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="sort" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm">
                            <option value="latest" @selected(request('sort') == 'latest')>Terbaru</option>
                            <option value="price_asc" @selected(request('sort') == 'price_asc')>Harga Terendah</option>
                            <option value="price_desc" @selected(request('sort') == 'price_desc')>Harga Tertinggi</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($vehicles as $vehicle)
                        <x-public.vehicle-card :vehicle="$vehicle" />
                    @empty
                        <div class="sm:col-span-2 lg:col-span-3 text-center py-12">
                            <p class="text-lg text-gray-500">Tidak ada mobil yang cocok dengan kriteria Anda.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $vehicles->links() }}
                </div>
            </main>
        </div>
    </div>
</x-public-layout>