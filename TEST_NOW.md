# ✅ **TESTING CHECKLIST - Instagram OAuth Auto-Save Fix**

---

## 🎯 **Quick Test (5 menit)**

### **Step 1: Clear Database**

```bash
php artisan tinker
```

```php
>>> App\Models\InstagramSetting::truncate()
>>> exit
```

### **Step 2: OAuth Flow**

1. **Buka:** `https://maudu-rejoso.sch.id/admin/superadmin/instagram-settings`

2. **Click:** "Connect with Instagram" (purple button)

3. **Authorize** di Instagram

4. **Wait** for redirect back

### **Step 3: Verify Auto-Save**

**Expected:**
- ✅ Green success alert: "Authorization berhasil! Access token telah disimpan..."
- ✅ Form auto-filled with token & user ID
- ✅ Token is **read-only** (already saved)

### **Step 4: Check Database**

```bash
php artisan tinker
```

```php
>>> $s = App\Models\InstagramSetting::first()
>>> $s->access_token  // Should show: "IGAAW..."
>>> $s->user_id  // Should show: "17841428646148329"
>>> $s->username  // Should show your Instagram username
>>> $s->is_active  // Should show: 1
>>> $s->token_expires_at  // Should show date ~60 days from now
```

**Expected:**
```
InstagramSetting {
  id: 1,
  access_token: "IGAAW...",
  user_id: "17841428646148329",
  username: "your_username",
  is_active: 1,
  token_expires_at: "2025-12-XX XX:XX:XX"
}
```

### **Step 5: Test Persistence**

1. **Refresh page** (F5) → Token still there? ✅
2. **Refresh again** → Token still there? ✅
3. **Open in new tab** → Token still there? ✅

### **Step 6: Test Connection**

1. **Click** "Test Connection" (yellow button)

**Expected:**
- ✅ Green success alert
- ✅ Show account info (username, follower count, etc)

---

## 📊 **Full Test (10 menit)**

### **Test 1: OAuth + Auto-Save**

```bash
# Watch logs in real-time
tail -f storage/logs/laravel-$(date +%Y-%m-%d).log
```

**In browser:**
1. Clear database: `App\Models\InstagramSetting::truncate()`
2. Click "Connect with Instagram"
3. Authorize
4. Watch redirect

**Expected logs:**
```
Instagram OAuth Callback Received
Exchanging authorization code for access token
✅ Short-lived token obtained
Exchanging short-lived token for long-lived token
✅ Long-lived token obtained (expires_in: 5184000 seconds ~60 days)
💾 Auto-saving OAuth token to database...
✅ OAuth token auto-saved successfully (id: 1, user_id: 17841428646148329, username: your_username)
```

**If you see these logs: ✅ SUCCESS!**

---

### **Test 2: Token Persistence**

1. After OAuth, **get token from form**:
   ```javascript
   document.getElementById('access_token').value
   ```

2. **Copy that token**

3. **Refresh page 5 times** (F5, F5, F5, F5, F5)

4. **Check form again:**
   ```javascript
   document.getElementById('access_token').value
   ```

5. **Compare:** Token same as before? ✅

6. **Check database:**
   ```bash
   php artisan tinker
   >>> App\Models\InstagramSetting::first()->access_token
   ```

**Expected:** All 3 token values match!

---

### **Test 3: Test Connection Button**

1. **Open browser console** (F12)

2. **Clear console**

3. **Click "Test Connection"**

**Expected console output:**
```javascript
🔌 Testing Instagram connection...
Test connection response status: 200
Test connection response data: {success: true, ...}
✅ Connection test passed!
Account info: {username: "...", followers: ...}
```

**Expected alert:**
- ✅ Green SweetAlert with account info

**If connection fails:**
- Check server logs for errors
- Verify token not expired: `InstagramSetting::first()->token_expires_at > now()`

---

### **Test 4: Save Sync Settings**

1. **Change "Sync Frequency"** to 60 minutes

2. **Change "Cache Duration"** to 2 hours (7200)

3. **Toggle "Auto Sync"** to OFF

4. **Click "Save Settings"**

**Expected:**
- ✅ Green success alert: "Sync settings saved successfully!"
- ✅ Page reload
- ✅ New values shown in form

