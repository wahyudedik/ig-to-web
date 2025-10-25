# Instagram OAuth Callback Setup - October 25, 2025

## ✅ **CALLBACK ROUTE SUDAH DITAMBAHKAN!**

### 🔧 **Perubahan Yang Dilakukan:**

#### 1. **Route Baru** (`routes/web.php`)
```php
// Instagram OAuth Callback (for receiving access token from Meta)
Route::get('/instagram/callback', [InstagramController::class, 'handleOAuthCallback'])
    ->name('instagram.callback');
```

**URL Callback:** `https://maudu-rejoso.sch.id/instagram/callback`

---

#### 2. **Method Baru di InstagramController** 
```php
public function handleOAuthCallback(Request $request)
```

**Fungsi:**
- ✅ Menerima access token dari Meta OAuth redirect
- ✅ Menerima user_id (optional)
- ✅ Handle error dari Meta
- ✅ Logging untuk debugging
- ✅ Redirect ke Instagram settings dengan token

---

#### 3. **Update InstagramSettingController**
```php
// Capture access_token from URL parameter OR session flash (OAuth redirect)
$urlAccessToken = $request->query('access_token') ?? session('oauth_access_token');
$urlUserId = $request->query('user_id') ?? session('oauth_user_id');
```

**Fungsi:**
- ✅ Support URL query parameters (dari Meta direct)
- ✅ Support session flash (dari callback redirect)

---

## 📝 **CARA SETUP DI META DASHBOARD:**

### **Step 1: Tambahkan Redirect URI di Meta Dashboard**

1. **Buka Meta Developer Dashboard**:
   ```
   https://developers.facebook.com/apps/849587954405408/instagram-business/API-Setup/
   ```

2. **Klik menu kiri**: `Instagram` → `API Setup with Instagram login`

3. **Scroll ke "3. Set up Instagram business login"**

4. **Klik "Business login settings"** atau **"Configure"**

5. **Di bagian "OAuth Redirect URIs"**, tambahkan:
   ```
   https://maudu-rejoso.sch.id/instagram/callback
   ```

6. **Klik "Save Changes"**

---

### **Step 2: Generate Access Token (2 Cara)**

#### **Cara A: Manual dari Meta Dashboard** (RECOMMENDED)

1. **Di halaman API Setup**, scroll ke **"1. Buat token akses"** (Create access token)
2. **Klik "Buat token"** (Create token) untuk akun Instagram Anda
3. **Copy Access Token** yang di-generate
4. **Copy Instagram Account ID** (yang di bawah username, contoh: `17841428646148329`)
5. **Paste manual ke form Laravel**
   - URL: `https://maudu-rejoso.sch.id/admin/superadmin/instagram-settings`
   - Field **Access Token**: Paste token (pastikan **TANPA SEMICOLON** di akhir!)
   - Field **User ID**: `17841428646148329`
   - Field **App ID**: `1575539400487129`
   - Field **App Secret**: (dari Meta Dashboard)
   - Klik **Test Connection** → lalu **Save Settings**

#### **Cara B: Via OAuth Flow** (Advanced - belum fully tested)

1. **Generate OAuth URL** (manual construct):
   ```
   https://www.instagram.com/oauth/authorize?
     client_id=1575539400487129&
     redirect_uri=https://maudu-rejoso.sch.id/instagram/callback&
     scope=instagram_basic,instagram_manage_insights&
     response_type=token
   ```

2. **Buka URL di browser** (login sebagai pemilik akun Instagram)
3. **Authorize app**
4. **Meta akan redirect ke**: `https://maudu-rejoso.sch.id/instagram/callback?access_token=XXX&...`
5. **Laravel akan auto-redirect ke settings** dengan token terisi

---

## 🎯 **FLOW DIAGRAM:**

### **Manual Flow (Recommended):**
```
Meta Dashboard 
  → "Buat token" 
  → Copy Access Token & User ID 
  → Paste ke Laravel Form 
  → Test Connection 
  → Save Settings 
  → ✅ DONE!
```

### **OAuth Flow (Advanced):**
```
User clicks OAuth URL 
  → Instagram Login 
  → Authorize App 
  → Meta Redirect: /instagram/callback?access_token=XXX 
  → InstagramController::handleOAuthCallback() 
  → Redirect: /admin/superadmin/instagram-settings 
  → Form auto-filled with token 
  → Test Connection 
  → Save Settings 
  → ✅ DONE!
```

---

## 🔍 **DEBUGGING OAUTH CALLBACK:**

