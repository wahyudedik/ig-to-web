# VPS Deployment Guide - Instagram Integration Update
**Date:** October 25, 2025  
**Update:** Instagram OAuth Callback & Form Field Fix

---

## 📦 **WHAT'S IN THIS UPDATE:**

### **New Features:**
- ✅ OAuth callback route: `/instagram/callback`
- ✅ Auto-populate form from URL parameters
- ✅ Enhanced error handling and logging
- ✅ Better form field validation

### **Bug Fixes:**
- ✅ Fixed form fields not populating from URL
- ✅ Fixed Redirect URI default value
- ✅ Fixed Blade template rendering issues

### **Documentation:**
- ✅ Instagram Testing Guide
- ✅ OAuth Callback Setup
- ✅ Debug Guide for form issues
- ✅ Final Implementation Summary

---

## 🚀 **VPS DEPLOYMENT STEPS:**

### **Step 1: SSH to VPS**

```bash
ssh your-user@your-vps-ip
# Or using domain:
ssh your-user@maudu-rejoso.sch.id
```

---

### **Step 2: Navigate to Project Directory**

```bash
cd /path/to/ig-to-web
# Example:
cd /var/www/ig-to-web
```

---

### **Step 3: Pull Latest Changes from GitHub**

```bash
# Ensure you're on main branch
git branch

# Pull latest changes
git pull origin main
```

**Expected Output:**
```
remote: Enumerating objects: 22, done.
remote: Counting objects: 100% (22/22), done.
remote: Compressing objects: 100% (12/12), done.
remote: Total 12 (delta 8), reused 0 (delta 0), pack-reused 0
Unpacking objects: 100% (12/12), done.
From https://github.com/wahyudedik/ig-to-web
 * branch            main       -> FETCH_HEAD
   ce408b4..ba85182  main       -> origin/main
Updating ce408b4..ba85182
Fast-forward
 app/Http/Controllers/InstagramController.php         | 68 ++++++++++++++++++++
 app/Http/Controllers/InstagramSettingController.php  | 16 ++++-
 resources/views/superadmin/instagram-settings.blade.php | 10 +--
 routes/web.php                                       | 3 +
 docs/DEBUG_FORM_EMPTY_ISSUE.md                       | 348 ++++++++++
 5 files changed, 438 insertions(+), 7 deletions(-)
 create mode 100644 docs/DEBUG_FORM_EMPTY_ISSUE.md
```

---

### **Step 4: Install/Update Dependencies**

```bash
# Install PHP dependencies (if any new packages)
composer install --no-dev --optimize-autoloader

# Install/Update Node dependencies
npm install

# Build frontend assets
npm run build
```

---

### **Step 5: Run Database Migrations**

```bash
# Check if there are pending migrations
php artisan migrate:status

# Run migrations (if any)
php artisan migrate --force
```

**Note:** `--force` is needed in production to bypass confirmation.

---

### **Step 6: Clear All Caches**

```bash
# Clear all Laravel caches
php artisan optimize:clear

# Or individually:
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
```

---

### **Step 7: Optimize for Production**

```bash
# Cache config for faster loading
php artisan config:cache

# Cache routes for faster loading
php artisan route:cache

# Cache views for faster loading
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

---

### **Step 8: Set Permissions**

```bash
# Ensure storage and cache are writable
chmod -R 775 storage bootstrap/cache

# Change owner to web server user (usually www-data or nginx)
chown -R www-data:www-data storage bootstrap/cache

# Or for nginx:
chown -R nginx:nginx storage bootstrap/cache
```

---

### **Step 9: Restart Services**

```bash
# For PHP-FPM (if using):
sudo systemctl restart php8.2-fpm
# Or:
sudo service php8.2-fpm restart

# For Nginx:
sudo systemctl restart nginx
# Or:
sudo service nginx restart

# For Apache:
sudo systemctl restart apache2
# Or:
sudo service apache2 restart

# For Queue Workers (if running):
php artisan queue:restart
# Or:
sudo supervisorctl restart ig-to-web-worker:*
```

---

### **Step 10: Verify Deployment**

```bash
# Check Laravel version
php artisan --version

# Check if routes are registered
php artisan route:list | grep instagram

# Check logs for any errors
tail -f storage/logs/laravel.log
```

**Expected Routes:**
```
GET|HEAD  instagram/callback ............ instagram.callback
GET|HEAD  instagram/webhook ............. instagram.webhook.verify
POST      instagram/webhook ............. instagram.webhook.handle
GET|HEAD  kegiatan ...................... public.kegiatan
```

---

## 🧪 **POST-DEPLOYMENT TESTING:**

### **Test 1: Check Application Health**

```bash
# Open in browser:
https://maudu-rejoso.sch.id

