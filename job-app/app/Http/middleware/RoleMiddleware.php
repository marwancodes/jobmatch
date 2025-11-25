<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if has no access
        if (Auth::check()) {
            $role = auth::user()->role;
            $hasAccess = in_array($role, $roles);

            if (!$hasAccess) {
                abort(403, 'Unauthorized action.');
            }
        }

        // Has access
        return $next($request);
    }
}
