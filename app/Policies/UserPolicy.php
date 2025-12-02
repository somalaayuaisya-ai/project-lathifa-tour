<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserRole;

class UserPolicy
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
        return false; // Only admins are allowed by the 'before' method
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
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
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     * Prevent admin from deleting their own account.
     */
    public function delete(User $user, User $model): bool
    {
        // Admin can't delete their own account
        if ($user->is($model)) {
            return false;
        }

        return $user->hasRole(UserRole::ADMIN->value);
    }
}
