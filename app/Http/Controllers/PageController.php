<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageVersion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource (public view).
     */
    public function index(Request $request)
    {
        $query = Page::published()->with('user');

        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $query->where('category', $request->category);
        }

        // Search by title
        if ($request->has('search') && $request->search !== '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $pages = $query->paginate(15);
        $categories = Page::distinct()->pluck('category')->filter();
        $statuses = ['published', 'draft', 'archived'];

        return view('pages.index', compact('pages', 'categories', 'statuses'));
    }

    /**
     * Display admin listing of pages (superadmin only).
     */
    public function admin(Request $request)
    {
        // Middleware will handle authorization

        $query = Page::with('user');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $query->where('category', $request->category);
        }

        // Search by title
        if ($request->has('search') && $request->search !== '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $pages = $query->paginate(15);
        $categories = Page::distinct()->pluck('category')->filter();
        $statuses = ['draft', 'published', 'archived'];

        return view('pages.admin', compact('pages', 'categories', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Middleware will handle authorization

        $templates = $this->getAvailableTemplates();
        $categories = Page::distinct()->pluck('category')->filter();
        $parentPages = Page::whereNull('parent_id')->where('is_menu', true)->get();

        return view('pages.create', compact('templates', 'categories', 'parentPages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'template' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'seo_title' => 'nullable|string|max:60',
            'seo_description' => 'nullable|string|max:160',
            'seo_keywords' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($request->title);

        // ✅ Fix: Ensure is_featured has a default value
        $data['is_featured'] = $request->boolean('is_featured', false);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('pages/images', 'public');
        }

        // Handle SEO meta
        $data['seo_meta'] = [
            'title' => $request->seo_title,
            'description' => $request->seo_description,
            'keywords' => $request->seo_keywords,
        ];

        // Set published_at if status is published
        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        $page = Page::create($data);

        // Create initial version
        PageVersion::createFromPage($page, 'Initial version');

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        // Check if page is published or user has permission
        $user = Auth::user();
        if (!$page->isPublished() && (!$user || $user->user_type !== 'superadmin')) {
            abort(403, 'Page not found or not published.');
        }

        return view('pages.show', compact('page'));
    }

    /**
     * Get menu data for header/footer.
     */
    public function getMenus()
    {
        $headerMenus = Page::menu()
            ->menuPosition('header')
            ->mainMenu()
            ->orderBy('menu_sort_order')
            ->with('children')
            ->get();

        $footerMenus = Page::menu()
            ->menuPosition('footer')
            ->mainMenu()
            ->orderBy('menu_sort_order')
            ->with('children')
            ->get();

        return [
            'header' => $headerMenus,
            'footer' => $footerMenus
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        $templates = $this->getAvailableTemplates();
        $categories = Page::distinct()->pluck('category')->filter();

        return view('pages.edit', compact('page', 'templates', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'template' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'seo_title' => 'nullable|string|max:60',
            'seo_description' => 'nullable|string|max:160',
            'seo_keywords' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('pages/images', 'public');
        }

        // Handle SEO meta
        $data['seo_meta'] = [
            'title' => $request->seo_title,
            'description' => $request->seo_description,
            'keywords' => $request->seo_keywords,
        ];

        // Set published_at if status is published
        if ($request->status === 'published' && $page->status !== 'published') {
            $data['published_at'] = now();
        }

        $page->update($data);

        // Create new version if there are changes
        if ($page->wasChanged()) {
            PageVersion::createFromPage($page, $request->change_summary ?? 'Page updated');
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        // Delete featured image
        if ($page->featured_image) {
            Storage::disk('public')->delete($page->featured_image);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    /**
     * Publish a page.
     */
    public function publish(Page $page)
    {
        $page->publish();

        return redirect()->back()
            ->with('success', 'Page published successfully.');
    }

    /**
     * Unpublish a page.
     */
    public function unpublish(Page $page)
    {
        $page->unpublish();

        return redirect()->back()
            ->with('success', 'Page unpublished successfully.');
    }

    /**
     * Duplicate a page.
     */
    public function duplicate(Page $page)
    {
        $newPage = $page->replicate();
        $newPage->title = $page->title . ' (Copy)';
        $newPage->slug = Str::slug($newPage->title);
        $newPage->status = 'draft';
        $newPage->published_at = null;
        $newPage->save();

        return redirect()->route('admin.pages.edit', $newPage)
            ->with('success', 'Page duplicated successfully.');
    }

    /**
     * Show page versions.
     */
    public function versions(Page $page)
    {
        $versions = $page->versions()->with('user')->latest()->paginate(10);
        return view('pages.versions', compact('page', 'versions'));
    }

    /**
     * Restore a specific version.
     */
    public function restoreVersion(Page $page, PageVersion $version)
    {
        $version->restoreToPage();

        return redirect()->route('admin.pages.show', $page)
            ->with('success', "Page restored to version {$version->version_number}.");
    }

    /**
     * Compare two versions.
     */
    public function compareVersions(Page $page, PageVersion $version1, PageVersion $version2)
    {
        return view('pages.compare', compact('page', 'version1', 'version2'));
    }

    /**
     * Get available templates.
     */
    private function getAvailableTemplates()
    {
        return [
            'default' => 'Default Template',
            'landing' => 'Landing Page',
            'blog' => 'Blog Post',
            'about' => 'About Page',
            'contact' => 'Contact Page',
            'gallery' => 'Gallery Page',
        ];
    }
}
