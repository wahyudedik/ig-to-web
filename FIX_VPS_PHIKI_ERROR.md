# 🔧 Fix Error: Class "Phiki\Adapters\Laravel\PhikiServiceProvider" not found

## 🐛 Masalah

Error terjadi karena cache bootstrap masih menyimpan service provider dari package `phiki/phiki` yang tidak ada di `composer.json` atau tidak terinstall di VPS.

## ✅ Solusi (Jalankan di VPS)

```bash
# 1. Login ke VPS
ssh root@your-server-ip

# 2. Masuk ke direktori aplikasi
cd /var/www/ig-to-web  # atau path aplikasi Anda

# 3. Hapus semua cache bootstrap
rm -f bootstrap/cache/services.php
rm -f bootstrap/cache/packages.php
rm -f bootstrap/cache/config.php

# 4. Clear semua Laravel cache
php artisan optimize:clear

# 5. Regenerate autoload composer
composer dump-autoload --optimize

# 6. Rediscover packages (hanya akan register packages yang terinstall)
php artisan package:discover --ansi

# 7. Cache ulang untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 8. Verifikasi aplikasi kembali normal
php artisan about
```

## 🔍 Penyebab

1. Package `phiki/phiki` pernah terinstall di development
2. Cache bootstrap (`bootstrap/cache/services.php`, `bootstrap/cache/packages.php`) masih menyimpan service provider dari package tersebut
3. Saat deploy ke VPS, package tersebut tidak terinstall (karena tidak ada di `composer.json`)
4. Laravel mencoba load service provider dari cache tapi package tidak ada

## 🛡️ Pencegahan

1. **Jangan commit cache bootstrap ke git:**
   - Pastikan `bootstrap/cache/*.php` ada di `.gitignore`
   - File cache harus di-generate di server, bukan dari git

2. **Selalu clear cache setelah deploy:**
   ```bash
   php artisan optimize:clear
   composer dump-autoload --optimize
   php artisan package:discover --ansi
   php artisan optimize
   ```

3. **Pastikan composer.json konsisten:**
   - Hanya install package yang diperlukan
   - Hapus package yang tidak digunakan dari `composer.json`

4. **Update deployment script:**
   ```bash
   # Di deployment script, tambahkan:
   php artisan optimize:clear
   composer install --optimize-autoloader --no-dev
   php artisan package:discover --ansi
   php artisan migrate --force
   php artisan optimize
   ```

## 📝 Catatan

- File `bootstrap/cache/*.php` adalah auto-generated oleh Laravel
- Jangan edit file-file ini manual
- Jika ada error service provider not found, **selalu clear cache bootstrap terlebih dahulu**
- Package `phiki/phiki` tidak ada di `composer.json`, jadi harus dihapus dari cache

---

**Setelah menjalankan solusi di atas, aplikasi seharusnya kembali normal!** ✅

