<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

// Correct Imports for SPA-Livewire architecture
use App\Http\Responses\LivewireViewResponse;
use App\Http\Responses\LoginResponse;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\LoginViewResponse as LoginViewResponseContract;
use Laravel\Fortify\Contracts\RegisterViewResponse as RegisterViewResponseContract;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // This service provider is automatically discovered by Laravel.
        // We bind the contracts to our custom implementations here.

        // For showing the login/register pages via Livewire
        $this->app->singleton(LoginViewResponseContract::class, fn() => new LivewireViewResponse(LoginPage::class));
        $this->app->singleton(RegisterViewResponseContract::class, fn() => new LivewireViewResponse(RegisterPage::class));

        // For handling the response after a successful login (with toast)
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        // NOTE: We no longer need Fortify::loginView() and Fortify::registerView()
        // because we are using the contract binding approach in the register() method,
        // which is the correct way for this architecture.

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email . $request->ip());
        });
    }
}
