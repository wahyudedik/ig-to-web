<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priority: 1. Query parameter, 2. Session, 3. User preference, 4. Browser, 5. Default
        $locale = $request->query('lang');

        if (!$locale) {
            $locale = Session::get('locale');
        }

        if (!$locale && Auth::check() && Auth::user()) {
            $locale = Auth::user()->locale ?? null;
        }

        if (!$locale) {
            $locale = $request->getPreferredLanguage(['en', 'id', 'ar']);
            if (!in_array($locale, ['en', 'id', 'ar'])) {
                $locale = substr($locale, 0, 2);
            }
        }

        // Fallback to default if locale not supported
        $availableLocales = array_keys(config('i18n.locales', []));
        if (!in_array($locale, $availableLocales)) {
            $locale = config('i18n.default_locale', 'id');
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}
