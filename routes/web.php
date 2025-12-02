<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Http\Middleware\EnsureUserHasRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', HomePage::class)->name('home');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // USER Routes
    Route::prefix('user')
        ->name('user.')
        ->middleware('role:user')
        ->group(function () {
            Route::get('/dashboard', \App\Livewire\User\DashboardPage::class)->name('dashboard');
            Route::get('/wishlist', \App\Livewire\User\WishlistPage::class)->name('wishlist.index');
            Route::get('/bookings/{booking}', \App\Livewire\User\Bookings\ViewBookingPage::class)->name('bookings.show');
            Route::get('/profile', \App\Livewire\User\ProfilePage::class)->name('profile.show');
            // Define other user-specific routes here
            Route::get('/bookings', \App\Livewire\User\Bookings\MyBookingsPage::class)->name('bookings.index');
            Route::get('/inquiries', \App\Livewire\User\Inquiries\InquiryHistoryPage::class)->name('inquiries.index');
        });

    // ADMIN Routes
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:admin')
        ->group(function () {
            Route::get('/dashboard', \App\Livewire\Admin\DashboardPage::class)->name('dashboard');
            Route::get('/riwayat', \App\Livewire\Admin\Riwayat::class)->name('riwayat');
            Route::get('/packages', \App\Livewire\Admin\Packages\ManagePackages::class)->name('packages.index');
            Route::get('/inquiries', \App\Livewire\Admin\Inquiries\ManageInquiries::class)->name('inquiries.index');
            Route::get('/users', \App\Livewire\Admin\Users\ManageUsers::class)->name('users.index');

            // Posts Management
            Route::prefix('posts')->name('posts.')->group(function () {
                Route::get('/', \App\Livewire\Admin\Posts\ManagePosts::class)->name('index');
                Route::get('/create', \App\Livewire\Admin\Posts\PostForm::class)->name('create');
                Route::get('/{post}/edit', \App\Livewire\Admin\Posts\PostForm::class)->name('edit');
            });

            // Bookings Management
            Route::get('/bookings', \App\Livewire\Admin\Bookings\ManageBookings::class)->name('bookings.index');

            // Testimonials Management
            Route::get('/testimonials', \App\Livewire\Admin\Testimonials\ManageTestimonials::class)->name('testimonials.index');

            // Define other admin-specific routes here

        });
});
