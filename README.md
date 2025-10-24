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

### 🤖 AI Integration (NEW!)
- **MCP Server**: Model Context Protocol untuk integrasi dengan Claude AI
  - Baca dokumentasi lengkap: [README_MCP.md](README_MCP.md)
  - Quick start dalam 5 menit!
  - Tools untuk eksplorasi codebase, artisan commands, dan lebih banyak lagi

## 🤖 MCP Server (Model Context Protocol)

Project ini dilengkapi dengan **MCP Server** yang memungkinkan Claude AI untuk berinteraksi langsung dengan codebase Laravel!

### ⚡ Quick Setup

```bash
cd mcp-server
npm install
npm test
```

Kemudian konfigurasi di Claude Desktop. Lihat dokumentasi lengkap: **[README_MCP.md](README_MCP.md)**

### 🎯 Apa yang Bisa Dilakukan?

- 📖 Baca file dari codebase
- 🔍 Search di seluruh project
- 🗂️ Explore struktur folder
- ⚙️ Jalankan artisan commands
- 🛣️ Lihat semua routes
- 🎨 Inspect models dan controllers

**Tanya ke Claude dengan bahasa natural:**
- "Baca file User.php di Models"
- "Tampilkan semua routes"
- "Cari kata 'Instagram' di folder app"

📚 **Dokumentasi Lengkap**: [README_MCP.md](README_MCP.md) | [QUICKSTART](mcp-server/QUICKSTART.md) | [CHEATSHEET](mcp-server/CHEATSHEET.md)

