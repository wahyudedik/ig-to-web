# 📖 Cara Menggunakan Instagram Settings

**URL:** https://ig-to-web.test/admin/superadmin/instagram-settings  
**Untuk:** Setup integrasi Instagram ke website sekolah  
**Waktu:** ~5 menit

---

## 🎯 Ada 2 Cara Setup:

### **Cara A: OAuth (RECOMMENDED)** ⚡ - Otomatis & Mudah
- ✅ Hanya butuh App ID & App Secret
- ✅ Token didapat otomatis (60 hari)
- ✅ Satu klik, selesai!

### **Cara B: Manual** ⌨️ - Manual Entry
- ⚠️ Harus cari Access Token & User ID sendiri
- ⚠️ Lebih ribet

**Saya jelaskan Cara A (OAuth) yang paling mudah:**

---

## 📋 PERSIAPAN (Sebelum Mulai)

### 1. **Dapatkan App ID & App Secret dari Meta**

**Langkah:**

a. Buka: https://developers.facebook.com/apps

b. Login dengan Facebook account yang punya Instagram Business/Creator

c. Pilih app Anda (atau buat baru jika belum punya)

d. Di sidebar kiri, pilih: **Settings** → **Basic**

e. **Copy 2 info ini:**
   ```
   App ID: [copy angka ini]
   App Secret: [click "Show" lalu copy]
   ```

f. **PENTING - Configure OAuth Redirect:**
   - Scroll ke bawah ke section "Add Platform"
   - Click "Website"
   - Isi URL: `https://ig-to-web.test/instagram/callback`
   - Atau di section Instagram product: 
     - Go to "Instagram" → "Business Login Settings"
     - Add OAuth Redirect URI: `https://ig-to-web.test/instagram/callback`
   - **SAVE!**

### 2. **Login ke Admin Panel**

```
URL: https://ig-to-web.test/login
Email: [email superadmin Anda]
Password: [password]
```

---

## 🚀 LANGKAH-LANGKAH SETUP (OAuth Mode)

### **STEP 1: Buka Instagram Settings**

```
URL: https://ig-to-web.test/admin/superadmin/instagram-settings
```

**Yang Anda lihat:**
- Header: "Instagram Integration"
- Status: "Not Connected"
- Form dengan beberapa card

### **STEP 2: Fokus ke Card 2 (App Configuration)**

**Scroll ke bawah sampai Anda lihat card dengan:**
- Border **PURPLE** (ungu)
- Badge: "REQUIRED FOR OAUTH"
- Title: "App Configuration"
- Ada info box dengan langkah 1-5

### **STEP 3: ISI HANYA Card 2**

**Di Card 2 (purple border), isi:**

```
App ID: [paste App ID dari Meta Dashboard]
App Secret: [paste App Secret dari Meta Dashboard]
```

**Contoh:**
```
App ID: 1575539400487129
App Secret: 7b6f727ebfd70393214e92b9b93676c3
```

⚠️ **JANGAN ISI Card 1** (Access Token & User ID) - biarkan kosong!

### **STEP 4: Isi Card Lainnya (Optional)**

**Card 3 (Webhook Configuration) - optional:**
```
Redirect URI: https://ig-to-web.test/instagram/callback (sudah terisi)
Webhook Verify Token: mySchoolWebhook2025 (sudah terisi)
```

**Card 4 (Sync & Cache Settings):**
```
Sync Frequency: Every 30 minutes (biarkan default)
Cache Duration: 1 hour (biarkan default)
Auto Sync: Enable (centang)
```

### **STEP 5: Save Settings - PERTAMA KALI**

**Lokasi button:**
- Scroll ke paling bawah form
- Ada 3 button: **Test Connection**, **Reset**, **Save Settings**
- Click button **biru** "Save Settings"

**Yang HARUS terjadi:**

1. **Browser Console (F12) menunjukkan:**
   ```
   🚀 Instagram Settings JS Loaded
   📋 Form elements: {form: true, ...}
   📝 Form submit event triggered
   ✅ Default prevented - processing form
   Setup mode: {isOAuthSetup: true, ...}
   ```

2. **Loading popup muncul:**
   ```
   "Saving OAuth Configuration..."
   "Preparing for authorization"
   ```

