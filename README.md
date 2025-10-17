# IG to Web - Sistem Manajemen Sekolah Terintegrasi

Sistem manajemen sekolah berbasis web yang terintegrasi dengan Instagram untuk menampilkan kegiatan sekolah secara real-time.

## 🚀 Fitur Utama

### 📊 Dashboard & Analytics
- **Dashboard Interaktif**: Overview statistik sekolah dengan grafik real-time
- **Analytics Mendalam**: Tracking aktivitas user, penggunaan modul, dan trend data
- **Role-based Dashboard**: Dashboard khusus untuk setiap role (Superadmin, Admin, Guru, Siswa, Sarpras)

### 👥 Manajemen User & Role
- **Multi-Role System**: Superadmin, Admin, Guru, Siswa, Sarpras dengan permission granular
- **User Management**: CRUD lengkap dengan email verification dan invitation system
- **Role & Permission**: Sistem permission yang fleksibel dan aman
- **Audit Logging**: Tracking semua aktivitas penting dalam sistem

### 🏫 Manajemen Akademik
- **Guru Management**: Data lengkap guru dengan NIP, sertifikasi, dan prestasi
- **Siswa Management**: Data siswa dengan NIS/NISN, kelas, jurusan, dan prestasi
- **Kelulusan (E-Lulus)**: Sistem kelulusan dengan sertifikat digital
- **Mata Pelajaran**: Manajemen mata pelajaran dan kurikulum

### 🗳️ Sistem OSIS
- **Pemilihan OSIS**: Sistem voting online yang aman dan transparan
- **Kandidat Management**: Data kandidat dengan visi-misi dan program kerja
- **Voting System**: Real-time voting dengan tracking IP dan user agent
- **Hasil Voting**: Dashboard hasil dengan grafik dan statistik

### 🏢 Sarpras Management
- **Inventory Management**: Manajemen barang dengan barcode dan QR code
- **Kategori & Ruang**: Organisasi sarana prasarana yang terstruktur
- **Maintenance Tracking**: Sistem perawatan dan maintenance
- **Laporan**: Export data sarpras dalam berbagai format

### 📱 Instagram Integration
- **Auto Posting**: Integrasi dengan Instagram API untuk posting otomatis
- **Gallery Management**: Manajemen galeri kegiatan sekolah
- **Content Scheduling**: Penjadwalan konten Instagram
- **Analytics**: Tracking engagement dan reach

### 📄 Content Management
- **Page Management**: CMS untuk halaman website sekolah
- **Menu Management**: Sistem menu dinamis dengan hierarki
- **SEO Optimization**: Meta tags dan struktur SEO yang optimal
- **Version Control**: Tracking perubahan konten

### 🎨 Landing Page Customization
- **Hero Section**: Slider dengan konten yang dapat dikustomisasi
- **Feature Cards**: Kartu fitur unggulan sekolah
- **Campus Life**: Profil kepala sekolah dan visi-misi
- **Program Peminatan**: 3 program unggulan yang dapat dikustomisasi
- **Gallery**: Integrasi dengan Instagram posts
- **Testimonials**: Sistem testimonial dengan link publik
- **About Section**: Informasi sekolah yang lengkap

### 🔔 Notification System
- **Real-time Notifications**: Notifikasi sistem yang komprehensif
- **Email Notifications**: Integrasi dengan email untuk notifikasi penting
- **Role-based Alerts**: Notifikasi sesuai dengan role user
- **Maintenance Alerts**: Peringatan maintenance sistem

### 📊 Reporting & Export
- **Excel Export**: Export data dalam format Excel
- **PDF Reports**: Generate laporan dalam PDF
- **CSV Export**: Export data untuk analisis
- **Custom Reports**: Laporan yang dapat dikustomisasi

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 11**: Framework PHP modern dengan fitur terbaru
- **MySQL**: Database relasional yang powerful
- **Spatie Permission**: Sistem role dan permission yang robust
- **Laravel Excel**: Import/Export data Excel
- **DomPDF**: Generate PDF reports
- **Laravel Notifications**: Sistem notifikasi yang fleksibel

### Frontend
- **Tailwind CSS**: Framework CSS utility-first untuk admin panel
- **Bootstrap 5**: Framework CSS untuk landing page
- **Alpine.js**: JavaScript framework yang ringan
- **Chart.js**: Library grafik interaktif
- **Owl Carousel**: Slider dan carousel yang responsif

### Integrasi
- **Instagram Basic Display API**: Integrasi dengan Instagram
- **Mailtrap**: Testing email development
- **Laravel Sanctum**: API authentication
- **Laravel Telescope**: Debugging dan monitoring

## 📋 Persyaratan Sistem

### Server Requirements
- **PHP**: 8.1 atau lebih tinggi
- **MySQL**: 5.7 atau lebih tinggi
- **Composer**: Untuk dependency management
- **Node.js**: 16 atau lebih tinggi (untuk asset compilation)
- **Web Server**: Apache/Nginx

### PHP Extensions
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML

## 🚀 Instalasi & Setup

### 1. Clone Repository

#### Development (Local)
```bash
# Clone repository
git clone https://github.com/your-username/ig-to-web.git
cd ig-to-web

# Install dependencies
composer install
npm install
```

#### Production (VPS Ubuntu)
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.1+ dan extensions
sudo apt install php8.1 php8.1-cli php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-bcmath php8.1-gd php8.1-intl php8.1-xmlrpc php8.1-soap php8.1-readline php8.1-common php8.1-opcache php8.1-tokenizer php8.1-json

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Install MySQL
sudo apt install mysql-server
sudo mysql_secure_installation

# Install Nginx
sudo apt install nginx

