<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'category',
        'template',
        'seo_meta',
        'custom_fields',
        'status',
        'is_featured',
        'is_menu',
        'menu_title',
        'menu_position',
        'parent_id',
        'menu_icon',
        'menu_url',
        'menu_target_blank',
        'menu_sort_order',
        'sort_order',
        'published_at',
        'user_id',
    ];

    protected $casts = [
        'seo_meta' => 'array',
        'custom_fields' => 'array',
        'is_featured' => 'boolean',
        'is_menu' => 'boolean',
        'menu_target_blank' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get the user that owns the page.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the page versions.
     */
    public function versions(): HasMany
    {
        return $this->hasMany(PageVersion::class);
    }

    /**
     * Get the parent page (for submenu).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    /**
     * Get the child pages (submenu).
     */
    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('menu_sort_order');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            if ($page->isDirty('title') && empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    /**
     * Scope to filter by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by category.
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to filter published pages.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope to filter featured pages.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to filter menu pages.
     */
    public function scopeMenu($query)
    {
        return $query->where('is_menu', true)->where('status', 'published');
    }

    /**
     * Scope to filter by menu position.
     */
    public function scopeMenuPosition($query, string $position)
    {
        return $query->where('menu_position', $position);
    }

    /**
     * Scope to get main menu items (no parent).
     */
    public function scopeMainMenu($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get submenu items.
     */
    public function scopeSubmenu($query, int $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

    /**
     * Get the page URL.
     */
    public function getUrlAttribute(): string
    {
        return route('public.pages.show', $this->slug);
    }

    /**
     * Get the menu URL (custom URL or page URL).
     */
    public function getMenuUrlAttribute(): string
    {
        if ($this->getRawOriginal('menu_url')) {
            return $this->getRawOriginal('menu_url');
        }

        return route('public.pages.show', $this->slug);
    }

    /**
     * Get the menu title (custom title or page title).
     */
    public function getMenuTitleAttribute($value): string
    {
        return $value ?: $this->title;
    }

    /**
     * Check if page is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' &&
            $this->published_at &&
            $this->published_at <= now();
    }

    /**
     * Publish the page.
     */
    public function publish(): void
    {
        $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    /**
     * Unpublish the page.
     */
    public function unpublish(): void
    {
        $this->update([
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