3. **Success Alert (SweetAlert2) muncul:**
   ```
   ✅ App Credentials Saved!
   
   App credentials saved! Please refresh and click...
   
   Next Steps:
   1. Refresh this page (F5)
   2. Look for purple "Connect with Instagram" button
   3. Click it to authorize
   
   [Refresh Now button]
   ```

**⚠️ JIKA TIDAK ADA ALERT:**
- Buka Console (F12)
- Lihat error merah
- Screenshot & kirim ke developer
- [Lompat ke section TROUBLESHOOTING di bawah]

### **STEP 6: Refresh Halaman**

**Option 1:** Click button "Refresh Now" di alert

**Option 2:** Tekan **F5** atau **Ctrl+R**

**Option 3:** Click logo di navigation bar

### **STEP 7: Lihat Button "Connect with Instagram"**

**Setelah refresh, Anda HARUS lihat:**

Di bagian **ATAS**, setelah info alert "Using Instagram Business Login":

```
┌─────────────────────────────────────────────────────┐
│  ⚡ Quick Setup (Recommended)                       │
│  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━  │
│  Authorize with Instagram Business Login            │
│  to automatically get your 60-day access token      │
│                                                     │
│  [🎨 Connect with Instagram]  [⌨️ Or enter manually] │
│                                                     │
│  🛡️ New scopes (Jan 27, 2025 update):              │
│  instagram_business_basic, ...                      │
└─────────────────────────────────────────────────────┘
```

**⚠️ JIKA BUTTON TIDAK MUNCUL:**
- Check: Apakah App ID tersimpan? (lihat Card 2)
- Check: Apakah sudah refresh?
- Check: Apakah save success? (ada alert?)
- [Lompat ke TROUBLESHOOTING]

### **STEP 8: Click "Connect with Instagram"**

**Click button PURPLE GRADIENT yang besar:**
```
[🎨 Connect with Instagram]
```

**Yang terjadi:**
1. Redirect ke Instagram.com
2. Minta Anda login (jika belum login)
3. Minta Anda pilih Instagram Business/Creator account
4. Minta permission untuk app

### **STEP 9: Authorize di Instagram**

**Di halaman Instagram:**

1. **Login** dengan account yang terhubung ke Facebook Page
2. **Pilih Instagram Business/Creator account** Anda
3. **Review permissions** yang diminta:
   - instagram_business_basic ✅
   - instagram_business_content_publish ✅
   - instagram_business_manage_comments ✅
   - instagram_business_manage_messages ✅
4. Click **"Continue"** atau **"Allow"**

**⚠️ JIKA ERROR "Invalid Redirect URI":**
- App configuration di Meta Dashboard salah
- Go back to Meta Dashboard
- Check OAuth Redirect URI = `https://ig-to-web.test/instagram/callback`
- Must match EXACTLY!

### **STEP 10: Redirect Kembali ke Website**

**Setelah authorize, Instagram akan redirect Anda kembali ke:**
```
https://ig-to-web.test/admin/superadmin/instagram-settings
```

**Dengan alert SUCCESS hijau:**
```
✅ Authorization Successful!

Permissions granted: instagram_business_basic,instagram_business_content_publish,...
Token valid for: 60 days

Now click "Test Connection" below, then "Save Settings"
```

**Dan yang PENTING:**

**Card 1 (Access Credentials) OTOMATIS TERISI:**
```
Access Token: IGAAW... [long token - sudah terisi!]
Instagram User ID: 17841... [sudah terisi!]
```

### **STEP 11: Test Connection**

Scroll ke bawah ke button **"Test Connection"** (orange)

Click button tersebut.

**Loading muncul:**
```
"Menguji koneksi..."
"Menghubungi Instagram API"
```

**Success Alert:**
```
✅ Koneksi Berhasil!

Instagram connection successful!

[Popup info account:]
Username: @your_instagram_username
Account Type: BUSINESS
Followers: 1234
Media Count: 56
```

**⚠️ JIKA ERROR:**
```
❌ Koneksi Gagal
Invalid Instagram credentials...
```
- Token mungkin sudah expired
- User ID salah
- Network error
- [Lompat ke TROUBLESHOOTING]

### **STEP 12: Save Settings - KEDUA KALI**

Click button **"Save Settings"** (biru) lagi.

**Loading:**
```
"Menyimpan pengaturan..."
"Mohon tunggu"
```

