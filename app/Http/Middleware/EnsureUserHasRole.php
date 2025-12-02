<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        if (!$user->hasRole($role)) {
            return match ($user->role) {
                \App\Enums\UserRole::ADMIN->value => redirect()->route('admin.dashboard'),
                \App\Enums\UserRole::USER->value => redirect()->route('user.dashboard'),
                default => abort(403, 'Unauthorized.'),
            };
        }

        return $next($request);
    }
}
