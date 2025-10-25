# 🔄 Instagram API Migration Guide

**Date**: 2025-10-24  
**Migration**: Instagram Basic Display API → Instagram Platform API with Facebook Login  
**Reason**: Instagram Basic Display API deprecated, Instagram Platform API is the official solution

---

## ⚠️ **Why Migrate?**

### **Old: Instagram Basic Display API**
- ❌ Limited features (read-only access to media)
- ❌ Deprecated by Meta
- ❌ Short-lived tokens (60 days, no auto-refresh)
- ❌ Requires manual token regeneration
- ❌ Consumer app type

### **New: Instagram Platform API with Facebook Login** ✅
- ✅ **Full featured** (get/publish media, insights, comments, hashtags)
- ✅ **Officially supported** by Meta
- ✅ **Long-lived tokens** (60 days, can auto-refresh)
- ✅ **Better permissions** management
- ✅ **Business app type**
- ✅ Access to **Instagram Insights & Analytics**

**Reference**: [Instagram Platform Documentation](https://developers.facebook.com/docs/instagram-platform/)

---

## 📋 **Key Differences**

| Aspect | Instagram Basic Display | Instagram Platform API |
|--------|-------------------------|------------------------|
| **App Type** | Consumer | **Business** |
| **Requirements** | Instagram Business/Creator | Instagram Business/Creator **+ Facebook Page** |
| **Linking** | Direct Instagram | **Via Facebook Page** |
| **Token Type** | Short-lived (60d) | Long-lived Page Token (60d, refreshable) |
| **Permissions** | Limited (basic read) | Full (read, publish, insights, comments) |
| **API Endpoint** | `/me`, `/{user-id}/media` | `/{ig-business-id}/media`, `/{ig-business-id}/insights` |
| **Features** | Basic media access | Media, Stories, Comments, Hashtags, Insights |
| **Status** | Deprecated | **Active & Supported** |

---

## 🔧 **Migration Steps**

### **Phase 1: Pre-Migration Requirements**

#### ✅ **1.1. Verify Instagram Account Type**
```
Instagram account MUST be:
- Business account OR Creator account
- NOT personal account
```

**How to check**:
- Open Instagram app
- Go to Profile → Settings → Account
- Should see "Switch to Personal Account" option

#### ✅ **1.2. Link Instagram to Facebook Page**
```
CRITICAL: Instagram MUST be linked to a Facebook Page
```

**Steps**:
1. Open Instagram app
2. Profile → ☰ Menu → Settings
3. Account → Linked accounts → Facebook
4. Login to Facebook
5. Select the Facebook Page for your school
6. Allow permissions

**Verify**:
- Go to Facebook Page → Settings → Instagram
- Should see Instagram account connected

---

### **Phase 2: Update Facebook App**

#### ✅ **2.1. Create New Business App** (or convert existing)

**Old Setup** (Consumer App):
```
App Type: Consumer
Product: Instagram Basic Display
```

**New Setup** (Business App):
```
App Type: Business
Product: Instagram Platform API
```

**Steps**:
1. Go to https://developers.facebook.com
2. My Apps → Create App
3. Select **"Business"** (not Consumer!)
4. Fill in app details
5. Create app

#### ✅ **2.2. Add Instagram Product**

**Steps**:
1. In app dashboard, sidebar → "Add products"
2. Find "Instagram" → Click "Set Up"
3. Instagram now added to sidebar

---

### **Phase 3: Configure Permissions**

#### ✅ **3.1. Required Permissions**

**Old Permissions** (Basic Display):
```
- instagram_graph_user_profile
- instagram_graph_user_media
```

**New Permissions** (Platform API):
```
Required:
- instagram_basic ✅
- instagram_content_publish ✅ (if publishing)
- pages_read_engagement ✅
- pages_show_list ✅

Optional (for advanced features):
- instagram_manage_comments
- instagram_manage_insights
- public_profile
```

#### ✅ **3.2. Generate Long-Lived Page Access Token**

**Old Method** (Basic Display):
```
1. User Token Generator
2. Get short-lived token (60 days)
3. Manual regeneration required
```

**New Method** (Platform API):
```
1. Graph API Explorer
2. Select your app
3. Select Facebook Page
4. Generate Page Access Token
5. Exchange for long-lived token
6. Can be programmatically refreshed
```

**Generate Long-Lived Token**:
```bash
# Step 1: Get short-lived token from Graph API Explorer
# (Token expires in 1 hour)

# Step 2: Exchange for long-lived Page token (60 days)
curl -X GET "https://graph.facebook.com/v18.0/oauth/access_token?grant_type=fb_exchange_token&client_id={app-id}&client_secret={app-secret}&fb_exchange_token={short-lived-token}"

# Response:
{
  "access_token": "{long-lived-token}",
  "token_type": "bearer",
  "expires_in": 5183944  // ~60 days
}
```

#### ✅ **3.3. Get Instagram Business Account ID**

**Old Method**:
```
GET /me?fields=id&access_token={user-token}
```

**New Method**:
```
GET /{page-id}?fields=instagram_business_account&access_token={page-token}

Response:
{
  "instagram_business_account": {
    "id": "17841405822304914"  // This is your IG Business Account ID
  },
  "id": "123456789"  // Page ID
}
```

---

### **Phase 4: Update Code Implementation**

#### ✅ **4.1. Update API Endpoints**

**Old Endpoints** (Basic Display):
```php
// Get user profile
GET https://graph.instagram.com/me?fields=id,username&access_token={token}

// Get user media
GET https://graph.instagram.com/{user-id}/media?fields=id,caption,media_type,media_url&access_token={token}
```

**New Endpoints** (Platform API):
```php
// Get Instagram Business Account info
GET https://graph.facebook.com/v18.0/{page-id}?fields=instagram_business_account{id,username,profile_picture_url}&access_token={page-token}

// Get media
GET https://graph.facebook.com/v18.0/{ig-business-id}/media?fields=id,caption,media_type,media_url,permalink,timestamp,like_count,comments_count,insights.metric(impressions,reach,engagement)&access_token={page-token}

// Get media insights
GET https://graph.facebook.com/v18.0/{media-id}/insights?metric=impressions,reach,engagement&access_token={page-token}

// Search hashtags
GET https://graph.facebook.com/v18.0/ig_hashtag_search?user_id={ig-business-id}&q={hashtag}&access_token={page-token}
```

#### ✅ **4.2. Update InstagramService.php**

**Before** (Basic Display):
```php
class InstagramService
{
    protected $baseUrl = 'https://graph.instagram.com/v12.0';
    
    public function fetchPosts($limit = 20)
    {
        $response = Http::get($this->baseUrl . "/{$this->userId}/media", [
            'fields' => 'id,caption,media_type,media_url,permalink,timestamp',
            'access_token' => $this->accessToken,
            'limit' => $limit
        ]);
    }
}
```

**After** (Platform API):
```php
class InstagramService
{
    protected $baseUrl = 'https://graph.facebook.com/v18.0';
    protected $pageAccessToken;  // Page token, not user token!
    protected $igBusinessAccountId;  // IG Business Account ID
    
    public function fetchPosts($limit = 20)
    {
        // Get media with insights
        $response = Http::get($this->baseUrl . "/{$this->igBusinessAccountId}/media", [
            'fields' => 'id,caption,media_type,media_url,permalink,timestamp,like_count,comments_count,thumbnail_url,children{media_url}',
            'access_token' => $this->pageAccessToken,
            'limit' => $limit
        ]);
        
        if ($response->successful()) {
            $data = $response->json();
            return $data['data'] ?? [];
        }
        
        return [];
    }
    
    /**
     * Get media insights (NEW FEATURE!)
     */
    public function getMediaInsights($mediaId)
    {
        $response = Http::get($this->baseUrl . "/{$mediaId}/insights", [
            'metric' => 'impressions,reach,engagement,saved',
            'access_token' => $this->pageAccessToken
        ]);
        
        return $response->json();
    }
    
    /**
     * Search by hashtag (NEW FEATURE!)
     */
    public function searchHashtag($hashtag)
    {
        // Search hashtag
        $searchResponse = Http::get($this->baseUrl . "/ig_hashtag_search", [
            'user_id' => $this->igBusinessAccountId,
            'q' => $hashtag,
            'access_token' => $this->pageAccessToken
        ]);
        
        if ($searchResponse->successful()) {
            $hashtagId = $searchResponse->json()['data'][0]['id'] ?? null;
            
            if ($hashtagId) {
                // Get recent media for hashtag
                $mediaResponse = Http::get($this->baseUrl . "/{$hashtagId}/recent_media", [
                    'user_id' => $this->igBusinessAccountId,
                    'fields' => 'id,caption,media_type,media_url,permalink,timestamp',
                    'access_token' => $this->pageAccessToken
                ]);
                
                return $mediaResponse->json()['data'] ?? [];
            }
        }
        
        return [];
    }
}
```

#### ✅ **4.3. Update InstagramSetting Model**

**Add new fields**:
```php
protected $fillable = [
    'access_token',  // Now stores Page Access Token
    'user_id',  // Now stores IG Business Account ID
    'page_id',  // NEW: Facebook Page ID
    'page_access_token',  // NEW: Explicit Page token
    'app_id',
    'app_secret',
    'is_active',
    'last_sync',
    'token_expires_at',  // NEW: Track token expiry
    // ... other fields
];
```

---

### **Phase 5: Update Settings UI**

#### ✅ **5.1. Update Form Fields**

**Old Fields**:
```
- Access Token (User Token)
- User ID (Instagram User ID)
```

**New Fields**:
```
- Page Access Token* (Long-lived Page token)
- Instagram Business Account ID*
- Facebook Page ID (optional, for reference)
```

#### ✅ **5.2. Update Test Connection**

**Old Test**:
```php
GET /me?fields=id&access_token={user-token}
```

**New Test**:
```php
// Test 1: Verify Page token
GET /{page-id}?fields=id,name&access_token={page-token}

// Test 2: Verify IG account connection
GET /{page-id}?fields=instagram_business_account{id,username}&access_token={page-token}

// Test 3: Try fetching media
GET /{ig-business-id}/media?fields=id&limit=1&access_token={page-token}
```

---

### **Phase 6: Testing**

#### ✅ **6.1. Test Checklist**

- [ ] Instagram linked to Facebook Page
- [ ] Business app created with Instagram product
- [ ] Long-lived Page Access Token generated
- [ ] IG Business Account ID retrieved
- [ ] Test connection successful
- [ ] Media fetch working
- [ ] Insights retrieval working (if enabled)
- [ ] Token refresh logic implemented
- [ ] Error handling updated
- [ ] Logs showing new API calls

#### ✅ **6.2. Rollback Plan**

If migration fails:
1. Keep old Basic Display setup temporarily
2. Run both APIs in parallel (feature flag)
3. Gradually migrate users
4. Monitor error rates
5. Full rollback if critical issues

---

## 📊 **New Features Available**

With Instagram Platform API, you now have access to:

### **1. Insights & Analytics** 📈
```php
// Get account insights
GET /{ig-business-id}/insights?metric=impressions,reach,profile_views&period=day

// Get media insights
GET /{media-id}/insights?metric=engagement,impressions,reach,saved
```

### **2. Hashtag Search** #️⃣
```php
// Search hashtags
GET /ig_hashtag_search?user_id={ig-business-id}&q=sekolah

// Get recent media for hashtag
GET /{hashtag-id}/recent_media?user_id={ig-business-id}&fields=...
```

### **3. Comments Management** 💬
```php
// Get comments
GET /{media-id}/comments?fields=text,username,timestamp

// Reply to comments
POST /{comment-id}/replies?message=Thanks!

// Hide/unhide comments
POST /{comment-id}?hide=true
```

### **4. Publish Content** 📤
```php
// Create media container
POST /{ig-business-id}/media?image_url={url}&caption={text}

// Publish media
POST /{ig-business-id}/media_publish?creation_id={container-id}
```

### **5. Stories** 📱
```php
// Get stories
GET /{ig-business-id}/stories?fields=id,media_type,media_url,timestamp
```

---

## 🎯 **Benefits After Migration**

- ✅ **Official API** - No deprecation concerns
- ✅ **Long-lived tokens** - 60 days, auto-refreshable
- ✅ **Richer data** - Insights, reach, engagement metrics
- ✅ **Better permissions** - Granular control
- ✅ **New features** - Hashtag search, comments, publish
- ✅ **Facebook integration** - Unified platform
- ✅ **Better support** - Active documentation & community

---

## 📚 **References**

- [Instagram Platform Overview](https://developers.facebook.com/docs/instagram-platform/)
- [Instagram API with Facebook Login](https://developers.facebook.com/docs/instagram-api/)
- [Instagram Graph API Reference](https://developers.facebook.com/docs/instagram-api/reference)
- [Access Tokens Guide](https://developers.facebook.com/docs/facebook-login/guides/access-tokens)
- [Permissions Reference](https://developers.facebook.com/docs/permissions/reference)

---

**Status**: ✅ **Ready for Migration**  
**Impact**: Medium (requires new setup, but more features)  
**Estimated Time**: 1-2 hours for complete migration

---

**Document Version**: 1.0  
**Last Updated**: 2025-10-24  
**Author**: Development Team