**Success Alert:**
```
✅ Pengaturan Tersimpan!

Instagram settings saved successfully! 
Token will expire on [date 60 hari dari sekarang]
```

**Page auto-refresh.**

### **STEP 13: Verifikasi Status "Connected"**

**Di bagian atas page, Anda harus lihat:**

```
┌─────────────────────────────────────────────┐
│ [✅] Connected                              │
│     BUSINESS                                │
│     @your_instagram_username                │
│     Last sync: Just now                     │
│                                             │
│     [Sync]  [Disconnect]                    │
├─────────────────────────────────────────────┤
│ ✅ Token valid until [date]                 │
└─────────────────────────────────────────────┘
```

**Status Card:**
- Icon: ✅ Green Instagram icon dengan pulse dot
- Status: **"Connected"**
- Username: **@your_account**
- Account Type: **BUSINESS** atau **CREATOR**
- Last sync: **timestamp**
- Token status: **Green bar** "Token valid until..."

**🎉 SELESAI! Instagram sudah terkoneksi!**

---

## 🧪 TESTING

### **Test 1: Manual Sync**

Click button **"Sync"** (hijau) di status card.

**Loading:** "Syncing Instagram data..."

**Success:** 
```
✅ Sync Berhasil!
Instagram data synced successfully!
Last sync updated.
```

### **Test 2: Lihat Posts di Website**

**Buka halaman public:**
```
https://ig-to-web.test/kegiatan
```

**Atau click button "Feed" di header.**

**Harus menampilkan:** Instagram posts terbaru dari account Anda.

### **Test 3: Check Token Expiry**

**Di Instagram Settings page:**
- Token status bar harus **green**
- Text: "Token valid until [60 hari dari sekarang]"

**Jika amber (< 7 hari):** Token akan expired soon, perlu refresh.

**Jika red (expired):** Token sudah mati, harus reconnect.

---

## 🐛 TROUBLESHOOTING

### **Problem 1: No Alert After Save**

**Symptom:** Click "Save Settings", tidak ada popup, page redirect ke URL dengan query params

**Cause:** JavaScript tidak jalan

**Solution:**

1. **Buka Console (F12)**
2. **Refresh page**
3. **Look for:**
   ```
   🚀 Instagram Settings JS Loaded
   📋 Form elements: {form: true, ...}
   ```
4. **If NOT present:**
   - JavaScript error
   - Check for red errors in Console
   - Vite build issue

5. **Test SweetAlert:**
   ```javascript
   Swal.fire('Test', 'Working?', 'success')
   ```
   If error "Swal is not defined" → SweetAlert not loaded

6. **Fix:**
   ```bash
   cd /path/to/project
   npm run build
   php artisan cache:clear
   php artisan view:clear
   ```

### **Problem 2: Button "Connect with Instagram" Tidak Muncul**

**Symptom:** Setelah save & refresh, tidak ada button purple

**Cause:** 
- App ID tidak tersimpan
- Save tidak success
- Kondisi blade tidak terpenuhi

**Solution:**

1. **Check Database:**
   ```sql
   SELECT app_id, is_active FROM instagram_settings WHERE id = 1;
   ```
   - `app_id` harus ada nilai
   - `is_active` bisa 0 atau 1

2. **Check Blade Condition:**
   Kondisi button muncul:
   ```php
   $authorizationUrl (not false/null) 
   AND 
   NOT ($settings && $settings->is_active)
   ```

3. **Force Refresh:**
   - Hard refresh: Ctrl+Shift+R (Windows) / Cmd+Shift+R (Mac)
   - Clear browser cache
   - Try incognito mode

4. **Manual Check:**
   Di Console:
   ```javascript
   // Check if authorizationUrl passed to view
   console.log('Auth URL:', '{{ $authorizationUrl }}');
   // Should show Instagram OAuth URL, not empty
   ```

### **Problem 3: "Invalid Redirect URI" Error**

**Symptom:** Setelah click "Connect", Instagram error page

**Cause:** Redirect URI di Meta Dashboard tidak match

**Solution:**

1. **Go to Meta Dashboard:**
   https://developers.facebook.com/apps/[YOUR_APP_ID]

2. **Instagram Product → Business Login Settings**

