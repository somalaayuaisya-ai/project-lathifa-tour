<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Enums\UserRole;

class PostPolicy
{
    /**
     * Grant all abilities to admins.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole(UserRole::ADMIN->value)) {
            return true;
        }

        return null;
    }

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
    public function view(User $user, Post $post): bool
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
    public function update(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return false;
    }
}
