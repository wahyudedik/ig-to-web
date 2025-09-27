<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Superadmin bypass all permissions
        if ($user->user_type === 'superadmin') {
            return $next($request);
        }

        // Check if user has permission using Spatie
        if (!$user->hasPermissionTo($permission)) {
            abort(403, 'Insufficient permissions.');
        }

        return $next($request);
    }
}
