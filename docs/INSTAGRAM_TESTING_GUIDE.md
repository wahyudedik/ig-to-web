# Instagram Settings Testing Guide - October 25, 2025

## ✅ **KREDENSIAL YANG BENAR** (dari User)

```
App ID: 1575539400487129
App Secret: 7b6f727ebfd70393214e92b9b93676c3
Instagram Username: wahyudedik6
Instagram Account ID: 17841428646148329
Access Token: IGAAWY8dpLsNlBZAFNMYlNxYklpMEw1bzcxNmJyOHFqOXNmVmRPRmJIMmdqYXloT2RlT21Vel9BREpKVVdhMkk0dG1XVWFYclBlV2xNY2dnWWVieXpVaGhlcnhFY185a1ZAUM2hMeHVxM1V6dTgyNFRHVXVmNk0wdXU4R0h2cFFZAMAZDZD
```

---

## 🧪 **TESTING CHECKLIST**

### **Pre-Testing Setup:**

1. **Clear Browser Cache** (Ctrl+Shift+Delete)
2. **Hard Refresh** (Ctrl+Shift+R)
3. **Open Console** (F12) untuk monitoring
4. **Open Network Tab** (F12 → Network)

---

## 📝 **TEST 1: Form Loading & Field Population**

### **Steps:**
1. Buka: `https://maudu-rejoso.sch.id/admin/superadmin/instagram-settings`
2. Periksa field-field form

### **Expected Results:**
- ✅ Form ter-load sempurna
- ✅ Semua input field visible
- ✅ Button "Test Connection", "Reset", "Save Settings" visible
- ✅ Redirect URI auto-filled: `https://maudu-rejoso.sch.id/instagram/callback`
- ✅ Webhook URL ditampilkan: `https://maudu-rejoso.sch.id/instagram/webhook`

### **If Button "Reset" Tidak Terlihat:**
- **Scroll ke bawah** form sampai ke bagian bawah
- **Zoom out browser** (Ctrl + Mouse wheel)
- Button Reset ada di sebelah kanan, di antara "Test Connection" dan "Save Settings"

---

## 📝 **TEST 2: Reset Button**

### **Steps:**
1. Isi semua field dengan data dummy
2. Klik button **"Reset"**

### **Expected Results:**
- ✅ SweetAlert confirm muncul: "Apakah Anda yakin ingin mereset form?"
- ✅ Klik "Ya, Reset"
- ✅ Form direset ke nilai awal/kosong
- ✅ SweetAlert success: "Form berhasil direset"

### **Console Log Expected:**
```
Konfirmasi
Apakah Anda yakin ingin mereset form?
```

---

## 📝 **TEST 3: Test Connection Button**

### **Steps:**
1. Isi form dengan kredensial yang BENAR:
   ```
   Access Token: IGAAWY8dpLsNlBZAFNMYlNxYklpMEw1bzcxNmJyOHFqOXNmVmRPRmJIMmdqYXloT2RlT21Vel9BREpKVVdhMkk0dG1XVWFYclBlV2xNY2dnWWVieXpVaGhlcnhFY185a1ZAUM2hMeHVxM1V6dTgyNFRHVXVmNk0wdXU4R0h2cFFZAMAZDZD
   User ID: 17841428646148329
   App ID: 1575539400487129
   App Secret: 7b6f727ebfd70393214e92b9b93676c3
   ```

2. **PENTING: Pastikan NO SEMICOLON di akhir Access Token!**

3. Klik button **"Test Connection"**

### **Expected Results:**
- ✅ Button berubah jadi "Testing..." dengan spinner
- ✅ Loading modal muncul: "Menguji koneksi... Menghubungi Instagram API"
- ✅ Loading modal hilang setelah 2-5 detik
- ✅ SweetAlert success: "Koneksi Berhasil!"
- ✅ Modal info account muncul:
  ```
  Username: wahyudedik6
  Account Type: BUSINESS atau CREATOR
  Media Count: (jumlah post)
  ```
- ✅ Button kembali ke "Test Connection"

### **Console Log Expected:**
```
Test Connection clicked { accessToken: "Set (length: 205)", userId: "Set: 17841428646148329" }
Response status: 200
Response data: { success: true, message: "...", account_info: {...} }
```

