# 🚀 Instagram API Migration - Complete Guide

**Status**: ✅ **COMPLETED - Phase 2: Code Update**  
**Date**: October 25, 2025  
**Migration**: Instagram Basic Display API → Instagram Platform API with Instagram Login

---

## 📋 Summary

Successfully migrated from **deprecated Instagram Basic Display API** to **Instagram Platform API with Instagram Login** (Option A).

### ✅ Why Option A (Instagram Login)?

| Feature | Instagram Login ⭐ | Facebook Login |
|---------|-------------------|----------------|
| **Access Token** | Instagram User | Facebook User/Page |
| **Facebook Page Required** | ❌ No | ✅ Yes |
| **Setup Complexity** | 🟢 Simple | 🔴 Complex |
| **Best for** | 🎯 Display Posts Only | Advanced Features |
| **Comment Moderation** | ✅ Yes | ✅ Yes |
| **Content Publishing** | ✅ Yes | ✅ Yes |
| **Insights** | ✅ Yes | ✅ Yes |
| **Hashtag Search** | ❌ No | ✅ Yes |

**Decision**: **Option A** karena:
- ✅ Tidak perlu Facebook Page
- ✅ Lebih simple untuk use case sekolah (display posts)
- ✅ Setup lebih cepat
- ✅ Maintenance lebih mudah

---

## 🔧 Changes Made

### 1. **InstagramService.php** - API Service Layer
```php
// Updated API endpoint
protected $baseUrl = 'https://graph.instagram.com/v20.0'; // v12.0 → v20.0

// Enhanced fetchPosts() with real API call
public function fetchPosts($limit = 20)
{
    // Now actively calls Instagram Platform API
    // Falls back to mock data if credentials not configured
    $response = Http::timeout(30)->get($this->baseUrl . "/{$this->userId}/media", [
        'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp,like_count,comments_count,children{media_url,media_type}',
        'access_token' => $this->accessToken,
        'limit' => $limit
    ]);
}

// NEW: Media Insights
public function getMediaInsights($mediaId, $metrics = ['engagement', 'impressions', 'reach'])

// NEW: Account Insights
public function getAccountInsights($period = 'day', $metrics = ['impressions', 'reach', 'profile_views'])
```

**Key Improvements**:
- ✅ Real API calls enabled (not mocked)
- ✅ Updated to v20.0 endpoint
- ✅ Enhanced error logging
- ✅ Fallback to mock data if credentials missing
- ✅ Added Insights methods (media & account)

---

### 2. **InstagramSetting Model** - Database Schema
```php
// NEW fields added
protected $fillable = [
    // ... existing fields
    'username',           // NEW: Instagram username
    'account_type',       // NEW: BUSINESS or CREATOR
    'token_expires_at',   // NEW: Token expiry tracking
];

// NEW methods
public function isTokenExpired()          // Check if token expired
public function isTokenExpiringSoon()     // Check if expiring within 7 days
public function getTokenStatusAttribute() // Get token health status
```

**Migration File**: `2025_10_25_035828_add_instagram_platform_api_fields_to_instagram_settings_table.php`
```php
Schema::table('instagram_settings', function (Blueprint $table) {
    $table->string('username')->nullable()->after('user_id');
    $table->string('account_type')->nullable()->after('username')->comment('BUSINESS or CREATOR');
    $table->timestamp('token_expires_at')->nullable()->after('last_sync');
});
```

---

### 3. **InstagramSettingController** - API Integration
```php
// Updated store() method
public function store(Request $request)
{
    // Test connection and get account info in one call
    $accountInfo = $this->testInstagramConnectionWithInfo($request->access_token, $request->user_id);
    
    // Calculate token expiry (60 days for long-lived tokens)
    $tokenExpiresAt = now()->addDays(60);
    
    // Save with new fields
    $settings = InstagramSetting::updateOrCreate([...], [
        'username' => $accountInfo['username'] ?? null,
        'account_type' => $accountInfo['account_type'] ?? null,
        'token_expires_at' => $tokenExpiresAt,
        // ... other fields
    ]);
}

// NEW: Combined test method
private function testInstagramConnectionWithInfo($accessToken, $userId)
{
    $response = Http::timeout(15)->get("https://graph.instagram.com/v20.0/{$userId}", [
        'fields' => 'id,username,name,account_type,media_count,profile_picture_url',
        'access_token' => $accessToken
    ]);
}
```

---

### 4. **instagram-settings.blade.php** - Settings UI
```php
// Enhanced status display
@if ($settings && $settings->is_active)
    <span class="font-medium text-green-600">Active</span>
    @if ($settings->username)
        - Connected as <span class="font-medium">@{{ $settings->username }}</span>
    @endif
    @if ($settings->account_type)
        <span class="badge bg-purple">{{ $settings->account_type }}</span>
    @endif
@endif

// NEW: Token expiry warning
@if ($settings->isTokenExpired())
    <div class="text-red-600">
        Token expired on {{ $settings->token_expires_at->format('M d, Y') }}
    </div>
@elseif ($settings->isTokenExpiringSoon())
    <div class="text-orange-600">
        Token will expire on {{ $settings->token_expires_at->format('M d, Y') }}
    </div>
@endif

// Updated form hints
<p class="text-xs">Instagram User Access Token dari Business Login</p>
<p class="text-xs">Instagram Business/Creator Account ID (bukan Facebook Page ID)</p>
```

---

## 📚 Documentation Updates

