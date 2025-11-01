<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $timezone = Session::get('timezone');

        if (!$timezone && Auth::check() && Auth::user()) {
            $timezone = Auth::user()->timezone ?? null;
        }

        if (!$timezone) {
            $timezone = config('i18n.default_timezone', 'Asia/Jakarta');
        }

        // Validate timezone
        try {
            new \DateTimeZone($timezone);
            date_default_timezone_set($timezone);
            Session::put('timezone', $timezone);
        } catch (\Exception $e) {
            // Use default if invalid
            date_default_timezone_set(config('i18n.default_timezone', 'Asia/Jakarta'));
        }

        return $next($request);
    }
}
