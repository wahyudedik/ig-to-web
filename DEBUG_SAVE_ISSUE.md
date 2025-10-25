# 🐛 Debug: Save Settings Issue

## Problem

User reports: "Kalau klik save sama aja hilang gak kesimpan"

---

## 🔍 Debug Steps

### **Method 1: Using Debug Tool (EASIEST)**

1. **Open debug tool:**
   ```
   https://maudu-rejoso.sch.id/debug-instagram-save.html
   ```

2. **Fill the form:**
   - Access Token: [paste token dari OAuth]
   - User ID: [paste user ID dari OAuth]
   - Sync Frequency: 30
   - Cache Duration: 3600

3. **Click "🧪 Test Save Settings"**

4. **Check the logs:**
   - ✅ GREEN = Success!
   - ❌ RED = Error (read the message)
   - ⚠️ ORANGE = Warning

5. **Screenshot** the debug logs and send to developer

---

### **Method 2: Browser Console (DETAILED)**

1. **Open Instagram Settings page**
2. **Open browser console** (F12 → Console tab)
3. **Clear console** (click trash icon)
4. **Fill Access Token & User ID**
5. **Click "Save Settings"**

**Expected console logs:**
```javascript
🚀 Instagram Settings JS Loaded
📋 Form elements: {form: true, testBtn: true, saveBtn: true, ...}
📝 Form submit event triggered
✅ Default prevented - processing form
✅ Validation passed, proceeding to save
Form data: {has_access_token: true, has_user_id: true, ...}
Save response status: 200
Save response data: {success: true, ...}
```

**If you see errors:**
- Screenshot the EXACT error message
- Send to developer

---

### **Method 3: Server Logs (BACKEND)**

SSH ke server dan run:

```bash
# Follow laravel log in real-time
tail -f storage/logs/laravel-$(date +%Y-%m-%d).log
```

**Then try to save** from browser.

**Expected log output:**
```
📥 Instagram Settings Store - Request received
✅ Validation passed
🔍 Testing Instagram connection...
✅ Connection test passed
💾 Saving settings WITH tokens to database...
✅ Settings saved to database
🗑️ Cache cleared
🎉 Save complete - returning success response
```

**If you see errors:**
- ❌ Read the error message
- Screenshot and send to developer

---

## 🎯 Common Issues & Solutions

### Issue 1: Console shows "❌ Form not found!"

**Solution:**
```bash
# Clear cache
php artisan view:clear
php artisan cache:clear

# Rebuild assets
npm run build

# Hard refresh browser
Ctrl + Shift + R
```

---

### Issue 2: Network tab shows 419 CSRF error

**Solution:**
- Refresh page (F5)
- Try save again
- CSRF token auto-refreshes

---

### Issue 3: Response is HTML (not JSON)

**Possible causes:**
1. Session expired → Login again
2. Middleware blocked request → Check user role
3. Server error → Check `storage/logs/laravel.log`

---

### Issue 4: Success response but data not saved

**Debug:**
```bash
# Check database directly
php artisan tinker
>>> App\Models\InstagramSetting::first()
```

**If null:**
```sql
-- Check database manually
SELECT * FROM instagram_settings WHERE id = 1;
```

**If exists but old data:**
- Check `updated_at` timestamp
- If not updating → Database write permission issue

---

### Issue 5: JavaScript not executing

**Debug:**
```javascript
// Paste in console:
console.log('Form:', document.getElementById('instagramSettingsForm'));
console.log('Save Btn:', document.getElementById('saveSettingsBtn'));
console.log('Test Btn:', document.getElementById('testConnectionBtn'));
```

**Expected:**
```javascript
Form: <form id="instagramSettingsForm">...</form>
Save Btn: <button id="saveSettingsBtn">...</button>
Test Btn: <button id="testConnectionBtn">...</button>
```

**If null:**
- View file corrupted
- Clear view cache: `php artisan view:clear`

---

## 📊 Full Diagnostic Checklist

Run these commands on server:

```bash
# 1. Check config
php artisan tinker
>>> config('services.instagram.app_id')
# Should return: "1575539400487129"

# 2. Check database connection
>>> DB::connection()->getPdo()
# Should return: PDO object (no error)

# 3. Check instagram_settings table
>>> App\Models\InstagramSetting::count()
# Should return: 0 or 1

# 4. Check user authentication
>>> Auth::id()
# Should return: your user ID (not null)

# 5. Check write permissions
>>> Storage::disk('local')->put('test.txt', 'test')
# Should return: true
```

---

## 🔧 Emergency Fix: Manual Database Insert

If all else fails, insert manually:

```sql
INSERT INTO instagram_settings (
    id,
    access_token,
    user_id,
    sync_frequency,
    cache_duration,
    auto_sync_enabled,
    is_active,
    token_expires_at,
    created_at,
    updated_at
) VALUES (
    1,
    'YOUR_ACCESS_TOKEN_HERE',
    'YOUR_USER_ID_HERE',
    30,
    3600,
    1,
    1,
    DATE_ADD(NOW(), INTERVAL 60 DAY),
    NOW(),
    NOW()
) ON DUPLICATE KEY UPDATE
    access_token = VALUES(access_token),
    user_id = VALUES(user_id),
    is_active = 1,
    token_expires_at = VALUES(token_expires_at),
    updated_at = NOW();
```

---

## 📝 Debug Log Locations

1. **Laravel Log:**
   ```
   storage/logs/laravel-YYYY-MM-DD.log
   ```

2. **Web Server Log:**
   ```
   /var/log/nginx/error.log (Nginx)
   /var/log/apache2/error.log (Apache)
   ```

3. **Browser Console:**
   - F12 → Console tab
   - Preserve log: Check the checkbox

---

## 🚨 Critical Debugging Info to Collect

When reporting issue, provide:

1. ✅ Browser console screenshot (full logs)
2. ✅ Network tab screenshot (POST request)
3. ✅ Server log excerpt (last 50 lines)
4. ✅ Output from debug tool
5. ✅ Result of: `php artisan tinker` → `InstagramSetting::first()`

---

**Status:** Extensive logging added. Ready for deep debugging! 🔍