### **If Error:**
- **Lihat Console** untuk error details
- **Lihat Network Tab** → cari request `test-connection`
- **Klik request** → lihat Response dan Preview

---

## 📝 **TEST 4: Save Settings Button**

### **Steps:**
1. **Pastikan Test Connection sudah SUCCESS dulu!**
2. Semua field terisi dengan benar
3. Klik button **"Save Settings"**

### **Expected Results:**
- ✅ Button berubah jadi "Saving..." dengan spinner
- ✅ Loading modal muncul: "Menyimpan pengaturan... Mohon tunggu"
- ✅ Loading modal hilang setelah 2-5 detik
- ✅ SweetAlert success: "Pengaturan Tersimpan!"
- ✅ Page reload otomatis (URL bersih tanpa parameter)
- ✅ **Status berubah jadi "Active"** di bagian atas
- ✅ Menampilkan:
  ```
  Active - Connected as @wahyudedik6
  BUSINESS/CREATOR badge
  Last sync: X minutes ago
  Token valid until: (tanggal 60 hari ke depan)
  ```
- ✅ Button "Sync Now" dan "Deactivate" muncul

### **Console Log Expected:**
```
Save Settings form submitted
Form data: { access_token: "Set (length: 205)", user_id: "17841428646148329", ... }
Save response status: 200
Save response data: { success: true, message: "..." }
```

### **If Error:**
- **Lihat Console** untuk error details
- **Lihat Network Tab** → cari request `store`
- **Check `storage/logs/laravel.log`** untuk server-side errors

---

## 📝 **TEST 5: Sync Now Button**

### **Steps:**
1. **Hanya muncul jika Status = "Active"**
2. Klik button **"Sync Now"**

### **Expected Results:**
- ✅ Button berubah jadi "Syncing..." dengan spinner
- ✅ Loading modal muncul
- ✅ SweetAlert success: "Instagram data synced successfully!"
- ✅ Page reload
- ✅ "Last sync" timestamp updated

---

## 📝 **TEST 6: Deactivate Button**

### **Steps:**
1. **Hanya muncul jika Status = "Active"**
2. Klik button **"Deactivate"**

### **Expected Results:**
- ✅ SweetAlert confirm: "Apakah Anda yakin ingin menonaktifkan integrasi Instagram?"
- ✅ Klik "Ya, Nonaktifkan"
- ✅ SweetAlert success
- ✅ Page reload
- ✅ Status berubah jadi "Inactive"
- ✅ Button "Sync Now" dan "Deactivate" hilang

---

## 📝 **TEST 7: View Feed**

### **Steps:**
1. Klik button **"View Feed"** di header
2. Atau buka: `https://maudu-rejoso.sch.id/kegiatan`

### **Expected Results:**
- ✅ Halaman Instagram feed terbuka
- ✅ Menampilkan post-post dari @wahyudedik6
- ✅ Gambar, caption, likes, comments visible
- ✅ Button "Refresh" berfungsi

---

## 🐛 **COMMON ERRORS & FIXES**

### **Error 1: "Harap isi Access Token dan User ID"**
**Cause:** Field kosong atau tidak terdeteksi oleh JavaScript

**Fix:**
1. Hard refresh (Ctrl+Shift+R)
2. Clear browser cache
3. Pastikan tidak ada ad-blocker yang block JavaScript
4. Cek Console untuk JavaScript errors

---

### **Error 2: "Koneksi Gagal" saat Test Connection**
**Cause:** Access Token salah, expired, atau ada semicolon

**Fix:**
1. **Periksa Access Token** - TIDAK BOLEH ada semicolon (`;`) di akhir!
2. **Generate token baru** di Meta Dashboard jika expired
3. **Periksa User ID** - harus `17841428646148329` (bukan username!)
4. Cek `storage/logs/laravel.log` untuk detail error

---

### **Error 3: "Invalid Instagram credentials" saat Save**
**Cause:** Token atau User ID tidak valid di Instagram API