### 1. **instagram-setup.blade.php** - Setup Guide ✅ UPDATED
- ✅ Changed from Basic Display API to Platform API
- ✅ Updated app type to "Business"
- ✅ Removed Facebook Page requirement
- ✅ Updated to Instagram Login flow
- ✅ Full Bahasa Indonesia translation
- ✅ 7 detailed steps with screenshots references

### 2. **INSTAGRAM_API_MIGRATION.md** - Migration Planning
- ✅ Created migration strategy
- ✅ Documented API differences
- ✅ Outlined implementation steps

### 3. **This Document** - Implementation Report
- ✅ Complete code changes documentation
- ✅ Before/after comparisons
- ✅ Testing guide

---

## 🧪 Testing Checklist

### Backend API Tests
- [ ] Test connection with valid Instagram User Access Token
- [ ] Verify account info retrieval (username, account_type)
- [ ] Fetch real Instagram posts
- [ ] Test token validation
- [ ] Check error handling for invalid credentials
- [ ] Verify token expiry calculations

### Frontend Tests
- [ ] Access settings page: `/admin/superadmin/instagram-settings`
- [ ] Verify status display shows username & account type
- [ ] Check token expiry warnings display correctly
- [ ] Test "Test Connection" button
- [ ] Test "Save Settings" with real credentials
- [ ] Test "Sync Now" button
- [ ] Verify Instagram feed display on public page

### Integration Tests
- [ ] End-to-end: Setup → Save → Sync → Display
- [ ] Cache clearing on settings update
- [ ] Session persistence
- [ ] Error recovery

---

## 🎯 How to Use (For Client)

### Step 1: Access Settings Page
Navigate to: `https://ig-to-web.test/admin/superadmin/instagram-settings`

### Step 2: Follow Setup Guide
Click "Setup Guide" button → Follow 7 steps in Bahasa Indonesia

### Step 3: Get Instagram Credentials
1. Create Meta Business App (type: Business)
2. Add Instagram product
3. Configure Business Login for Instagram
4. Get Instagram User Access Token
5. Get Instagram Professional Account ID

### Step 4: Enter Credentials
- **Access Token**: Instagram User Access Token (dari Business Login)
- **User ID**: Instagram Professional Account ID (Business/Creator account)
- **App ID & Secret**: Optional (untuk token refresh)

### Step 5: Test & Save
1. Click "Test Connection"
2. Verify account info shows correct username
3. Click "Save Settings"
4. Confirm token expiry date

### Step 6: Sync Data
Click "Sync Now" to fetch latest Instagram posts

### Step 7: View Feed
- Public page: `/instagram` or `/kegiatan`
- Check posts are displaying correctly

---

## 📖 Reference Documentation

Official Meta Documentation:
- ✅ [Instagram Platform Overview](https://developers.facebook.com/docs/instagram-platform/)
- ✅ [Instagram API with Instagram Login](https://developers.facebook.com/docs/instagram-platform/instagram-api-with-instagram-login/overview)
- ✅ [Business Login for Instagram](https://developers.facebook.com/docs/instagram/platform/instagram-api/business-login)
- ✅ [Migration Guide](https://developers.facebook.com/docs/instagram-platform/instagram-api-with-instagram-login/migration-guide)

---

## ✅ Migration Status

| Component | Status | Notes |
|-----------|--------|-------|
| **API Service** | ✅ Done | InstagramService.php updated to v20.0 |
| **Database Schema** | ✅ Done | Migration created & run |
| **Controller** | ✅ Done | InstagramSettingController updated |
| **Model** | ✅ Done | Token expiry tracking added |
| **View** | ✅ Done | Settings page enhanced |
| **Setup Guide** | ✅ Done | Translated & updated to Instagram Login |
| **Testing** | 🔄 Pending | Awaiting client credentials |
| **Deployment** | 🔄 Pending | Ready for VPS push |

---

## 🚀 Next Steps

1. **Client Testing**:
   - Client follows setup guide
   - Obtains Instagram credentials
   - Tests connection on local environment

2. **Production Deployment**:
   - Run migration on VPS: `php artisan migrate`
   - Compile assets: `npm run build`
   - Clear cache: `php artisan optimize:clear`

3. **Post-Deployment**:
   - Monitor error logs
   - Verify Instagram posts display correctly
   - Check token expiry notifications

---

## 💡 Key Differences: `/kegiatan` vs `/instagram`

Based on reference site `maudu-rejoso.sch.id`:

### `/kegiatan` (Activities Page)
- **Purpose**: Display school activities/events
- **Content Source**: Manual CMS entries
- **Update Frequency**: Admin posts manually
- **Content Type**: Text-heavy with photos
- **Examples**: Seminars, workshops, ceremonies

### `/instagram` (Instagram Feed Page)
- **Purpose**: Auto-display Instagram posts
- **Content Source**: Instagram API (auto-sync)
- **Update Frequency**: Automatic (based on sync settings)
- **Content Type**: Visual-first (photos/videos from IG)
- **Examples**: Real-time school social media updates

**Recommendation**: Keep both pages for different purposes:
- Use `/kegiatan` for formal announcements & documentation
- Use `/instagram` for dynamic, visual social media content

---

## 📝 Notes

- ✅ No Facebook Page required (unlike old setup)
- ✅ Simpler authentication flow
- ✅ Better error handling & logging
- ✅ Token expiry tracking for proactive maintenance
- ✅ Falls back to mock data if not configured (dev-friendly)
- ✅ Fully translated documentation (Bahasa Indonesia)

---

**Migration completed successfully! Ready for client testing.** 🎉

