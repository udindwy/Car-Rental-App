<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Extra;
use App\Models\Branch;
use App\Models\Feature;
use App\Models\Vehicle;
use App\Models\Category;
use App\Models\PricingRule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VehicleBlackout;
use App\Exports\BlackoutsExport;
use App\Imports\BlackoutsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreVehicleRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VehicleController extends Controller
{
    use AuthorizesRequests;
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
        $extras = Extra::all();

        return view('admin.vehicles.create', compact('branches', 'brands', 'categories', 'features', 'extras'));
    }

    /**
     * Menyimpan kendaraan baru ke database.
     */
    public function store(StoreVehicleRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']) . '-' . time();

        // 1. Buat record mobil baru
        $vehicle = Vehicle::create($data);

        // 2. Gunakan sync untuk melampirkan fitur dan extras. Ini lebih konsisten.
        $vehicle->features()->sync($request->input('features', []));
        $vehicle->extras()->sync($request->input('extras', [])); // <-- DITAMBAHKAN

        // 3. Unggah dan simpan gambar galeri
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $path = $image->store('vehicles', 'public');
                $vehicle->images()->create([
                    'path' => $path,
                    'is_primary' => $key === 0,
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
        // Eager load semua relasi yang dibutuhkan oleh form
        $vehicle->load('features', 'images', 'extras'); // <-- 'extras' DITAMBAHKAN

        $branches = Branch::all();
        $brands = Brand::all();
        $categories = Category::all();
        $features = Feature::all();
        $extras = Extra::all();

        return view('admin.vehicles.edit', compact('vehicle', 'branches', 'brands', 'categories', 'features', 'extras'));
    }

    /**
     * Memperbarui data kendaraan di database.
     */
    public function update(StoreVehicleRequest $request, Vehicle $vehicle)
    {
        $data = $request->validated();

        // 1. Update data utama mobil
        $vehicle->update($data);

        // 2. Sinkronisasi relasi fitur dan extras
        $vehicle->features()->sync($request->input('features', []));
        $vehicle->extras()->sync($request->input('extras', [])); // <-- DITAMBAHKAN

        // 3. Tambahkan gambar baru jika ada
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
        foreach ($vehicle->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Data mobil berhasil dihapus.');
    }

    // --- METHOD LAINNYA (TIDAK ADA PERUBAHAN) ---

    public function pricing(Vehicle $vehicle)
    {
        $rules = $vehicle->pricingRules()->get();
        return view('admin.vehicles.pricing', compact('vehicle', 'rules'));
    }

    public function storePricing(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'type' => 'required|in:long_rent,date_range,weekend',
            'percent_adjustment' => 'required|numeric',
            'min_days' => 'nullable|required_if:type,long_rent|integer|min:2',
            'start_date' => 'nullable|required_if:type,date_range|date',
            'end_date' => 'nullable|required_if:type,date_range|date|after_or_equal:start_date',
        ]);
        $vehicle->pricingRules()->create($request->all());
        return redirect()->back()->with('success', 'Aturan harga baru berhasil ditambahkan.');
    }

    public function destroyPricing(PricingRule $rule)
    {
        $rule->delete();
        return redirect()->back()->with('success', 'Aturan harga berhasil dihapus.');
    }

    public function availability(Vehicle $vehicle)
    {
        $blackouts = $vehicle->blackouts()->latest()->get();
        return view('admin.vehicles.availability', compact('vehicle', 'blackouts'));
    }

    public function storeBlackout(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'reason' => 'nullable|string|max:255',
        ]);
        $vehicle->blackouts()->create($request->all());
        return redirect()->back()->with('success', 'Tanggal berhasil diblokir.');
    }

    public function destroyBlackout(VehicleBlackout $blackout)
    {
        $blackout->delete();
        return redirect()->back()->with('success', 'Blokir tanggal berhasil dihapus.');
    }

    public function exportBlackouts()
    {
        return Excel::download(new BlackoutsExport, 'daftar-jadwal-blokir.csv');
    }

    public function showImportForm()
    {
        return view('admin.vehicles.import');
    }

    public function importBlackouts(Request $request)
    {
        $request->validate(['file' => 'required|mimes:csv,txt']);
        try {
            Excel::import(new BlackoutsImport, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return redirect()->back()->with('import_errors', $e->failures());
        }
        return redirect()->back()->with('success', 'Data jadwal berhasil diimpor.');
    }

    public function updateStatus(Request $request, Vehicle $vehicle)
    {
        $this->authorize('updateStatus', $vehicle);

        // Diubah: Validasi disesuaikan dengan nilai enum di database
        $validated = $request->validate([
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        $vehicle->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Status mobil berhasil diperbarui.');
    }
}
