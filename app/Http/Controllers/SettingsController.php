<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display system settings page
     */
    public function index()
    {
        $kelasCount = DB::table('kelas')->count();
        $jurusanCount = DB::table('jurusan')->count();
        $ekstrakurikulerCount = DB::table('ekstrakurikuler')->count();
        $usersCount = DB::table('users')->count();

        return view('settings.index', compact('kelasCount', 'jurusanCount', 'ekstrakurikulerCount', 'usersCount'));
    }

    /**
     * Display data management page
     */
    public function dataManagement()
    {
        // Redirect to DataManagementController
        return app(DataManagementController::class)->index();
    }

    /**
     * Display kelas & jurusan management page
     */
    public function kelasJurusan()
    {
        $kelas = DB::table('kelas')->orderBy('nama')->get();
        $jurusan = DB::table('jurusan')->orderBy('nama')->get();

        return view('settings.kelas-jurusan', compact('kelas', 'jurusan'));
    }

    /**
     * Display landing page settings
     */
    public function landingPage()
    {
        $pages = Page::where('is_menu', true)->orderBy('menu_sort_order')->get();
        $headerMenus = Page::where('is_menu', true)
            ->where('menu_position', 'header')
            ->whereNull('parent_id')
            ->orderBy('menu_sort_order')
            ->get();
        $footerMenus = Page::where('is_menu', true)
            ->where('menu_position', 'footer')
            ->whereNull('parent_id')
            ->orderBy('menu_sort_order')
            ->get();

        return view('settings.landing-page', compact('pages', 'headerMenus', 'footerMenus'));
    }

    /**
     * Update landing page settings
     */
    public function updateLandingPage(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'site_keywords' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg|max:512',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'footer_text' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string',
        ]);

        // Update site settings (you can create a settings table or use config)
        $settings = [
            'site_name' => $request->site_name,
            'site_description' => $request->site_description,
            'site_keywords' => $request->site_keywords,
            'hero_title' => $request->hero_title,
            'hero_subtitle' => $request->hero_subtitle,
            'footer_text' => $request->footer_text,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_address' => $request->contact_address,
        ];

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('site-assets', 'public');
            $settings['logo'] = $logoPath;
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('site-assets', 'public');
            $settings['favicon'] = $faviconPath;
        }

        if ($request->hasFile('hero_images')) {
            $heroImagePaths = [];
            $uploadedImages = $request->file('hero_images');

            // Limit to maximum 5 images
            $maxImages = min(5, count($uploadedImages));

            for ($i = 0; $i < $maxImages; $i++) {
                $image = $uploadedImages[$i];
                if ($image && $image->isValid()) {
                    $heroImagePaths[] = $image->store('site-assets/hero', 'public');
                }
            }

            if (!empty($heroImagePaths)) {
                $settings['hero_images'] = json_encode($heroImagePaths);
            }
        }

        // Save settings to database or config file
        // For now, we'll store in a simple way
        foreach ($settings as $key => $value) {
            if ($value !== null) {
                // You can create a settings table or use cache/config
                cache()->put("site_setting_{$key}", $value);
            }
        }

        return redirect()->back()->with('success', 'Landing page settings updated successfully!');
    }

    /**
     * Display SEO settings
     */
    public function seoSettings()
    {
        $pages = Page::all();
        return view('settings.seo', compact('pages'));
    }

    /**
     * Update SEO settings
     */
    public function updateSeoSettings(Request $request)
    {
        $request->validate([
            'page_id' => 'required|exists:pages,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $page = Page::findOrFail($request->page_id);

        $page->update([
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
        ]);

        if ($request->hasFile('og_image')) {
            $ogImagePath = $request->file('og_image')->store('og-images', 'public');
            $page->update(['og_image' => $ogImagePath]);
        }

        return redirect()->back()->with('success', 'SEO settings updated successfully!');
    }

    /**
     * Reset landing page settings to default
     */
    public function resetLandingPage()
    {
        // Clear all site settings from cache
        $settings = [
            'site_name',
            'site_description',
            'site_keywords',
            'logo',
            'favicon',
            'hero_title',
            'hero_subtitle',
            'hero_images',
            'footer_text',
            'contact_email',
            'contact_phone',
            'contact_address'
        ];

        foreach ($settings as $setting) {
            cache()->forget("site_setting_{$setting}");
        }

        return redirect()->back()->with('success', 'Landing page settings have been reset to default values!');
    }
}
