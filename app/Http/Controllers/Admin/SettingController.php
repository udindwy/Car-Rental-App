<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman form pengaturan situs.
     */
    public function index()
    {
        // Mengambil baris data pengaturan pertama.
        // Jika tabel kosong, firstOrCreate akan membuat baris baru secara otomatis.
        // Ini mencegah error pada instalasi baru.
        $settings = Setting::firstOrCreate([]);

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Memperbarui data pengaturan situs.
     */
    public function update(Request $request)
    {
        $settings = Setting::first();

        // Validasi semua input dari form
        $request->validate([
            'site_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048', // Validasi file logo
            'theme_color' => 'required|string|max:7', // Validasi kode hex
            'whatsapp' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
        ]);

        // Ambil semua data kecuali file logo
        $data = $request->except('logo');

        // Proses unggahan file logo jika ada
        if ($request->hasFile('logo')) {
            // Hapus logo lama dari storage jika ada
            if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }
            // Simpan logo baru di folder 'public/logos' dan dapatkan path-nya
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Perbarui data di database
        $settings->update($data);

        return redirect()->back()->with('success', 'Pengaturan situs berhasil diperbarui.');
    }
}
