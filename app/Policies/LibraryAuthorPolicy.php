<?php

namespace App\Policies;

use App\Models\library\LibraryAuthor;
use App\Models\User;

class LibraryAuthorPolicy
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
    public function view(?User $user, LibraryAuthor $libraryAuthor): bool
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
    public function update(User $user, LibraryAuthor $libraryAuthor): bool
    {
        return $user->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LibraryAuthor $libraryAuthor): bool
    {
        return $user->exists();
    }
}
