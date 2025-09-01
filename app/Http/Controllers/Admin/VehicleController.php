<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Feature;
use App\Http\Requests\StoreVehicleRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleController extends Controller
{
    /**
     * Menampilkan daftar semua kendaraan.
     */
    public function index()
    {
        $vehicles = Vehicle::with('brand', 'category')->latest()->paginate(10);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Menampilkan form untuk membuat kendaraan baru.
     */
    public function create()
    {
        $branches = Branch::all();
        $brands = Brand::all();
        $categories = Category::all();
        $features = Feature::all();
        return view('admin.vehicles.create', compact('branches', 'brands', 'categories', 'features'));
    }

    /**
     * Menyimpan kendaraan baru ke database.
     */
    public function store(StoreVehicleRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']) . '-' . time();

        $vehicle = Vehicle::create($data);

        // Simpan relasi fitur (many-to-many)
        if ($request->has('features')) {
            $vehicle->features()->attach($request->features);
        }

        // Unggah dan simpan gambar galeri
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $path = $image->store('vehicles', 'public');
                $vehicle->images()->create([
                    'path' => $path,
                    'is_primary' => $key === 0, // Set gambar pertama sebagai primary
                ]);
            }
        }

        return redirect()->route('admin.vehicles.index')->with('success', 'Mobil baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit kendaraan.
     */
    public function edit(Vehicle $vehicle)
    {
        $vehicle->load('features', 'images'); // Eager load relasi
        $branches = Branch::all();
        $brands = Brand::all();
        $categories = Category::all();
        $features = Feature::all();
        return view('admin.vehicles.edit', compact('vehicle', 'branches', 'brands', 'categories', 'features'));
    }

    /**
     * Memperbarui data kendaraan di database.
     */
    public function update(StoreVehicleRequest $request, Vehicle $vehicle)
    {
        $data = $request->validated();

        $vehicle->update($data);

        // Sinkronisasi relasi fitur (menambah yang baru, menghapus yang tidak dipilih)
        $vehicle->features()->sync($request->features ?? []);

        // Tambahkan gambar baru jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('vehicles', 'public');
                $vehicle->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.vehicles.index')->with('success', 'Data mobil berhasil diperbarui.');
    }

    /**
     * Menghapus data kendaraan dari database.
     */
    public function destroy(Vehicle $vehicle)
    {
        // Hapus semua file gambar terkait dari storage
        foreach ($vehicle->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $vehicle->delete(); // Hapus record dari database
        return redirect()->route('admin.vehicles.index')->with('success', 'Data mobil berhasil dihapus.');
    }
}
