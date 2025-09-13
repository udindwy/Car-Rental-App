<?php

namespace App\Policies;

use App\Models\User;

class ReportPolicy
{
    /**
     * Izinkan user untuk melihat halaman laporan utama.
     */
    public function viewAny(User $user): bool
    {
        // Admin dan Staf bisa melihat halaman laporan
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Izinkan user untuk mengekspor laporan pendapatan.
     */
    public function exportRevenue(User $user): bool
    {
        // HANYA Admin yang bisa ekspor laporan pendapatan
        return $user->role === 'admin';
    }

    /**
     * Izinkan user untuk mengekspor laporan pemesanan.
     */
    public function exportBookings(User $user): bool
    {
        // Admin dan Staf bisa ekspor laporan pemesanan
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Izinkan user untuk mengekspor laporan okupansi.
     */
    public function exportOccupancy(User $user): bool
    {
        // Admin dan Staf bisa ekspor laporan okupansi
        return in_array($user->role, ['admin', 'staff']);
    }
}
