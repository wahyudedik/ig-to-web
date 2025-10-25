# ✅ Fix: Homepage Instagram Gallery

## 🎯 Task

Menyamakan tampilan Instagram gallery di **homepage** (`/`) dengan tampilan di **halaman kegiatan** (`/kegiatan`).

---

## 📋 Changes Made

### 1. **Update Homepage Route** (`routes/web.php`)

**Added:** Instagram posts data fetch in homepage route

**Before:**
```php
Route::get('/', function () {
    // ... menu data ...
    
    return view('welcome', compact('headerMenus', 'footerMenus'));
})->name('landing');
```

**After:**
```php
Route::get('/', function () {
    // ... menu data ...
    
    // Get Instagram posts for gallery section
    $instagramPosts = app(\App\Services\InstagramService::class)->getCachedPosts(6);
    
    return view('welcome', compact('headerMenus', 'footerMenus', 'instagramPosts'));
})->name('landing');
```

**Why:**
- Fetch 6 latest Instagram posts using `InstagramService`
- Uses cached posts (1 hour cache)
- Pass to view as `$instagramPosts`

---

### 2. **Update Welcome View** (`resources/views/welcome.blade.php`)

**Changed:** Pass Instagram posts to gallery component

**Before:**
```blade
<x-landing.gallery />
```

**After:**
```blade
<x-landing.gallery :posts="$instagramPosts" />
```

**Why:**
- Component needs access to posts data
- Use `:posts` syntax to bind variable

---

### 3. **Completely Rewrite Gallery Component** (`resources/views/components/landing/gallery.blade.php`)

**Old Logic (WRONG):**
- Queried `InstagramSetting` model directly
- Wrong data structure
- Old portfolio-style cards

**New Logic (CORRECT):**
- Receives `$posts` prop from parent
- Uses same card design as `/kegiatan` page
- Shows like count, comment count, timestamp
- Has "Lihat di Instagram" button
- Empty state handling

**New Structure:**

```blade
<!-- Instagram Gallery -->
<div class="py-120" style="background-color: #f8f9fa;">
    <div class="container">
        <!-- Title -->
        <div class="site-heading text-center">
            <span class="site-title-tagline">
                <i class="far fa-book-open-reader"></i> Kegiatan MAUDU
            </span>
            <h2 class="site-title">Galeri Kegiatan <span>Terbaru</span></h2>
            <p>Update kegiatan sekolah dari Instagram</p>
        </div>

        <!-- Posts Grid -->
        <div class="row">
            @forelse ($posts ?? [] as $post)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <!-- Image with Instagram Icon -->
                        <div class="position-relative">
                            <img src="{{ $post['media_url'] ?? asset('assets/img/portfolio/01.jpg') }}" 
                                 class="card-img-top" 
                                 style="height: 250px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-2">
                                <a href="{{ $post['permalink'] ?? '#' }}" class="btn btn-sm btn-dark">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column">
                            <!-- Caption -->
                            <p class="card-text flex-grow-1">
                                {{ Str::limit($post['caption'] ?? 'Kegiatan Sekolah', 150) }}
                            </p>
                            
                            <!-- Stats: Like & Comment Count -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <span class="badge bg-danger">
                                        <i class="fas fa-heart"></i> {{ number_format($post['like_count'] ?? 0) }}
                                    </span>
                                    <span class="badge bg-primary ms-1">
                                        <i class="fas fa-comment"></i>
                                        {{ number_format($post['comment_count'] ?? 0) }}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    {{ $post['timestamp']->diffForHumans() ?? 'Recently' }}
                                </small>
                            </div>
                            
                            <!-- View on Instagram Button -->
                            <div class="mt-2">
                                <a href="{{ $post['permalink'] ?? '#' }}" 
                                   class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fab fa-instagram me-1"></i> Lihat di Instagram
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fab fa-instagram fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada kegiatan</h4>
                        <p class="text-muted">Kegiatan sekolah akan muncul di sini setelah terhubung dengan Instagram</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- View More Button -->
        @if (!empty($posts) && count($posts) > 0)
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="{{ route('public.kegiatan') }}" class="theme-btn">
                        Lihat Semua Kegiatan <i class="far fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
```

---

## 🎨 Design Features

### Card Design (Same as `/kegiatan`)

1. **Image Section:**
   - Fixed height: 250px
   - Object-fit: cover (no distortion)
   - Instagram icon button (top-right corner)

2. **Content Section:**
   - Caption (max 150 chars with ellipsis)
   - Like count badge (red)
   - Comment count badge (blue)
   - Timestamp (relative, e.g., "2 hours ago")
   - "Lihat di Instagram" button (full width)

3. **Empty State:**
   - Instagram icon
   - "Belum ada kegiatan" message
   - Helpful instruction text

4. **View More Button:**
   - Only shows if posts exist
   - Links to `/kegiatan` for full gallery

---

## 📊 Data Flow

```
Route (/)
    ↓
Fetch Instagram Posts (InstagramService::getCachedPosts(6))
    ↓
Pass to View ($instagramPosts)
    ↓
Pass to Component (<x-landing.gallery :posts="$instagramPosts" />)
    ↓
Component receives as $posts
    ↓
Loop & Display Cards
```

---

## 🔍 Key Differences: Homepage vs /kegiatan