# Should load without errors
```

---

### **Test 2: Test Instagram Settings Page**

```bash
# Open in browser:
https://maudu-rejoso.sch.id/admin/superadmin/instagram-settings

# Expected:
# - Page loads successfully
# - All form fields visible
# - No JavaScript errors in Console (F12)
```

---

### **Test 3: Test OAuth Callback Route**

```bash
# Open in browser:
https://maudu-rejoso.sch.id/instagram/callback?access_token=TEST&user_id=12345

# Expected:
# - Should redirect to instagram-settings page
# - Should show success message (if token valid)
# - Check logs: tail -f storage/logs/laravel.log
```

---

### **Test 4: Test Form Auto-Population**

```bash
# Open in browser with full credentials:
https://maudu-rejoso.sch.id/admin/superadmin/instagram-settings?access_token=IGAAWY8dpLsNlBZAFNMYlNxYklpMEw1bzcxNmJyOHFqOXNmVmRPRmJIMmdqYXloT2RlT21Vel9BREpKVVdhMkk0dG1XVWFYclBlV2xNY2dnWWVieXpVaGhlcnhFY185a1ZAUM2hMeHVxM1V6dTgyNFRHVXVmNk0wdXU4R0h2cFFZAMAZDZD&user_id=17841428646148329

# Expected:
# - Form field "Access Token" auto-filled
# - Form field "User ID" auto-filled with 17841428646148329
# - Green alert: "Access Token Berhasil Didapatkan!"
```

---

### **Test 5: Test Connection & Save**

1. Fill form with credentials:
   ```
   Access Token: IGAAWY8dpLsNlBZAFNMYlNxYklpMEw1bzcxNmJyOHFqOXNmVmRPRmJIMmdqYXloT2RlT21Vel9BREpKVVdhMkk0dG1XVWFYclBlV2xNY2dnWWVieXpVaGhlcnhFY185a1ZAUM2hMeHVxM1V6dTgyNFRHVXVmNk0wdXU4R0h2cFFZAMAZDZD
   User ID: 17841428646148329
   App ID: 1575539400487129
   App Secret: 7b6f727ebfd70393214e92b9b93676c3
   ```

2. Click **"Test Connection"**
   - ✅ Should return success with account info

3. Click **"Save Settings"**
   - ✅ Should save successfully
   - ✅ Status changes to "Active"
   - ✅ Page reloads

---

### **Test 6: Verify Instagram Feed**

```bash
# Open in browser:
https://maudu-rejoso.sch.id/kegiatan

# Expected:
# - Instagram posts from @wahyudedik6 displayed
# - Images, captions, likes, comments visible
```

---

## 🔍 **TROUBLESHOOTING:**

### **Issue 1: "Permission denied" during git pull**

**Solution:**
```bash
# Check if you have write permissions
ls -la

# If not, use sudo:
sudo git pull origin main

# Or change ownership:
sudo chown -R $USER:$USER /path/to/ig-to-web
```

---

### **Issue 2: Composer dependencies fail**

**Solution:**
```bash
# Update composer:
composer self-update

# Clear composer cache:
composer clear-cache

# Retry:
composer install --no-dev --optimize-autoloader
```

---

### **Issue 3: npm build fails**

**Solution:**
```bash
# Check Node version (need 18+):
node -v

# If old, update Node:
curl -sL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Clear npm cache:
npm cache clean --force

# Remove node_modules and retry:
rm -rf node_modules package-lock.json
npm install
npm run build
```

---

### **Issue 4: Routes not found (404)**

**Solution:**
```bash
# Clear route cache:
php artisan route:clear

# Re-cache routes:
php artisan route:cache

# Verify routes exist:
php artisan route:list | grep instagram
```

---

### **Issue 5: Form still empty after update**

**Solution:**
```bash
# Clear ALL caches:
php artisan optimize:clear

# Restart PHP-FPM:
sudo systemctl restart php8.2-fpm

# Clear browser cache:
# In browser: Ctrl+Shift+Delete → Clear all

# Hard refresh:
# In browser: Ctrl+Shift+R
```

---

### **Issue 6: Logs show errors**

**Check logs:**
```bash
# Laravel logs:
tail -f storage/logs/laravel.log

# Nginx error logs:
sudo tail -f /var/log/nginx/error.log

