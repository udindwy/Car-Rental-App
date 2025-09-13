<?php

namespace App\Policies;

use App\Models\Availability;
use App\Models\User;

class AvailabilityPolicy
{
    // Staf & Admin bisa melihat jadwal yang diblokir
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff']);
    }

    // Staf & Admin bisa membuat jadwal blokir baru
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff']);
    }

    // Staf & Admin bisa menghapus jadwal blokir
    public function delete(User $user, Availability $availability): bool
    {
        return in_array($user->role, ['admin', 'staff']);
    }
}
