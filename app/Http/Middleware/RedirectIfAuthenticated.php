<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    return redirect()->route('admin.dashboard');
                }

                if ($user->hasRole('user')) {
                    return redirect()->route('user.dashboard');
                }

                // Default redirect if role doesn't match
                return redirect('/');
            }
        }

        return $next($request);
    }
}
