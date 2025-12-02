<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use App\Enums\UserRole;

class BookingPolicy
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
        return $user->hasRole(UserRole::USER->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
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
    public function update(User $user, Booking $booking): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Booking $booking): bool
    {
        return false;
    }
}
