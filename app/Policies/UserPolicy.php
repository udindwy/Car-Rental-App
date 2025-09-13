<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Izinkan admin melakukan aksi apa pun.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    /**
     * Tentukan apakah user bisa melihat daftar user lain.
     * Staff tidak bisa.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Tentukan apakah user bisa melihat detail user lain.
     * Staff tidak bisa.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Tentukan apakah user bisa membuat user baru.
     * Staff tidak bisa.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Tentukan apakah user bisa mengedit user lain.
     * Staff tidak bisa.
     */
    public function update(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Tentukan apakah user bisa menghapus user lain.
     * Staff tidak bisa.
     */
    public function delete(User $user, User $model): bool
    {
        return false;
    }
}
