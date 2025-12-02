<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Testimonial;
use App\Models\User;

class TestimonialPolicy
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

    public function viewAny(User $user): bool { return false; }
    public function view(User $user, Testimonial $testimonial): bool { return false; }
    public function create(User $user): bool { return false; }
    public function update(User $user, Testimonial $testimonial): bool { return false; }
    public function delete(User $user, Testimonial $testimonial): bool { return false; }
}
