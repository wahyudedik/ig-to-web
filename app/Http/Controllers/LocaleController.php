<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class LocaleController extends Controller
{
    /**
     * Switch application locale
     */
    public function switchLocale(Request $request, string $locale)
    {
        $availableLocales = array_keys(config('i18n.locales', []));

        if (!in_array($locale, $availableLocales)) {
            return redirect()->back()->with('error', __('common.invalid'));
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        // Update user preference if logged in
        if (Auth::check() && ($user = Auth::user()) && $user instanceof User) {
            try {
                $user->update(['locale' => $locale]);
            } catch (\Exception $e) {
                // Silently fail if field doesn't exist (migration not run yet)
                Log::warning('Failed to update user locale: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', __('common.updated_successfully'));
    }

    /**
     * Switch currency
     */
    public function switchCurrency(Request $request, string $currency)
    {
        $availableCurrencies = array_keys(config('i18n.currencies', []));

        if (!in_array($currency, $availableCurrencies)) {
            return redirect()->back()->with('error', __('common.invalid'));
        }

        Session::put('currency', $currency);

        // Update user preference if logged in
        if (Auth::check() && ($user = Auth::user()) && $user instanceof User) {
            try {
                $user->update(['currency' => $currency]);
            } catch (\Exception $e) {
                // Silently fail if field doesn't exist (migration not run yet)
                Log::warning('Failed to update user currency: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', __('common.updated_successfully'));
    }

    /**
     * Switch timezone
     */
    public function switchTimezone(Request $request)
    {
        $request->validate([
            'timezone' => 'required|string',
        ]);

        $timezone = $request->input('timezone');

        // Validate timezone
        try {
            new \DateTimeZone($timezone);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('common.invalid'));
        }

        Session::put('timezone', $timezone);

        // Update user preference if logged in
        if (Auth::check() && ($user = Auth::user()) && $user instanceof User) {
            try {
                $user->update(['timezone' => $timezone]);
            } catch (\Exception $e) {
                // Silently fail if field doesn't exist (migration not run yet)
                Log::warning('Failed to update user timezone: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', __('common.updated_successfully'));
    }
}
