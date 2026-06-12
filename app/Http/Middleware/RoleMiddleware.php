<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $allowedRoles = explode('|', $roles);

        if (!in_array(Auth::user()->role, $allowedRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
