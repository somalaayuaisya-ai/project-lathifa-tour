<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\Package;

use App\Policies\PostPolicy;
use App\Policies\UserPolicy;

use App\Models\PackageInquiry;
use App\Policies\PackagePolicy;
use App\Policies\PackageInquiryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App
\Models\Testimonial;
use App\Policies\TestimonialPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Package::class => PackagePolicy::class,
        PackageInquiry::class => PackageInquiryPolicy::class,
        User::class => UserPolicy::class,
        Post::class => PostPolicy::class,
        Booking::class => BookingPolicy::class,
        Testimonial::class => TestimonialPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
