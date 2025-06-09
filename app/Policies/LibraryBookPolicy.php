<?php

namespace App\Policies;

use App\Models\library\LibraryBook;
use App\Models\User;

class LibraryBookPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, LibraryBook $libraryBook): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LibraryBook $libraryBook): bool
    {
        return $user->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LibraryBook $libraryBook): bool
    {
        return $user->exists();
    }

}