**Verify database:**
```bash
php artisan tinker
>>> $s = App\Models\InstagramSetting::first()
>>> $s->sync_frequency  // Should be: 60
>>> $s->cache_duration  // Should be: 7200
>>> $s->auto_sync_enabled  // Should be: 0
```

---

### **Test 5: Query Parameter Input**

1. **Get current token from DB:**
   ```bash
   php artisan tinker
   >>> App\Models\InstagramSetting::first()->access_token
   # Copy this token
   ```

2. **Open URL with query params:**
   ```
   https://maudu-rejoso.sch.id/admin/superadmin/instagram-settings?access_token=PASTE_TOKEN_HERE&user_id=17841428646148329
   ```

**Expected:**
- ✅ Token auto-fills in form
- ✅ User ID auto-fills

3. **Click "Test Connection"** → Should work!

---

## 🐛 **Debugging Failed Tests**

### ❌ **Issue: OAuth redirect but no token saved**

**Check:**
1. Server logs for errors:
   ```bash
   tail -30 storage/logs/laravel-$(date +%Y-%m-%d).log | grep -i error
   ```

2. Database write permissions:
   ```bash
   php artisan tinker
   >>> App\Models\InstagramSetting::create(['sync_frequency' => 30, 'cache_duration' => 3600])
   ```

3. Instagram API response:
   - Check logs for "Failed to exchange code for token"
   - Check App ID/Secret in `.env`

---

### ❌ **Issue: Token shows but Test Connection fails**

**Check:**

1. **Token expiry:**
   ```bash
   php artisan tinker
   >>> App\Models\InstagramSetting::first()->token_expires_at
   >>> App\Models\InstagramSetting::first()->token_expires_at > now()
   ```

2. **Token format:**
   ```bash
   >>> $token = App\Models\InstagramSetting::first()->access_token
   >>> strlen($token)  // Should be ~200+ chars
   >>> substr($token, 0, 5)  // Should be "IGAAW" or "IGQVJ"
   ```

3. **API call manually:**
   ```bash
   php artisan tinker
   >>> $s = App\Models\InstagramSetting::first()
   >>> $response = Http::get("https://graph.instagram.com/v20.0/{$s->user_id}", [
       'fields' => 'id,username',
       'access_token' => $s->access_token
   ])
   >>> $response->json()
   ```

---

### ❌ **Issue: Token disappears after refresh**

**This should NOT happen anymore!**

If it does:
1. Check if auto-save ran in logs:
   ```bash
   grep "OAuth token auto-saved successfully" storage/logs/laravel-*.log
   ```

2. Check database directly:
   ```bash
   php artisan tinker
   >>> App\Models\InstagramSetting::count()  // Should be 1
   >>> App\Models\InstagramSetting::first()->access_token  // Should NOT be null
   ```

3. If database is empty:
   - OAuth callback auto-save failed
   - Check logs for "Failed to auto-save OAuth token"
   - Check exception details

---

### ❌ **Issue: "Save Settings" button no response**

**Check:**

1. **Browser console:**
   ```javascript
   document.getElementById('instagramSettingsForm')  // Should NOT be null
   document.getElementById('saveSettingsBtn')  // Should NOT be null
   ```

2. **JavaScript errors:**
   - F12 → Console tab
   - Look for red errors

3. **Network tab:**
   - F12 → Network tab
   - Click "Save Settings"
   - Should see POST to `/admin/superadmin/instagram-settings`
   - Check response status & body

---

## 📋 **Final Checklist**

After all tests:

- [ ] OAuth flow completes successfully
- [ ] Token auto-saved to database
- [ ] Token persists after refresh
- [ ] Test Connection button works
- [ ] Save Settings button works
- [ ] Server logs show no errors
- [ ] Database has token with future expiry date
- [ ] Query parameter input works (optional)

**If ALL checked: ✅ PERFECT!** 🎉

**If ANY unchecked: 🐛 Check debugging section above**

---

## 🚀 **Production Deployment**

Once all tests pass:

```bash
# 1. Commit changes
git add .
git commit -m "Fix: Auto-save Instagram OAuth token to prevent token loss"

# 2. Push to production
git push origin main

# 3. On production server:
composer install --no-dev --optimize-autoloader
php artisan config:clear
php artisan cache:clear
php artisan view:clear
npm run build

# 4. Test on production!
```

---

**Ready to test? Start with Quick Test (5 min) first!** 🚀

