<?php

namespace App\Policies;

use App\Models\Komentar;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KomentarPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Komentar $komentar): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    /** Hanya pemilik yang boleh mengubah isi komentar. */
    public function update(User $user, Komentar $komentar): bool
    {
        return $user->id === $komentar->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    /** Pemilik boleh menghapus komentarnya; admin boleh menghapus komentar siapa pun (moderasi). */
    public function delete(User $user, Komentar $komentar): bool
    {
        return $user->id === $komentar->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Komentar $komentar): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Komentar $komentar): bool
    {
        return false;
    }
}