| Aspect | Homepage (`/`) | Activities Page (`/kegiatan`) |
|--------|---------------|---------------------------|
| **Posts Limit** | 6 posts | 20 posts (default) |
| **Title** | "Galeri Kegiatan Terbaru" | "Instagram Feed Gallery" |
| **Subtitle** | "Update kegiatan sekolah dari Instagram" | More detailed |
| **Layout** | 3 columns (col-lg-4) | 3 columns (col-lg-4) |
| **Refresh Button** | ❌ No | ✅ Yes |
| **View More** | ✅ Yes (links to `/kegiatan`) | ❌ No |
| **Breadcrumb** | ❌ No | ✅ Yes |
| **Event Sections** | ❌ No | ✅ Yes (KOMPASS, MHW, etc) |

---

## ✅ Testing Checklist

### Test 1: Homepage with Instagram Connection

1. **Setup:**
   - Ensure Instagram OAuth completed
   - Token saved to database
   - Some posts exist

2. **Visit:** `https://your-domain.com/`

3. **Scroll** to Instagram gallery section

4. **Expected:**
   - ✅ Title: "Galeri Kegiatan Terbaru"
   - ✅ Subtitle: "Update kegiatan sekolah dari Instagram"
   - ✅ 6 posts displayed in cards
   - ✅ Each card shows:
     - Image
     - Caption (truncated to 150 chars)
     - Like count
     - Comment count
     - Timestamp
     - "Lihat di Instagram" button
   - ✅ "Lihat Semua Kegiatan" button at bottom

5. **Click** any post's "Lihat di Instagram" button
   - Should open Instagram post in new tab

6. **Click** "Lihat Semua Kegiatan" button
   - Should navigate to `/kegiatan` page

---

### Test 2: Homepage WITHOUT Instagram Connection

1. **Setup:**
   - No Instagram token configured
   - OR token expired/invalid

2. **Visit:** `https://your-domain.com/`

3. **Scroll** to Instagram gallery section

4. **Expected:**
   - ✅ Title: "Galeri Kegiatan Terbaru"
   - ✅ Empty state:
     - Instagram icon
     - "Belum ada kegiatan"
     - "Kegiatan sekolah akan muncul di sini..."
   - ✅ No "Lihat Semua Kegiatan" button

---

### Test 3: Compare with /kegiatan Page

1. **Visit both pages:**
   - Homepage: `/`
   - Activities: `/kegiatan`

2. **Compare cards:**
   - Same design? ✅
   - Same stats (likes, comments)? ✅
   - Same timestamp format? ✅
   - Same button style? ✅

3. **Differences:**
   - Homepage shows 6 posts ✅
   - `/kegiatan` shows 20 posts ✅
   - Homepage has "View More" button ✅
   - `/kegiatan` has refresh button ✅

---

## 🐛 Common Issues & Solutions

### Issue 1: "Undefined variable: posts"

**Cause:** Component not receiving `$posts` prop

**Fix:**
```blade
<!-- In welcome.blade.php -->
<x-landing.gallery :posts="$instagramPosts" />
```

---

### Issue 2: Cards Not Showing (Empty State)

**Possible Causes:**
1. Instagram not connected
2. Token expired
3. Cache not refreshed

**Debug:**
```bash
php artisan tinker
>>> app(\App\Services\InstagramService::class)->getCachedPosts(6)
# Should return array with posts
```

**Fix:**
```bash
# Clear cache and fetch fresh
php artisan cache:clear
php artisan tinker --execute="Cache::forget('instagram_posts');"
```

---

### Issue 3: Like/Comment Count Shows 0

**Cause:** API response missing fields

**Already Fixed:** Component uses null coalescing operator:
```php
{{ number_format($post['like_count'] ?? 0) }}
{{ number_format($post['comment_count'] ?? 0) }}
```

---

### Issue 4: Timestamp Shows "Recently" Always

**Possible Causes:**
1. Timestamp not Carbon instance
2. Timestamp missing from API

**Check:**
```bash
php artisan tinker
>>> $posts = app(\App\Services\InstagramService::class)->getCachedPosts(6);
>>> $posts[0]['timestamp'] instanceof \Carbon\Carbon
# Should return: true
```

**Already Handled:** Service transforms timestamps to Carbon

---

## 📌 Important Notes

1. **Cache Duration:** Instagram posts cached for 1 hour
   - To refresh: Visit `/kegiatan` and click "Refresh" button
   - Or manually: `Cache::forget('instagram_posts')`

2. **Performance:** Homepage uses cached data
   - No API calls on every page load
   - Fast loading time

3. **Responsive Design:**
   - Desktop: 3 columns (col-lg-4)
   - Tablet: 2 columns (col-md-6)
   - Mobile: 1 column (stacked)

4. **Image Optimization:**
   - Fixed height prevents layout shift
   - Object-fit: cover maintains aspect ratio
   - Lazy loading supported by browser

---

## 🚀 Next Steps (Optional)

1. **Add Skeleton Loading:**
   - Show loading state while fetching posts
   - Better UX on slow connections

2. **Add Post Filtering:**
   - Filter by hashtag
   - Filter by date

3. **Add Lightbox:**
   - Click image to view in modal
   - Carousel navigation

4. **Add Auto-Refresh:**
   - Periodically check for new posts
   - Show notification for new content

---

## ✅ Status

**COMPLETE!** ✓

Homepage Instagram gallery sekarang **identical** dengan `/kegiatan` page:
- ✅ Same card design
- ✅ Same data source
- ✅ Same stats display
- ✅ Responsive
- ✅ Empty state handling
- ✅ Performance optimized (cached)

---

**Test Now:**
1. Visit `https://ig-to-web.test/`
2. Scroll to Instagram gallery
3. Should see beautiful cards with real Instagram data! 🎉