### **Check Route Registration:**
```bash
php artisan route:list | grep instagram
```

Expected output:
```
GET  /instagram/callback    instagram.callback    InstagramController@handleOAuthCallback
GET  /instagram/webhook     instagram.webhook.verify    InstagramController@verifyWebhook
POST /instagram/webhook     instagram.webhook.handle    InstagramController@handleWebhook
```

### **Check Callback Logs:**
```bash
tail -f storage/logs/laravel.log
```

Saat callback terjadi, Anda akan lihat:
```
[INFO] Instagram OAuth Callback Received {
  "all_params": {
    "access_token": "IGAAWY...",
    "user_id": "17841428646148329"
  }
}
```

### **Test Callback Manually:**

Buka URL ini di browser (ganti `YOUR_TEST_TOKEN`):
```
https://maudu-rejoso.sch.id/instagram/callback?access_token=YOUR_TEST_TOKEN&user_id=17841428646148329
```

Seharusnya redirect ke settings page dengan alert sukses.

---

## ❌ **COMMON ISSUES & FIXES:**

### **Issue 1: "Redirect URI mismatch"**
**Cause:** Redirect URI di Meta Dashboard tidak match dengan yang di Laravel

**Fix:**
- Di **Meta Dashboard** → Business login settings
- Pastikan **EXACT** URL: `https://maudu-rejoso.sch.id/instagram/callback`
- ⚠️ Harus **HTTPS**, bukan HTTP!
- ⚠️ Tanpa trailing slash!

---

### **Issue 2: "Access token dengan semicolon di akhir"**
**Cause:** Copy-paste dari Meta Dashboard termasuk karakter extra

**Fix:**
- Saat paste Access Token, **hapus semicolon (`;`)** di akhir
- Token seharusnya: `IGAAWY8dpLsNIBZA...` (tanpa `;`)

---

### **Issue 3: "Callback tidak terjadi apa-apa"**
**Cause:** Route belum ter-register atau masih ter-cache

**Fix:**
```bash
php artisan route:clear
php artisan optimize:clear
```

---

### **Issue 4: "Token muncul di URL tapi form kosong"**
**Cause:** `$urlAccessToken` tidak di-pass ke view atau Blade syntax error

**Fix:**
- Cek controller: `compact('settings', 'urlAccessToken', 'urlUserId')`
- Cek view: `value="{{ $urlAccessToken ?? ($settings->access_token ?? '') }}"`

---

## 📋 **CHECKLIST SETUP:**

### **Meta Dashboard:**
- [ ] App ID: `1575539400487129`
- [ ] App Secret: (ambil dari Meta Dashboard)
- [ ] Instagram App: `qalcuity-IG` 
- [ ] Instagram Account: `wahyudedik6` (ID: `17841428646148329`)
- [ ] Redirect URI ditambahkan: `https://maudu-rejoso.sch.id/instagram/callback`
- [ ] Access Token di-generate (via "Buat token")

### **Laravel Application:**
- [x] Route `/instagram/callback` ditambahkan
- [x] `InstagramController::handleOAuthCallback()` dibuat
- [x] `InstagramSettingController::index()` updated
- [x] View support `$urlAccessToken` dan `$urlUserId`
- [x] Route cache cleared

### **Testing:**
- [ ] Access Token di-copy dari Meta Dashboard (tanpa semicolon!)
- [ ] User ID dicatat: `17841428646148329`
- [ ] Form di Laravel diisi manual
- [ ] Test Connection berhasil
- [ ] Save Settings berhasil
- [ ] Data tersimpan di database
- [ ] Status menjadi "Active"

---

## 🚀 **NEXT STEPS:**

1. **Setup Redirect URI di Meta Dashboard** (paling penting!)
2. **Generate Access Token** di Meta Dashboard
3. **Isi form Laravel** dengan:
   - Access Token (tanpa semicolon!)
   - User ID: `17841428646148329`
   - App ID: `1575539400487129`
   - App Secret: (dari Meta)
4. **Test Connection**
5. **Save Settings**
6. **Verify**: Status harus "Active", bisa lihat feed Instagram

---

## 📊 **STATUS:**

**✅ Callback Route: READY**  
**✅ Controller Method: READY**  
**✅ View Support: READY**  
**⏳ Meta Dashboard Setup: PENDING** ← **USER HARUS SETUP INI!**

---

**Date**: October 25, 2025  
**Added By**: AI Assistant  
**Status**: Ready for testing