**Fix:**
1. **Test Connection dulu** sebelum Save
2. Pastikan akun Instagram adalah **Professional Account** (Business/Creator)
3. Pastikan App sudah di-approve oleh Instagram di Meta Dashboard
4. Pastikan akun Instagram sudah jadi "Tester" di Meta Dashboard

---

### **Error 4: Button tidak responsif / tidak terjadi apa-apa**
**Cause:** JavaScript tidak ter-load atau ada error

**Fix:**
1. **Buka Console (F12)** → lihat error messages
2. **Hard refresh** (Ctrl+Shift+R)
3. **Check `resources/js/app.js`** sudah ter-compile:
   ```bash
   npm run build
   ```
4. **Check vite manifest**:
   ```
   ls -la public/build/manifest.json
   ```

---

### **Error 5: "403 Forbidden" atau "CORS error"**
**Cause:** Meta memblokir request dari domain yang tidak ter-register

**Fix:**
1. **Pastikan Redirect URI** di Meta Dashboard = `https://maudu-rejoso.sch.id/instagram/callback`
2. **Pastikan domain** sudah di-whitelist di Meta Dashboard
3. **Pastikan App Secret** benar: `7b6f727ebfd70393214e92b9b93676c3`

---

## 🔍 **DEBUGGING TOOLS**

### **1. Browser Console (F12 → Console)**
Lihat log messages:
```
Test Connection clicked
Response status: 200
Response data: {...}
```

### **2. Browser Network Tab (F12 → Network)**
Filter: `XHR` atau `Fetch`
- Cari request: `test-connection`, `store`, `sync`, `deactivate`
- Klik request → lihat:
  - **Headers**: Request URL, Method, Status
  - **Payload**: Data yang dikirim
  - **Response**: Data yang diterima
  - **Preview**: JSON formatted

### **3. Laravel Logs**
```bash
tail -f storage/logs/laravel.log
```

Atau di Windows:
```powershell
Get-Content storage/logs/laravel.log -Tail 50 -Wait
```

### **4. Database Check**
```sql
SELECT * FROM instagram_settings ORDER BY id DESC LIMIT 1;
```

Expected columns:
- `access_token`
- `user_id` = 17841428646148329
- `username` = wahyudedik6
- `account_type` = BUSINESS atau CREATOR
- `is_active` = 1
- `token_expires_at` = (60 hari dari sekarang)

---

## 📊 **SUCCESS INDICATORS**

### **Visual Indicators:**
- ✅ Status badge: "Active - Connected as @wahyudedik6"
- ✅ Green indicator dot (animated pulse)
- ✅ Token validity: "Token valid until [date]"
- ✅ Button "Sync Now" dan "Deactivate" visible

### **Functional Indicators:**
- ✅ Test Connection returns account info
- ✅ Save Settings succeeds without errors
- ✅ Page reload with clean URL
- ✅ Settings persisted in database
- ✅ `/kegiatan` page shows Instagram posts

### **Database Indicators:**
```sql
-- Check if settings saved
SELECT 
  id,
  user_id,
  username,
  account_type,
  is_active,
  token_expires_at,
  created_at,
  updated_at
FROM instagram_settings 
WHERE is_active = 1;
```

Expected result:
```
id: 1
user_id: 17841428646148329
username: wahyudedik6
account_type: BUSINESS
is_active: 1
token_expires_at: 2025-12-24 (60 days from now)
```

---

## 🚀 **FINAL VERIFICATION**

### **Checklist Sebelum Deploy ke VPS:**

- [ ] Test Connection → **SUCCESS**
- [ ] Save Settings → **SUCCESS**
- [ ] Status → **Active**
- [ ] Username → **@wahyudedik6**
- [ ] Token expiry → **Valid for 60 days**
- [ ] Reset button → **Berfungsi**
- [ ] Sync button → **Berfungsi**
- [ ] Deactivate button → **Berfungsi**
- [ ] `/kegiatan` → **Shows Instagram posts**
- [ ] No JavaScript errors in Console
- [ ] No linter errors
- [ ] All assets compiled (`npm run build`)
- [ ] Cache cleared (`php artisan optimize:clear`)

---

**Testing Date**: October 25, 2025  
**Tester**: Super Administrator  
**Environment**: `maudu-rejoso.sch.id`  
**Status**: Ready for Testing 🎯

