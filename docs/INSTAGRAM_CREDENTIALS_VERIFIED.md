# ✅ Instagram API Credentials - VERIFIED & WORKING

**Tested:** October 25, 2025  
**Status:** 200 OK - TOKEN VALID ✅  
**Test File:** `test-correct-credentials.php`

---

## 📋 Verified Credentials

```env
INSTAGRAM_APP_ID=1575539400487129
INSTAGRAM_APP_SECRET=7b6f727ebfd70393214e92b9b93676c3
INSTAGRAM_ACCESS_TOKEN=IGAAWY8dpLsNlBZAFRiZA3JvZAEN3YzI2c0pUMFZAvNG9qMnJoMGlKY3UySjZAUOFlwYlFDSWpxUjFBc3kxbW80U2xMSVBNWGdVRk5LZAl9DODExcjRTWFdIdF94T3F1R1h3UXF0eFlFOURKbTJtY2s5WmI1UWI1Um1CMGlkZAFFieEd5bwZDZD
INSTAGRAM_USER_ID=24902668946090754
INSTAGRAM_WEBHOOK_VERIFY_TOKEN=mySchoolWebhook2025
```

---

## 🎯 Instagram Account Info

| Field | Value |
|-------|-------|
| **Username** | wahyudedik6 |
| **Name** | Wahyu Dedik |
| **Account Type** | BUSINESS |
| **Media Count** | 2 |
| **Business Account ID** | 24902668946090754 |

---

## ⚠️ IMPORTANT: Credential Confusion Resolved

### ❌ Previous Wrong Credentials:
```
Meta App ID: 849587954405408        ← Parent App (WRONG for API calls)
Meta App Secret: dfbff8e358352a4a... ← Parent App Secret (WRONG)
Instagram User ID: 17841428646148329 ← Tester ID (WRONG)
```

### ✅ Correct Credentials (NOW VERIFIED):
```
Instagram App ID: 1575539400487129        ← Child Instagram App (CORRECT!)
Instagram App Secret: 7b6f727ebfd70393... ← Instagram App Secret (CORRECT!)
Instagram User ID: 24902668946090754      ← Business Account ID (CORRECT!)
```

**Key Learning:**
- Meta has a **Parent App** (849587954405408) that contains products
- Instagram is a **Product/Child App** with its own credentials (1575539400487129)
- API calls must use the **Instagram App credentials**, not Meta App!
- Instagram Tester ID ≠ Instagram Business Account ID

---

## 🚀 Next Steps

### Step 1: Update Local .env

**Edit your `.env` file** and add/update these lines:

```env
INSTAGRAM_APP_ID=1575539400487129
INSTAGRAM_APP_SECRET=7b6f727ebfd70393214e92b9b93676c3
INSTAGRAM_ACCESS_TOKEN=IGAAWY8dpLsNlBZAFRiZA3JvZAEN3YzI2c0pUMFZAvNG9qMnJoMGlKY3UySjZAUOFlwYlFDSWpxUjFBc3kxbW80U2xMSVBNWGdVRk5LZAl9DODExcjRTWFdIdF94T3F1R1h3UXF0eFlFOURKbTJtY2s5WmI1UWI1Um1CMGlkZAFFieEd5bwZDZD
INSTAGRAM_USER_ID=24902668946090754
INSTAGRAM_WEBHOOK_VERIFY_TOKEN=mySchoolWebhook2025
```

**Then run:**
```bash
php artisan config:clear
php artisan cache:clear
```

### Step 2: Test in Local Laravel

1. **Start Laravel server:**
   ```bash
   php artisan serve
   ```

2. **Open browser:**
   ```
   https://ig-to-web.test/admin/superadmin/instagram-settings
   ```

3. **Fill form with verified credentials above**

4. **Click "Test Connection"** → Should see:
   ```
   ✅ Connection successful!
   Username: wahyudedik6
   Account Type: BUSINESS
   ```

5. **Click "Save Settings"** → Should see:
   ```
   ✅ Instagram settings saved successfully!
   Token expires: [60 days from now]
   ```

6. **Test Feed:**
   - Click "View Feed" or navigate to `/kegiatan`
   - Should see 2 Instagram posts from wahyudedik6

### Step 3: Run Migration (if needed)

If you haven't run the new Instagram migrations:

```bash
php artisan migrate
```

This will add the new fields:
- `username`
- `account_type`
- `token_expires_at`
- `webhook_verify_token`

### Step 4: Deploy to VPS

1. **Push to Git:**
   ```bash
   git add .
   git commit -m "Update Instagram API credentials - verified working"
   git push origin main
   ```

2. **On VPS, pull changes:**
   ```bash
   cd /path/to/your/app
   git pull origin main
   ```

3. **Update VPS .env:**
   ```bash
   nano .env
   ```
   Add the same credentials as above.

4. **Run migrations on VPS:**
   ```bash
   php artisan migrate
   php artisan config:clear
   php artisan cache:clear
   php artisan optimize
   ```

5. **Test on VPS:**
   - Login: `https://maudu-rejoso.sch.id/admin/superadmin/instagram-settings`
   - Form should auto-populate if you already saved locally
   - Test Connection → Should succeed
   - View Feed: `https://maudu-rejoso.sch.id/kegiatan`

---

## 🔐 Security Notes

### Access Token Lifespan
- **Type:** Long-lived User Access Token
- **Expires:** ~60 days from generation
- **Renewal:** Must regenerate in Meta Dashboard before expiry
- **Laravel will warn you** when token expires in 7 days

### Webhook Security
- **Verify Token:** `mySchoolWebhook2025` (customizable in .env)
- **Signature Verification:** Enabled (using App Secret)
- **CSRF Exemption:** Webhook endpoint excluded from CSRF check

### .env Security
- ⚠️ **NEVER commit .env to Git**
- ✅ `.env` is in `.gitignore`
- 🔒 Keep App Secret confidential
- 🔄 Rotate tokens regularly

---

## 📚 Related Documentation

- [Instagram Setup Guide](./instagram-setup.blade.php)
- [Pre-Deployment Checklist](./PRE_DEPLOYMENT_CHECKLIST.md)
- [Instagram Phase 2 Summary](./INSTAGRAM_PHASE2_SUMMARY.md)
- [Webhook Implementation](./INSTAGRAM_WEBHOOK_IMPLEMENTATION.md)

---

## ✅ Verification Test Results

**Test Date:** October 25, 2025  
**Test Script:** `test-correct-credentials.php`  
**Test Command:** `php test-correct-credentials.php`

```
===========================================
   TEST INSTAGRAM CREDENTIALS - FINAL
===========================================

Credentials:
Instagram App ID: 1575539400487129
Instagram App Secret: 7b6f727ebfd70393214e...
Instagram User ID: 24902668946090754
Access Token: IGAAWY8dpLsNlBZAFRiZA3JvZAEN3YzI2c0pUMFZAvNG9qMnJo...
Token Length: 183

Testing connection...
Status Code: 200

✅✅✅ SUCCESS! TOKEN VALID! ✅✅✅

===========================================
📋 INSTAGRAM ACCOUNT INFO:
===========================================
Username: wahyudedik6
Name: Wahyu Dedik
Account Type: BUSINESS
Media Count: 2
Business Account ID: 24902668946090754
===========================================

✅ READY TO USE!
```

---

## 🎉 Summary

✅ All credentials verified and working  
✅ Token is valid and active  
✅ Instagram Business Account confirmed  
✅ 2 media posts available  
✅ Webhook endpoint configured  
✅ Ready for deployment to VPS  

**Status:** 🟢 PRODUCTION READY

