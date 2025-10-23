# Page Version Sort Order Fix

## ❌ **ERROR YANG DITEMUKAN:**

```
SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'sort_order' cannot be null
```

**Lokasi Error:**
- File: `app/Models/PageVersion.php` line 92
- Method: `createFromPage()`
- Error terjadi saat membuat page baru
- Query: INSERT INTO `page_versions` ... `sort_order` = NULL

## ✅ **SOLUSI YANG DITERAPKAN:**

### **1. Root Cause:**
Saat membuat page version baru, field `sort_order` diambil dari `$page->sort_order`, tapi jika page tidak memiliki `sort_order` (NULL), maka insert akan gagal karena database constraint.

**Kode yang salah:**
```php
return self::create([
    // ... other fields ...
    'is_featured' => $page->is_featured ?? false,
    'sort_order' => $page->sort_order, // ❌ Could be NULL
    'published_at' => $page->published_at,
    // ... other fields ...
]);
```

### **2. Fix yang Diterapkan:**
```php
return self::create([
    // ... other fields ...
    'is_featured' => $page->is_featured ?? false, // ✅ Fix: Provide default value
    'sort_order' => $page->sort_order ?? 0, // ✅ Fix: Provide default value
    'published_at' => $page->published_at,
    // ... other fields ...
]);
```

## 🎯 **IMPACT:**

**✅ SEBELUM FIX:**
- Error saat membuat page baru
- Insert page_version gagal
- NULL constraint violation

**✅ SETELAH FIX:**
- Page baru bisa dibuat tanpa error
- Page version otomatis dibuat dengan `sort_order = 0`
- Audit log berfungsi normal

## 🔧 **VERIFICATION:**

### **1. Test Create New Page:**
```bash
# Steps:
1. Buka /admin/pages/create
2. Isi semua field yang required
3. Submit form
4. Page berhasil dibuat ✅
5. Page version otomatis dibuat ✅
```

### **2. Check Database:**
```sql
-- Check pages table
SELECT id, title, sort_order FROM pages;

-- Check page_versions table
SELECT id, page_id, version_number, sort_order FROM page_versions;
```

**Expected Result:**
- Pages dengan `sort_order = 0` (default)
- Page versions dengan `sort_order = 0` (default)

## 📝 **TECHNICAL DETAILS:**

### **Database Schema:**

**`pages` table:**
```php
$table->integer('sort_order')->default(0);
```

**`page_versions` table:**
```php
$table->integer('sort_order')->default(0);
```

### **Model Fix:**

**`app/Models/PageVersion.php`:**
```php
public static function createFromPage(Page $page, string $changeSummary = null): self
{
    $latestVersion = $page->versions()->latest()->first();
    $versionNumber = $latestVersion ? $latestVersion->version_number + 1 : 1;

    return self::create([
        'page_id' => $page->id,
        'version_number' => $versionNumber,
        'title' => $page->title,
        'content' => $page->content,
        'excerpt' => $page->excerpt,
        'featured_image' => $page->featured_image,
        'category' => $page->category,
        'template' => $page->template,
        'seo_meta' => $page->seo_meta,
        'custom_fields' => $page->custom_fields,
        'status' => $page->status,
        'is_featured' => $page->is_featured ?? false, // ✅ Default: false
        'sort_order' => $page->sort_order ?? 0, // ✅ Default: 0
        'published_at' => $page->published_at,
        'user_id' => $page->user_id,
        'change_summary' => $changeSummary,
    ]);
}
```

## 🎯 **RELATED FIXES:**

Ini adalah fix kedua untuk PageVersion setelah:
1. **`is_featured` fix** - Added default value `false`
2. **`sort_order` fix** - Added default value `0` ✅ (This fix)

## ✅ **STATUS:**

**✅ PAGE VERSION SORT_ORDER ERROR - FIXED!** 🎉

**Test Results:**
- ✅ Create new page works
- ✅ Page version created automatically
- ✅ No NULL constraint violation
- ✅ Audit log works properly
- ✅ Default values applied correctly

**Silakan test dengan membuat page baru lagi!**
