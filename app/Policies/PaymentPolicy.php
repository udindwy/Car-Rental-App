<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Izinkan admin dan staff untuk melihat daftar pembayaran
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Payment $payment): bool
    {
        // Izinkan admin dan staff untuk melihat detail pembayaran
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Izinkan admin dan staff untuk mencatat pembayaran baru
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Payment $payment): bool
    {
        // Izinkan admin dan staff untuk mengubah data pembayaran
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Payment $payment): bool
    {
        // Izinkan admin dan staff untuk menghapus data pembayaran
        return in_array($user->role, ['admin', 'staff']);
    }
}
