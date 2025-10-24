# 🚀 Pre-Deployment Checklist

**Date**: 2025-10-24  
**Target**: VPS Production  
**Purpose**: Client Testing

---

## ✅ **Pre-Deployment Checklist**

### **1. Code Quality** ✅
- [x] Semua native alerts diganti dengan SweetAlert2
- [x] Tidak ada bug yang ditemukan
- [x] OSIS module lengkap (15 views)
- [x] Instagram setup guide translated ke Bahasa Indonesia
- [x] Dokumentasi lengkap

### **2. Assets & Build** ✅
- [x] `npm run build` - Assets compiled untuk production
- [x] SweetAlert2 CSS & JS included
- [x] Public assets optimized

### **3. Laravel Optimization** ✅
- [x] `php artisan optimize:clear` - Clear all caches
- [x] View cache cleared
- [x] Route cache ready untuk production
- [x] Config cache ready untuk production

### **4. Database & Migration** ⚠️
- [ ] **IMPORTANT**: Backup database di VPS sebelum deploy
- [ ] Check apakah ada migration baru
- [ ] Seeder hanya untuk development (jangan run di production)

### **5. Environment Variables** ⚠️
Pastikan di VPS sudah set:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

# Instagram (optional, bisa diisi lewat admin panel)
INSTAGRAM_ACCESS_TOKEN=
INSTAGRAM_USER_ID=
```

### **6. Security** ⚠️
- [ ] `APP_DEBUG=false` di production
- [ ] `APP_KEY` sudah di-generate
- [ ] File permissions benar (storage & bootstrap/cache writable)
- [ ] `.env` tidak di-commit ke git

### **7. Git Preparation** 
```bash
# Check status
git status

# Add changes
git add .

# Commit dengan message yang jelas
git commit -m "feat: complete SweetAlert2 implementation and Instagram setup translation"

# Push ke repository
git push origin main
```

---

## 🔄 **Deployment Steps di VPS**

### **Step 1: Backup**
```bash
# Backup database
mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql

# Backup files (optional)
tar -czf backup_files_$(date +%Y%m%d_%H%M%S).tar.gz /path/to/project
```

### **Step 2: Pull Changes**
```bash
cd /path/to/project
git pull origin main
```

### **Step 3: Install Dependencies**
```bash
# Composer
composer install --optimize-autoloader --no-dev

# NPM (if needed, but usually built assets are committed)
npm ci --production
```

### **Step 4: Run Migrations** (jika ada)
```bash
php artisan migrate --force
```

### **Step 5: Optimize for Production**
```bash
# Clear all caches
php artisan optimize:clear

# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

### **Step 6: Fix Permissions**
```bash
# Set ownership (adjust user/group as needed)
sudo chown -R www-data:www-data /path/to/project

# Set permissions
chmod -R 755 /path/to/project
chmod -R 775 /path/to/project/storage
chmod -R 775 /path/to/project/bootstrap/cache
```

### **Step 7: Restart Services**
```bash
# Restart PHP-FPM (adjust version as needed)
sudo systemctl restart php8.2-fpm

# Restart Nginx/Apache
sudo systemctl restart nginx
# OR
sudo systemctl restart apache2

# Restart Queue Workers (if any)
sudo supervisorctl restart laravel-worker:*
```

---

## 🧪 **Post-Deployment Testing**

### **Critical Tests**
1. [ ] **Homepage loads** - Check main landing page
2. [ ] **Login works** - Test authentication
3. [ ] **Dashboard accessible** - Check admin/user dashboards
4. [ ] **SweetAlert works** - Test any delete/confirmation actions
5. [ ] **OSIS Module** - Test voting, create/edit calon & pemilih
6. [ ] **Instagram Settings** - Test connection (if configured)
7. [ ] **Responsive design** - Test on mobile/tablet
8. [ ] **No console errors** - Check browser console for JS errors

### **Module-Specific Tests**
- [ ] **Guru Module** - Create, edit, delete with SweetAlert
- [ ] **Siswa Module** - Create, edit, delete with SweetAlert
- [ ] **Sarpras Module** - Barcode generation, import/export
- [ ] **OSIS Voting** - Students can vote, results display
- [ ] **Kelulusan Module** - Import/export works

---

## ⚠️ **Common Issues & Solutions**

### **1. White Screen / 500 Error**
```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan optimize:clear

# Fix permissions
sudo chown -R www-data:www-data storage bootstrap/cache
```

### **2. Assets Not Loading**
```bash
# Check if build files exist
ls -la public/build/

# Regenerate manifest
npm run build

# Clear browser cache
```

