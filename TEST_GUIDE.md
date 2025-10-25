# 🧪 Instagram Settings - Test Guide

## ✅ Pre-Test Checklist

1. [ ] `.env` file has Instagram credentials
2. [ ] Run `php artisan config:clear`
3. [ ] Run `npm run build` (if you haven't yet)
4. [ ] Meta App has correct redirect URI
5. [ ] Browser cache cleared (Ctrl+Shift+R)

---

## 🎯 Test 1: View Settings Page

**Steps:**
1. Open: `https://ig-to-web.test/admin/superadmin/instagram-settings`

**Expected:**
- ✅ Page loads without errors
- ✅ Only 2 cards visible:
  - Card 1: Instagram Credentials (Access Token & User ID)
  - Card 2: Sync & Cache Settings
- ✅ Purple "🔗 Connect with Instagram" button visible at top
- ✅ NO App ID/Secret fields in form
- ✅ NO Webhook Configuration card

**Screenshot:** Take screenshot if layout correct

---

## 🎯 Test 2: Connect with Instagram (OAuth)

**Steps:**
1. Click purple "Connect with Instagram" button

**Expected:**
- ✅ Redirected to Instagram/Facebook login
- ✅ Authorization page shows correct permissions
- ✅ After authorize, redirected back to settings page
- ✅ SweetAlert shows success message
- ✅ Access Token & User ID fields auto-filled
- ✅ Connection Status badge shows "✅ Connected"
- ✅ Token Expiry shows date (60 days from now)

**If Error:**
- Check browser console (F12)
- Check `storage/logs/laravel.log`
- Verify redirect URI matches Meta App settings

---

## 🎯 Test 3: Save Sync Settings Only

**Steps:**
1. Leave Access Token & User ID empty
2. Change Sync Frequency to "Every 15 minutes"
3. Change Cache Duration to "15 minutes"
4. Toggle Auto Sync off
5. Click "💾 Save Settings"

**Expected:**
- ✅ SweetAlert loading appears
- ✅ Success message: "Sync settings saved successfully!"
- ✅ Page reloads
- ✅ Settings preserved after reload
- ✅ No validation errors

---

## 🎯 Test 4: Manual Token Setup

**Steps:**
1. Get valid access token from Meta Graph API Explorer
2. Get valid user ID
3. Fill both fields
4. Click "💾 Save Settings"

**Expected:**
- ✅ Loading message appears
- ✅ Backend tests connection
- ✅ Success message if valid
- ✅ Error message if invalid
- ✅ Token saved to database
- ✅ Connection status updated

---

## 🎯 Test 5: Sync Instagram Posts

**Steps:**
1. Ensure connected (from Test 2 or Test 4)
2. Click "🔄 Sync Instagram Posts" button

**Expected:**
- ✅ Button shows loading spinner
- ✅ Success message after sync
- ✅ Page reloads
- ✅ Last Sync timestamp updated

---

## 🎯 Test 6: Browser Console Check

**Steps:**
1. Open settings page
2. Open browser console (F12)
3. Click "Save Settings"

**Expected Console Log:**
```javascript
✅ Default prevented - processing form
✅ Validation passed, proceeding to save
Form data: {has_access_token: false, has_user_id: false, ...}
Save response status: 200
Save response data: {success: true, ...}
```

**No Errors:** Like "app_id is undefined" or similar

---

## 🎯 Test 7: Config Verification

**Run in terminal:**
```bash
php artisan tinker
>>> config('services.instagram.app_id')
=> "1575539400487129"

>>> config('services.instagram.app_secret')
=> "7b6f727ebfd70393214e92b9b93676c3"

>>> config('services.instagram.redirect_uri')
=> "https://ig-to-web.test/instagram/callback"
```

**Expected:**
- ✅ All values return correctly
- ✅ No null/empty values

---

## 🎯 Test 8: OAuth URL Generation

**Run in terminal:**
```bash
php artisan tinker
>>> $service = app(App\Services\InstagramService::class);
>>> $url = $service->getAuthorizationUrl();
>>> echo $url;
```

**Expected:**
- ✅ Returns URL starting with `https://www.instagram.com/oauth/authorize?`
- ✅ Contains `client_id=1575539400487129`
- ✅ Contains `redirect_uri=https://ig-to-web.test/instagram/callback`
- ✅ Contains correct scopes

---

## 🎯 Test 9: Database Check

**Run in terminal:**
```bash
php artisan tinker
>>> $setting = App\Models\InstagramSetting::first();
>>> $setting->access_token ?? 'null'
>>> $setting->user_id ?? 'null'
>>> $setting->sync_frequency
>>> $setting->is_active
```

**Expected:**
- ✅ Sync settings saved
- ✅ Tokens saved if connected
- ✅ No app_id/app_secret in database (or old values remain but unused)

---

## 🐛 Common Issues & Fixes

### Issue: "App ID not configured"

**Fix:**
```bash
php artisan config:clear
```
Verify `.env` has correct values.

---

### Issue: OAuth redirect fails

**Check:**
1. Redirect URI in Meta App matches `.env` exactly
2. HTTPS vs HTTP
3. No trailing slash
4. Domain accessible

---

### Issue: Form doesn't submit

**Fix:**
1. Hard refresh: Ctrl+Shift+R
2. Clear browser cache
3. Run `npm run build`
4. Check browser console for JS errors

---

### Issue: Connect button missing

**Check:**
1. `$authorizationUrl` is not null
2. No PHP errors in logs
3. View file updated correctly

---

## ✅ Success Criteria

All tests pass means:
- [x] Page loads without errors
- [x] Form simplified (no App ID/Secret fields)
- [x] OAuth connect works
- [x] Settings save works
- [x] Sync works
- [x] No JavaScript errors
- [x] No PHP errors
- [x] Config reads from .env correctly

---

## 📊 Test Results Template

```
Date: [DATE]
Tester: [NAME]

Test 1 (View Page): ✅ / ❌
Test 2 (OAuth): ✅ / ❌
Test 3 (Save Sync): ✅ / ❌
Test 4 (Manual Token): ✅ / ❌
Test 5 (Sync Posts): ✅ / ❌
Test 6 (Console): ✅ / ❌
Test 7 (Config): ✅ / ❌
Test 8 (OAuth URL): ✅ / ❌
Test 9 (Database): ✅ / ❌

Notes:
[Any issues or observations]
```

---

**Happy Testing!** 🚀

