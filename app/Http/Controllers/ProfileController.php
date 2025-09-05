<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan form profil pengguna berdasarkan perannya.
     */
    public function edit(Request $request): View
    {
        // Periksa peran pengguna yang sedang login
        if ($request->user()->role === 'admin' || $request->user()->role === 'staff') {
            // Jika admin atau staff, tampilkan view profil admin
            // yang menggunakan layout admin panel.
            return view('admin.profile.edit', [
                'user' => $request->user(),
            ]);
        }

        // Jika bukan (adalah pelanggan), tampilkan view profil standar
        // yang menggunakan layout aplikasi biasa.
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Arahkan kembali ke route profil yang benar berdasarkan peran
        if ($request->user()->role === 'admin' || $request->user()->role === 'staff') {
            return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Menghapus akun pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