### **3. Database Connection Error**
```bash
# Check .env file
cat .env | grep DB_

# Test connection
php artisan tinker
>>> DB::connection()->getPdo();
```

### **4. Session Issues**
```bash
# Clear sessions
php artisan session:clear

# Check session driver in .env
SESSION_DRIVER=file  # or database, redis
```

### **5. Permission Denied**
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

---

## 📊 **Performance Optimization** (Optional)

### **After Deployment**
```bash
# Enable OPcache (if not already)
# Edit php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000

# Enable compression in Nginx
gzip on;
gzip_vary on;
gzip_types text/plain text/css application/json application/javascript;

# CDN for assets (optional)
# Move static assets to CDN for faster loading
```

---

## 🔐 **Security Checklist**

### **Production Environment**
- [x] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] Strong `APP_KEY`
- [ ] HTTPS enabled
- [ ] Firewall configured
- [ ] Database user has minimal permissions
- [ ] `.env` file not publicly accessible
- [ ] `composer install --no-dev` (no dev dependencies)

---

## 📱 **Client Testing Checklist**

Berikan checklist ini ke client untuk testing:

### **Fungsionalitas Utama**
- [ ] Login/Logout berhasil
- [ ] Dashboard menampilkan data dengan benar
- [ ] CRUD operations (Create, Read, Update, Delete) berfungsi
- [ ] Alert notifications muncul dengan SweetAlert2 (cantik & modern)
- [ ] Import/Export data berfungsi
- [ ] Filter & search berfungsi
- [ ] Pagination berfungsi

### **OSIS Module**
- [ ] Admin dapat menambah/edit calon OSIS
- [ ] Admin dapat menambah/edit pemilih
- [ ] Siswa dapat melakukan voting (sesuai gender)
- [ ] Guru dapat melihat semua calon (tanpa filter gender)
- [ ] Hasil voting dapat dilihat
- [ ] Export/import calon & pemilih berfungsi

### **Sarpras Module**
- [ ] Barcode generation berfungsi
- [ ] QR code generation berfungsi
- [ ] Print barcode labels berfungsi
- [ ] Bulk print berfungsi
- [ ] Scan barcode berfungsi
- [ ] Import/export barang berfungsi

### **Instagram Integration** (jika diaktifkan)
- [ ] Setup guide mudah diikuti (Bahasa Indonesia)
- [ ] Test connection berhasil
- [ ] Feed Instagram tampil di halaman `/kegiatan`
- [ ] Auto sync berfungsi

### **UI/UX**
- [ ] Design responsive (mobile, tablet, desktop)
- [ ] Loading indicators muncul saat proses
- [ ] Confirmation dialogs muncul sebelum delete
- [ ] Success/error messages jelas dan informatif
- [ ] Tidak ada native browser alerts
- [ ] Tidak ada alert yang muncul berulang kali

---

## 🎯 **Rollback Plan** (Jika Diperlukan)

Jika ada masalah serius setelah deployment:

### **Quick Rollback**
```bash
# 1. Checkout ke commit sebelumnya
git log --oneline -10  # Lihat 10 commit terakhir
git checkout <previous-commit-hash>

# 2. Restore database backup
mysql -u username -p database_name < backup_YYYYMMDD_HHMMSS.sql

# 3. Clear cache & restart services
php artisan optimize:clear
sudo systemctl restart php8.2-fpm nginx
```

---

## 📞 **Support Contacts**

Jika client menemukan bug atau issue:
- 📧 Email: [your-email@example.com]
- 💬 WhatsApp/Telegram: [your-contact]
- 🐛 Issue Tracker: [GitHub Issues URL]

---

## ✅ **Final Checks Before Going Live**

- [ ] All tests passed
- [ ] Client approved
- [ ] Backup created
- [ ] Rollback plan ready
- [ ] Monitoring set up (optional)
- [ ] Documentation updated
- [ ] Team notified

---

**Status**: 🟢 **READY FOR DEPLOYMENT**

**Last Updated**: 2025-10-24  
**Prepared By**: Development Team

---

## 🚀 **Quick Deploy Commands**

```bash
# Full deployment sequence
cd /path/to/project && \
git pull origin main && \
composer install --optimize-autoloader --no-dev && \
php artisan migrate --force && \
php artisan optimize:clear && \
php artisan config:cache && \
php artisan route:cache && \
php artisan view:cache && \
sudo systemctl restart php8.2-fpm nginx

# Verify deployment
php artisan --version
php artisan route:list | grep osis
php artisan config:show app.debug
```

**Good luck with your deployment!** 🎉