# Clone repository
git clone https://github.com/your-username/ig-to-web.git
cd ig-to-web

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build
```

### 2. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### Konfigurasi Database (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ig_to_web
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### Konfigurasi Email (.env)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@sekolah.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### Konfigurasi Instagram (.env)
```env
INSTAGRAM_CLIENT_ID=your_instagram_client_id
INSTAGRAM_CLIENT_SECRET=your_instagram_client_secret
INSTAGRAM_REDIRECT_URI=https://yourdomain.com/instagram/callback
```

### 3. Database Setup

```bash
# Create database
mysql -u root -p
CREATE DATABASE ig_to_web;
exit

# Run migrations and seeders
php artisan migrate:fresh --seed
```

### 4. Storage & Permissions

```bash
# Create storage link
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Set permissions (Windows - jika menggunakan XAMPP)
# Pastikan folder storage dan bootstrap/cache dapat ditulis
```

### 5. Asset Compilation

```bash
# Development
npm run dev

# Production
npm run build
```

### 6. Queue & Scheduler (Production)

```bash
# Setup queue worker
php artisan queue:work --daemon

# Setup cron job untuk scheduler
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

## 🔧 Konfigurasi Nginx (Production)

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/ig-to-web/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 👤 Default Login

Setelah menjalankan seeder, Anda dapat login dengan:

- **Email**: superadmin@sekolah.com
- **Password**: password

## 📱 Fitur Mobile Responsive

- **Responsive Design**: Optimal di semua device (desktop, tablet, mobile)
- **Touch Friendly**: Interface yang mudah digunakan di touchscreen
- **Progressive Web App**: Dapat diinstall sebagai aplikasi mobile

## 🔒 Keamanan & Authorization

### Role-Based Access Control (RBAC)
Sistem permission yang terintegrasi dengan 3 komponen utama:

1. **Policies** (`app/Policies/`):
   - Mendefinisikan logika authorization untuk setiap model
   - Setiap policy memiliki fallback `|| $user->hasRole('superadmin')` untuk akses penuh superadmin
   - Menggunakan permission granular (contoh: `guru.view`, `guru.create`, `guru.edit`, `guru.delete`)

2. **Seeders** (`database/seeders/`):
   - `PermissionSeeder.php`: Membuat 73 permissions untuk semua modul
   - `UserSeeder.php`: Membuat user superadmin dengan role `superadmin`
   - Superadmin otomatis mendapat semua 73 permissions
   - Jalankan `php artisan migrate:fresh --seed` untuk setup lengkap

3. **Navigation** (`resources/views/layouts/navigation.blade.php`):
   - Menu dinamis berdasarkan role user
   - Menggunakan `@can()` directive untuk permission granular
   - Menggunakan `hasRole()` dan `hasAnyRole()` untuk role-based menu
   - Superadmin melihat semua menu dan fitur

### Hubungan Ketiga Komponen

```
┌─────────────┐      ┌──────────────┐      ┌──────────────┐
│   Seeders   │─────>│  Permissions │<─────│   Policies   │
│             │      │      &       │      │              │
│ Create 73   │      │    Roles     │      │  Check Auth  │
│ Permissions │      │              │      │  with Role   │
└─────────────┘      └──────────────┘      │  Fallback    │
                            │               └──────────────┘
                            │                       │
                            v                       v
                     ┌──────────────┐      ┌──────────────┐
                     │   Superadmin │      │  Navigation  │
                     │     User     │      │    Menus     │
                     │              │      │              │
                     │  73 Perms    │      │  Dynamic UI  │
                     │  All Access  │      │  Based Role  │
                     └──────────────┘      └──────────────┘
```

### Fitur Keamanan Lainnya

- **CSRF Protection**: Perlindungan dari serangan CSRF
- **XSS Protection**: Filter input untuk mencegah XSS
- **SQL Injection Protection**: Menggunakan Eloquent ORM
- **Audit Logging**: Tracking semua aktivitas penting
- **Rate Limiting**: Pembatasan request untuk mencegah abuse
- **Permission Cache**: Cache permission untuk performa optimal

## 📊 Monitoring & Analytics

- **Laravel Telescope**: Monitoring aplikasi development
- **Error Tracking**: Log error dan exception
- **Performance Monitoring**: Tracking performa aplikasi
- **User Analytics**: Analisis penggunaan sistem

## 🚀 Deployment

### Development
```bash
# Jalankan development server
php artisan serve

# Jalankan asset watcher
npm run dev
```

### Production
```bash
# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Build assets
npm run build
```

## 📝 API Documentation

Sistem menyediakan API endpoints untuk integrasi:

- **Authentication**: `/api/auth/*`
- **Users**: `/api/users/*`
- **Instagram**: `/api/instagram/*`
- **OSIS**: `/api/osis/*`
- **Sarpras**: `/api/sarpras/*`

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

## 📞 Support

Untuk bantuan dan pertanyaan:
- **Email**: support@sekolah.com
- **Documentation**: [Wiki Repository](https://github.com/your-username/ig-to-web/wiki)
- **Issues**: [GitHub Issues](https://github.com/your-username/ig-to-web/issues)

## 🎯 Roadmap

### Version 2.0
- [ ] Mobile App (React Native)
- [ ] Advanced Analytics Dashboard
- [ ] AI-powered Content Suggestions
- [ ] Multi-language Support
- [ ] Advanced Reporting System

### Version 2.1
- [ ] Video Integration
- [ ] Live Streaming
- [ ] Advanced Security Features
- [ ] Performance Optimization
- [ ] API Rate Limiting

---

**IG to Web** - Sistem Manajemen Sekolah Terintegrasi dengan Instagram
Dibuat dengan ❤️ untuk kemajuan pendidikan Indonesia