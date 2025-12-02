<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use App\Services\NavigationService;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.panel.sidebar', function ($view) {
            $menu = [];
            if (Auth::check()) {
                // Ensure the user model has the 'role' attribute and it's an enum
                $userRole = Auth::user()->role; 
                $menu = (new NavigationService())->getFilteredMenuForRole($userRole);
            }
            $view->with('menu', $menu);
        });
    }
}
