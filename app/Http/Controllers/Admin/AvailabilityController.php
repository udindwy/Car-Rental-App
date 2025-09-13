<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\Availability;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AvailabilityController extends Controller
{
    use AuthorizesRequests;
    /**
     * Menampilkan halaman manajemen ketersediaan untuk mobil tertentu.
     */
    public function index(Vehicle $vehicle)
    {
        // Ambil semua jadwal ketersediaan untuk mobil ini, urutkan dari yang terbaru
        $availabilities = $vehicle->availabilities()->latest()->paginate(10);

        return view('admin.vehicles.availability', compact('vehicle', 'availabilities'));
    }

    /**
     * Menyimpan jadwal blokir baru.
     */
    public function store(Request $request, Vehicle $vehicle)
    {
        // Otorisasi: Hanya user yang berwenang yang bisa menambahkan
        $this->authorize('create', Availability::class);

        // Validasi input
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:255',
        ]);

        // Buat jadwal baru yang terhubung dengan mobil ini
        $vehicle->availabilities()->create($validated);

        return redirect()->back()->with('success', 'Jadwal blokir berhasil ditambahkan.');
    }

    /**
     * Menghapus jadwal blokir.
     */
    public function destroy(Availability $availability)
    {
        // Otorisasi: Hanya user yang berwenang yang bisa menghapus
        $this->authorize('delete', $availability);

        $availability->delete();

        return redirect()->back()->with('success', 'Jadwal blokir berhasil dihapus.');
    }
}