---

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
- **Documentation**: [Wiki Repository](https://github.com/wahyudedik/ig-to-web/wiki)
- **Issues**: [GitHub Issues](https://github.com/wahyudedik/ig-to-web/issues)

## 🎯 Roadmap & Future Enhancements

### 📱 Mobile & Cross-Platform
- [ ] **Mobile App (React Native)**: Aplikasi mobile untuk iOS dan Android
- [ ] **Progressive Web App**: Instalasi sebagai aplikasi native
- [ ] **Offline Mode**: Akses data saat tidak ada koneksi internet
- [ ] **Push Notifications**: Notifikasi real-time di mobile devices

### 📊 Analytics & Reporting
- [ ] **Advanced Analytics Dashboard**: Dashboard analytics yang lebih mendalam
- [ ] **Custom Report Designer**: Pembuat laporan dengan drag-and-drop
- [ ] **Data Visualization**: Grafik dan chart interaktif yang lebih kaya
- [ ] **Export to Multiple Formats**: PDF, Excel, CSV, JSON, XML

### 🤖 AI & Automation
- [ ] **AI-powered Content Suggestions**: Rekomendasi konten otomatis
- [ ] **Chatbot Support**: Asisten virtual untuk help desk
- [ ] **Automatic Translation**: Terjemahan otomatis multi-bahasa
- [ ] **Smart Scheduling**: Penjadwalan cerdas berdasarkan AI
- [ ] **Predictive Analytics**: Prediksi trend dan pattern

### 🌐 Integration & API
- [ ] **WhatsApp Integration**: Notifikasi via WhatsApp Business API
- [ ] **Google Classroom Integration**: Sinkronisasi dengan Google Classroom
- [ ] **Zoom/Google Meet Integration**: Video conference terintegrasi
- [ ] **Payment Gateway**: Integrasi dengan Midtrans, Xendit, dll
- [ ] **SSO (Single Sign-On)**: Login dengan Google, Microsoft, dll
- [ ] **REST API Documentation**: API documentation dengan Swagger/OpenAPI
- [ ] **GraphQL API**: Alternative API dengan GraphQL

### 📚 E-Learning Features
- [ ] **Online Class Module**: Kelas online dengan video streaming
- [ ] **Assignment & Quiz**: Tugas dan quiz online
- [ ] **Grade Management**: Sistem penilaian terintegrasi
- [ ] **Discussion Forum**: Forum diskusi untuk siswa dan guru
- [ ] **Live Streaming**: Live streaming untuk acara sekolah
- [ ] **Video Library**: Perpustakaan video pembelajaran
- [ ] **Interactive Whiteboard**: Papan tulis digital interaktif

### 👨‍👩‍👧‍👦 Parent & Guardian Features
- [ ] **Parent Portal**: Portal khusus untuk orang tua
- [ ] **Student Progress Tracking**: Tracking perkembangan siswa
- [ ] **Parent-Teacher Communication**: Komunikasi orang tua dan guru
- [ ] **Event Notification**: Notifikasi event sekolah ke orang tua

### 🔐 Security & Performance
- [ ] **Two-Factor Authentication (2FA)**: Keamanan login 2 faktor
- [ ] **Biometric Login**: Login dengan fingerprint/face recognition
- [ ] **Attendance with Face Recognition**: Absensi dengan face recognition
- [ ] **Advanced Security Audit**: Audit keamanan yang lebih mendalam
- [ ] **Performance Optimization**: Optimasi performa dan caching
- [ ] **CDN Integration**: Content Delivery Network untuk assets
- [ ] **Load Balancing**: Load balancing untuk high traffic
- [ ] **API Rate Limiting**: Pembatasan rate untuk API

### 🌍 Internationalization
- [ ] **Multi-language Support**: Dukungan multi-bahasa (EN, ID, AR, dll)
- [ ] **RTL Language Support**: Dukungan bahasa RTL (Arab, Hebrew)
- [ ] **Currency Support**: Dukungan multi-currency untuk pembayaran
- [ ] **Timezone Support**: Dukungan multiple timezone

### 📱 Social Media Enhancement
- [ ] **Facebook Integration**: Posting otomatis ke Facebook
- [ ] **Twitter Integration**: Posting otomatis ke Twitter
- [ ] **TikTok Integration**: Integrasi dengan TikTok
- [ ] **YouTube Integration**: Upload video ke YouTube
- [ ] **Social Media Analytics**: Analytics untuk semua platform

### 🎨 UI/UX Improvements
- [ ] **Dark Mode**: Mode gelap untuk UI
- [ ] **Theme Customization**: Kustomisasi tema dan warna
- [ ] **Accessibility Features**: Fitur aksesibilitas untuk disabilitas
- [ ] **Voice Control**: Kontrol dengan suara
- [ ] **Gesture Navigation**: Navigasi dengan gesture

### 📦 Additional Modules
- [ ] **Library Management**: Manajemen perpustakaan sekolah
- [ ] **Canteen Management**: Manajemen kantin dan pembayaran
- [ ] **Transport Management**: Manajemen transportasi sekolah
- [ ] **Health Record**: Rekam kesehatan siswa
- [ ] **Dormitory Management**: Manajemen asrama (jika ada)
- [ ] **Alumni Portal**: Portal untuk alumni sekolah

---

## 🖥️ Panduan Lengkap Setup VPS Ubuntu

### Persiapan Server

#### 1. Update dan Upgrade System
```bash
# Login sebagai root
ssh root@your-server-ip

# Update package list
sudo apt update && sudo apt upgrade -y

# Install essential packages
sudo apt install -y software-properties-common curl wget git unzip
```

#### 2. Setup Firewall
```bash
# Enable UFW firewall
sudo ufw enable

# Allow SSH
sudo ufw allow 22/tcp

# Allow HTTP and HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Check status
sudo ufw status
```

#### 3. Install PHP 8.1 dan Extensions
```bash
# Add PHP repository
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Install PHP 8.1 dan extensions yang diperlukan
sudo apt install -y php8.1 \
    php8.1-cli \
    php8.1-fpm \
    php8.1-mysql \
    php8.1-xml \
    php8.1-mbstring \
    php8.1-curl \
    php8.1-zip \
    php8.1-bcmath \
    php8.1-gd \
    php8.1-intl \
    php8.1-xmlrpc \
    php8.1-soap \
    php8.1-readline \
    php8.1-common \
    php8.1-opcache \
    php8.1-tokenizer

# Verify PHP installation
php -v

# Configure PHP
sudo nano /etc/php/8.1/fpm/php.ini
# Set: upload_max_filesize = 100M
# Set: post_max_size = 100M
# Set: memory_limit = 256M
# Set: max_execution_time = 300

# Restart PHP-FPM
sudo systemctl restart php8.1-fpm
```

#### 4. Install Composer
```bash
# Download Composer
curl -sS https://getcomposer.org/installer | php

# Move to global location
sudo mv composer.phar /usr/local/bin/composer

# Verify installation
composer --version

# Make composer globally accessible
sudo chmod +x /usr/local/bin/composer
```

#### 5. Install Node.js dan NPM
```bash
# Install Node.js 18.x LTS
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Verify installation
node --version
npm --version

# Install Yarn (optional)
sudo npm install -g yarn
```

#### 6. Install MySQL 8.0
```bash
# Install MySQL Server
sudo apt install mysql-server -y

# Secure MySQL installation
sudo mysql_secure_installation
# Answer prompts:
# - Set root password: YES
# - Remove anonymous users: YES
# - Disallow root login remotely: YES
# - Remove test database: YES
# - Reload privilege tables: YES

# Login to MySQL
sudo mysql -u root -p

# Create database and user
CREATE DATABASE ig_to_web CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'ig_to_web_user'@'localhost' IDENTIFIED BY 'your_strong_password';
GRANT ALL PRIVILEGES ON ig_to_web.* TO 'ig_to_web_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Configure MySQL for better performance
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
# Add under [mysqld]:
# max_connections = 200
# innodb_buffer_pool_size = 256M
# innodb_log_file_size = 64M

# Restart MySQL
sudo systemctl restart mysql
```

#### 7. Install Nginx
```bash
# Install Nginx
sudo apt install nginx -y

# Start and enable Nginx
sudo systemctl start nginx
sudo systemctl enable nginx

# Verify Nginx is running
sudo systemctl status nginx
```

#### 8. Install SSL Certificate (Let's Encrypt)
```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Obtain SSL certificate (setelah domain sudah pointing)
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal test
sudo certbot renew --dry-run

# Setup auto-renewal cron job
sudo crontab -e
# Add: 0 3 * * * certbot renew --quiet
```

### Deploy Aplikasi

#### 1. Clone Repository
```bash
# Create web directory
sudo mkdir -p /var/www/ig-to-web

# Set ownership
sudo chown -R $USER:$USER /var/www/ig-to-web

# Clone repository
cd /var/www
git clone https://github.com/your-username/ig-to-web.git
cd ig-to-web
```

#### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node dependencies
npm install

# Build assets for production
npm run build
```

#### 3. Setup Environment
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Edit environment file
nano .env
```

Configure `.env`:
```env
APP_NAME="IG to Web"
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ig_to_web
DB_USERNAME=ig_to_web_user
DB_PASSWORD=your_strong_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

SESSION_DRIVER=file
QUEUE_CONNECTION=database
```

#### 4. Run Migrations
```bash
# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force

# Create storage link
php artisan storage:link

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

#### 5. Set Permissions
```bash
# Set ownership to www-data
sudo chown -R www-data:www-data /var/www/ig-to-web

# Set proper permissions
sudo chmod -R 755 /var/www/ig-to-web
sudo chmod -R 775 /var/www/ig-to-web/storage
sudo chmod -R 775 /var/www/ig-to-web/bootstrap/cache
```

#### 6. Configure Nginx
```bash
# Create Nginx configuration
sudo nano /etc/nginx/sites-available/ig-to-web
```

Add configuration:
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    
    # Redirect to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/ig-to-web/public;

    # SSL Configuration (will be auto-configured by Certbot)
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml+rss application/json application/javascript;

    index index.php index.html;

    charset utf-8;

    # Increase max upload size
    client_max_body_size 100M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { 
        access_log off; 
        log_not_found off; 
    }
    
    location = /robots.txt  { 
        access_log off; 
        log_not_found off; 
    }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
        
        # Increase timeout for long-running processes
        fastcgi_read_timeout 300;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

Enable site:
```bash
# Create symbolic link
sudo ln -s /etc/nginx/sites-available/ig-to-web /etc/nginx/sites-enabled/

# Remove default site
sudo rm /etc/nginx/sites-enabled/default

# Test Nginx configuration
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx
```

#### 7. Setup Queue Worker
```bash
# Create systemd service for queue worker
sudo nano /etc/systemd/system/laravel-worker.service
```

Add content:
```ini
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
Type=simple
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/ig-to-web/artisan queue:work --sleep=3 --tries=3 --timeout=90

[Install]
WantedBy=multi-user.target
```

Enable and start:
```bash
# Reload systemd
sudo systemctl daemon-reload

# Enable service
sudo systemctl enable laravel-worker

# Start service
sudo systemctl start laravel-worker

# Check status
sudo systemctl status laravel-worker
```

#### 8. Setup Scheduler (Cron)
```bash
# Edit crontab
sudo crontab -e

# Add Laravel scheduler
* * * * * cd /var/www/ig-to-web && php artisan schedule:run >> /dev/null 2>&1
```

#### 9. Setup Log Rotation
```bash
# Create log rotation config
sudo nano /etc/logrotate.d/laravel
```

Add:
```
/var/www/ig-to-web/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
    postrotate
        systemctl reload php8.1-fpm > /dev/null 2>&1
    endscript
}
```

#### 10. Monitoring & Maintenance
```bash
# Install monitoring tools
sudo apt install htop iotop nethogs -y

# Create backup script
sudo nano /usr/local/bin/backup-ig-to-web.sh
```

Add backup script:
```bash
#!/bin/bash
BACKUP_DIR="/var/backups/ig-to-web"
DATE=$(date +%Y%m%d_%H%M%S)

mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u ig_to_web_user -p'your_password' ig_to_web | gzip > $BACKUP_DIR/database_$DATE.sql.gz

# Backup files
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/ig-to-web

# Delete old backups (keep last 7 days)
find $BACKUP_DIR -type f -mtime +7 -delete

echo "Backup completed: $DATE"
```

Make executable and setup cron:
```bash
# Make executable
sudo chmod +x /usr/local/bin/backup-ig-to-web.sh

# Add to crontab (daily at 2 AM)
sudo crontab -e
# Add: 0 2 * * * /usr/local/bin/backup-ig-to-web.sh
```

### Security Hardening

#### 1. Setup Fail2Ban
```bash
# Install Fail2Ban
sudo apt install fail2ban -y

# Configure for Nginx
sudo nano /etc/fail2ban/jail.local
```

Add:
```ini
[nginx-http-auth]
enabled = true

[nginx-noscript]
enabled = true

[nginx-badbots]
enabled = true

[nginx-noproxy]
enabled = true
```

```bash
# Restart Fail2Ban
sudo systemctl restart fail2ban
```

#### 2. Disable Root Login
```bash
# Edit SSH config
sudo nano /etc/ssh/sshd_config

# Set: PermitRootLogin no
# Set: PasswordAuthentication no (setelah setup SSH key)

# Restart SSH
sudo systemctl restart sshd
```

### Maintenance Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# View logs
tail -f storage/logs/laravel.log

# Check queue status
php artisan queue:failed
php artisan queue:retry all

# Monitor system
htop
df -h
free -m
```

---

## 📊 Monitoring & Performance

### Server Monitoring
- **htop**: Monitor CPU, RAM, dan processes
- **iotop**: Monitor disk I/O
- **nethogs**: Monitor network bandwidth
- **Laravel Telescope**: Application debugging (development)
- **New Relic/DataDog**: APM tools (optional)

### Performance Tips
1. Enable OPcache untuk PHP
2. Setup Redis untuk cache dan sessions
3. Use CDN untuk static assets
4. Optimize database queries
5. Enable Gzip compression
6. Setup load balancing untuk high traffic

---

**IG to Web** - Sistem Manajemen Sekolah Terintegrasi dengan Instagram

Dibuat dengan ❤️ untuk kemajuan pendidikan Indonesia

© 2025 IG to Web. All rights reserved.