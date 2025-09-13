<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin dan Staf bisa melihat daftar ulasan
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Review $review): bool
    {
        // Admin dan Staf bisa memoderasi (mengubah) ulasan
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Review $review): bool
    {
        // HANYA Admin yang bisa menghapus ulasan
        return $user->role === 'admin';
    }
}