3. **OAuth Redirect URIs:**
   ```
   MUST EXACTLY BE:
   https://ig-to-web.test/instagram/callback
   
   NOT:
   http://ig-to-web.test/instagram/callback  (http vs https)
   https://ig-to-web.test/instagram/callback/  (trailing slash)
   https://ig-to-web.test:8000/instagram/callback  (port)
   ```

4. **Save & Try Again**

### **Problem 4: Token Tidak Auto-Fill**

**Symptom:** Setelah authorize & redirect back, Card 1 masih kosong

**Cause:** OAuth callback tidak jalan atau error

**Solution:**

1. **Check URL setelah redirect:**
   ```
   Should be:
   https://ig-to-web.test/admin/superadmin/instagram-settings
   
   NOT:
   https://ig-to-web.test/instagram/callback?code=...
   ```

2. **Check Laravel Logs:**
   ```bash
   tail -f storage/logs/laravel.log | grep Instagram
   ```
   Look for:
   ```
   Instagram OAuth Callback Received
   Exchanging authorization code for access token
   ✅ Long-lived token obtained
   ```

3. **If errors in log:**
   - "Failed to exchange code" → Check App Secret
   - "Failed to exchange for long-lived token" → API error
   - Network timeout → Connection issue

4. **Manual Fix:**
   Get token from Graph API Explorer, paste manual

### **Problem 5: "Access Denied" dari Instagram**

**Symptom:** Instagram menolak authorization

**Cause:** 
- Account bukan Business/Creator
- App belum verified
- Permissions tidak disetujui

**Solution:**

1. **Check Instagram Account Type:**
   - Open Instagram app
   - Go to Settings → Account
   - Must be "Business Account" or "Creator Account"
   - If "Personal", convert first

2. **Check App Status:**
   - Development mode: Only works for accounts added as testers
   - Live mode: Works for all accounts
   - If testing: Add your Instagram account as "Test User"

3. **Grant All Permissions:**
   - Don't skip any permission
   - All 4 scopes must be granted

### **Problem 6: Connection Test Failed**

**Symptom:** "Invalid credentials" saat test

**Cause:**
- Token expired
- User ID salah
- Network issue
- Instagram API down

**Solution:**

1. **Verify Token Manually:**
   ```
   https://graph.instagram.com/me?fields=id,username&access_token=YOUR_TOKEN
   ```
   Should return JSON dengan username

2. **Check Token Expiry:**
   ```
   https://graph.instagram.com/debug_token?input_token=YOUR_TOKEN&access_token=YOUR_APP_TOKEN
   ```

3. **If expired:**
   - Reconnect dengan "Connect with Instagram" lagi
   - Or run: `php artisan instagram:refresh-token`

---

## 📊 CHECKLIST FINAL

Setelah semua langkah selesai, check:

- [ ] Status card menunjukkan **"Connected"** dengan ✅ green
- [ ] Username Instagram muncul di status card
- [ ] Account type (BUSINESS/CREATOR) terlihat
- [ ] Token status bar **green** (valid until...)
- [ ] Button "Sync" dan "Disconnect" ada
- [ ] Manual sync berhasil (click "Sync" button)
- [ ] Posts muncul di `/kegiatan` page
- [ ] Token expiry ~60 hari dari sekarang
- [ ] No errors di Console (F12)
- [ ] No errors di `storage/logs/laravel.log`

**Jika semua ✅ → SUKSES! 🎉**

---

## 🔄 AUTO REFRESH TOKEN

**Token akan auto-refresh every month.**

**Cron job (harus disetup di server):**
```bash
# Add to crontab
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

**Schedule:**
- Runs: **1st of every month at 02:00 AM**
- Command: `php artisan instagram:refresh-token`
- Log: `storage/logs/laravel.log`

**Manual refresh:**
```bash
php artisan instagram:refresh-token
```

---

## 📞 BUTUH BANTUAN?

**Jika masih stuck:**

1. **Screenshot:**
   - Halaman Instagram settings
   - Browser console (F12)
   - Alert/error yang muncul

2. **Check Logs:**
   ```bash
   tail -50 storage/logs/laravel.log
   ```

3. **Info yang perlu disertakan:**
   - Step mana yang stuck?
   - Error message?
   - Console log?
   - Laravel log?

4. **Contact Developer** dengan info di atas.

---

**Last Updated:** October 25, 2025  
**Version:** 3.0  
**Status:** ✅ Production Ready