# PHP-FPM logs:
sudo tail -f /var/log/php8.2-fpm.log
```

---

## ✅ **DEPLOYMENT CHECKLIST:**

### **Before Deployment:**
- [x] Code committed to GitHub
- [x] All tests passed locally
- [x] Documentation updated
- [x] .env configured for production

### **During Deployment:**
- [ ] SSH to VPS
- [ ] Navigate to project directory
- [ ] Pull latest changes (`git pull origin main`)
- [ ] Install dependencies (`composer install --no-dev`)
- [ ] Build assets (`npm run build`)
- [ ] Run migrations (`php artisan migrate --force`)
- [ ] Clear caches (`php artisan optimize:clear`)
- [ ] Optimize caches (`php artisan config:cache`, `route:cache`, `view:cache`)
- [ ] Set permissions (`chmod -R 775 storage bootstrap/cache`)
- [ ] Restart services (PHP-FPM, Nginx/Apache)

### **After Deployment:**
- [ ] Test application health (homepage loads)
- [ ] Test Instagram settings page
- [ ] Test OAuth callback route
- [ ] Test form auto-population
- [ ] Test connection & save
- [ ] Verify Instagram feed displays
- [ ] Check Laravel logs for errors
- [ ] Monitor for 15-30 minutes

---

## 📊 **MONITORING POST-DEPLOYMENT:**

### **1. Check Laravel Logs:**
```bash
# Watch logs in real-time:
tail -f storage/logs/laravel.log

# Search for Instagram-related logs:
grep "Instagram" storage/logs/laravel.log | tail -20

# Search for errors:
grep "ERROR" storage/logs/laravel.log | tail -20
```

### **2. Monitor Server Resources:**
```bash
# CPU and Memory:
htop

# Disk space:
df -h

# PHP-FPM processes:
ps aux | grep php-fpm
```

### **3. Test Key Endpoints:**
```bash
# Instagram settings (should return 200):
curl -I https://maudu-rejoso.sch.id/admin/superadmin/instagram-settings

# Instagram callback (should return 302 redirect):
curl -I https://maudu-rejoso.sch.id/instagram/callback

# Kegiatan feed (should return 200):
curl -I https://maudu-rejoso.sch.id/kegiatan
```

---

## 🔐 **SECURITY CHECKLIST:**

- [ ] `.env` has correct production values
- [ ] `APP_DEBUG=false` in production
- [ ] `APP_ENV=production`
- [ ] Database credentials secure
- [ ] Instagram `APP_SECRET` kept secret
- [ ] SSL certificate valid (HTTPS working)
- [ ] Firewall configured
- [ ] Only necessary ports open (80, 443, 22)

---

## 🎉 **SUCCESS CRITERIA:**

**✅ Deployment Successful If:**
1. Homepage loads without errors
2. Instagram settings page accessible
3. Form fields auto-populate from URL
4. Test Connection returns account info
5. Save Settings persists data
6. Status shows "Active - Connected as @wahyudedik6"
7. `/kegiatan` displays Instagram posts
8. No errors in Laravel logs
9. No 500 errors on any page
10. All assets (CSS, JS) loading correctly

---

## 📞 **ROLLBACK PLAN (If Something Goes Wrong):**

```bash
# 1. Revert to previous commit:
git log --oneline  # Find previous commit hash
git reset --hard <previous-commit-hash>

# 2. Clear caches:
php artisan optimize:clear

# 3. Restart services:
sudo systemctl restart php8.2-fpm nginx

# 4. If database changes:
php artisan migrate:rollback

# 5. Verify:
curl -I https://maudu-rejoso.sch.id
```

---

## 📚 **RELATED DOCUMENTATION:**

1. **Testing Guide:** `docs/INSTAGRAM_TESTING_GUIDE.md`
2. **Debug Guide:** `docs/DEBUG_FORM_EMPTY_ISSUE.md`
3. **OAuth Setup:** `docs/INSTAGRAM_OAUTH_CALLBACK_SETUP.md`
4. **Final Summary:** `docs/FINAL_INSTAGRAM_FIX_SUMMARY.md`

---

## 📝 **DEPLOYMENT LOG TEMPLATE:**

```
Deployment Date: 2025-10-25
Deployed By: [Your Name]
Commit Hash: ba85182
Branch: main

Changes Deployed:
- Added OAuth callback route
- Fixed form field population
- Enhanced error handling
- Updated documentation

Pre-Deployment Checks:
[✓] Local tests passed
[✓] Code reviewed
[✓] Documentation updated

Deployment Steps:
[✓] git pull origin main
[✓] composer install
[✓] npm run build
[✓] php artisan migrate
[✓] php artisan optimize:clear
[✓] Permissions set
[✓] Services restarted

Post-Deployment Tests:
[✓] Homepage loads
[✓] Instagram settings accessible
[✓] Form auto-populates
[✓] Test Connection works
[✓] Save Settings works
[✓] Instagram feed displays
[✓] No errors in logs

Status: ✅ SUCCESS / ❌ FAILED
Notes: [Any additional notes]
```

---

**Prepared By:** AI Assistant  
**Date:** October 25, 2025  
**Version:** 1.0  
**Status:** ✅ Ready for Deployment

