<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Superadmin bypass all role checks
        if ($user->user_type === 'superadmin' || $user->hasRole('superadmin')) {
            return $next($request);
        }

        // Support multiple roles separated by |
        $allowedRoles = explode('|', $role);

        // Check both user_type (for backward compatibility) and Spatie roles (for custom roles)
        $hasAccess = false;

        // First check user_type (backward compatibility)
        if (in_array($user->user_type, $allowedRoles)) {
            $hasAccess = true;
        }

        // Also check Spatie roles (supports custom roles like 'osis', 'bendahara', etc.)
        foreach ($allowedRoles as $allowedRole) {
            if ($user->hasRole(trim($allowedRole))) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
