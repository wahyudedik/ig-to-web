# Website Sekolah - Sistem Informasi Sekolah Terintegrasi

Website sekolah dengan fitur lengkap untuk manajemen data siswa, guru, kegiatan, dan administrasi sekolah.

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- NPM atau Yarn
- MySQL/MariaDB atau SQLite
- Web Server (Apache/Nginx) atau PHP Built-in Server

## 🚀 Cara Clone dan Setup Development

### 1. Clone Repository

```bash
# Clone repository dari GitHub
git clone https://github.com/wahyudedik/ig-to-web.git

# Masuk ke direktori project
cd ig-to-web
```

### 2. Install Dependencies

```bash
# Install PHP dependencies dengan Composer
composer install

# Install JavaScript dependencies dengan NPM
npm install
```

### 3. Konfigurasi Environment

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sekolah_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Setup Database

```bash
# Jalankan migrasi database
php artisan migrate

# (Opsional) Jalankan seeder untuk data sample
php artisan db:seed
```

### 6. Konfigurasi Instagram API (Opsional)

Untuk fitur modul kegiatan Instagram, tambahkan konfigurasi berikut di file `.env`:

```env
# Instagram API Configuration
INSTAGRAM_ACCESS_TOKEN=your_access_token_here
INSTAGRAM_USER_ID=your_user_id_here
INSTAGRAM_APP_ID=your_app_id_here
INSTAGRAM_APP_SECRET=your_app_secret_here
INSTAGRAM_REDIRECT_URI=https://yourdomain.com/instagram/callback
```

### 7. Build Assets

```bash
# Build assets untuk development
npm run dev

# Atau build untuk production
npm run build
```

### 8. Jalankan Aplikasi

```bash
# Jalankan development server
php artisan serve

# Atau jalankan dengan semua service (server, queue, logs, vite)
composer run dev
```

Aplikasi akan berjalan di `http://localhost:8000`

## 📁 Struktur Project

```
ig-to-web/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Controller aplikasi
│   │   │   ├── Auth/            # Controller autentikasi
│   │   │   ├── DashboardController.php
│   │   │   ├── InstagramController.php
│   │   │   ├── ProfileController.php
│   │   │   └── SuperadminController.php
│   │   ├── Middleware/          # Custom middleware
│   │   │   ├── CheckRole.php
│   │   │   └── CheckPermission.php
│   │   └── Requests/            # Form request validation
│   ├── Models/                  # Eloquent models
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Permission.php
│   │   ├── ModuleAccess.php
│   │   └── AuditLog.php
│   ├── Services/                # Business logic services
│   │   └── InstagramService.php
│   └── View/Components/         # Blade components
├── config/                      # Konfigurasi aplikasi
├── database/
│   ├── migrations/              # Database migrations
│   ├── seeders/                 # Database seeders
│   └── factories/               # Model factories
├── public/                      # Public assets
├── resources/
│   ├── css/                     # Stylesheet
│   ├── js/                      # JavaScript
│   └── views/                   # Blade templates
│       ├── auth/                # View autentikasi
│       ├── dashboards/          # View dashboard per role
│       │   └── superadmin.blade.php
│       ├── instagram/           # View Instagram activities
│       └── layouts/             # Layout templates
├── routes/                      # Route definitions
├── storage/                     # File storage
└── tests/                       # Test files
```

## 👥 Sistem Role dan Akses

Aplikasi menggunakan **Role + Module Access Control** yang fleksibel:

### **🔐 Role System**
1. **Superadmin** - Akses penuh ke semua fitur + User Management & Module Access Control
2. **Admin** - Default tidak ada akses, harus di-assign manual oleh superadmin
3. **Guru** - Default tidak ada akses, harus di-assign manual oleh superadmin  
4. **Siswa** - Default tidak ada akses, harus di-assign manual oleh superadmin
5. **Sarpras** - Default tidak ada akses, harus di-assign manual oleh superadmin

### **📋 Permission System (Spatie Laravel Permission)**
- **Superadmin**: Otomatis punya akses ke SEMUA modul dengan SEMUA permission
- **Role lain**: Default TIDAK punya akses ke modul apapun
- **Spatie Permission**: Menggunakan `spatie/laravel-permission` untuk role & permission management
- **Permission Format**: `{module}.{action}` (contoh: `instagram.create`, `guru.read`)
- **Superadmin** bisa assign permission granular ke user lain:
  - ✅ `{module}.create` - Bisa create data  
  - ✅ `{module}.read` - Bisa lihat data
  - ✅ `{module}.update` - Bisa edit data
  - ❌ `{module}.delete` - Bisa delete data

### **📱 Available Modules**
- **instagram** - Modul kegiatan Instagram
- **pages** - Modul page management  
- **guru** - Modul tenaga pendidik
- **siswa** - Modul siswa aktif
- **osis** - Modul E-OSIS
- **lulus** - Modul E-Lulus
- **sarpras** - Modul sarana prasarana

## 🔧 Development Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Refresh database
php artisan migrate:fresh --seed

# Run tests
php artisan test

# Generate model dengan migration
php artisan make:model ModelName -m

# Generate controller
php artisan make:controller ControllerName

# Watch assets untuk development
npm run dev

# Spatie Permission Commands
php artisan permission:create-role superadmin
php artisan permission:create-permission "instagram.create"
php artisan permission:show
```

## 🔑 Default Login

Setelah setup selesai, Anda bisa login dengan akun default:

**Superadmin:**
- Email: superadmin@sekolah.com
- Password: password

**Admin:**
- Email: admin@sekolah.com
- Password: password

**Guru:**
- Email: guru@sekolah.com  
- Password: password

**Siswa:**
- Email: siswa@sekolah.com
- Password: password

**Sarpras:**
- Email: sarpras@sekolah.com
- Password: password

## 🛠️ Troubleshooting

### Error: "Class 'PDO' not found"
```bash
# Install PHP PDO extension
sudo apt-get install php-pdo php-mysql  # Ubuntu/Debian
brew install php@8.2                    # macOS
```

### Error: "Permission denied" pada storage
```bash
# Set permission yang benar
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache  # Linux
```

### Error: "Vite manifest not found"
```bash
# Build assets
npm run build
```

### Database connection error
- Pastikan MySQL/MariaDB service berjalan
- Periksa konfigurasi database di file `.env`
- Pastikan database sudah dibuat

## 📝 Environment Variables

File `.env` yang diperlukan:

```env
APP_NAME="Website Sekolah"
APP_ENV=local
APP_KEY=base64:your_app_key_here
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sekolah_db
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Instagram API (Opsional)
INSTAGRAM_ACCESS_TOKEN=
INSTAGRAM_USER_ID=
INSTAGRAM_APP_ID=
INSTAGRAM_APP_SECRET=
INSTAGRAM_REDIRECT_URI=
```

## 📚 Dokumentasi Fitur

Fitur :
1. Modul Kegiatan = ambil dari data instagram sekolah mmenggunakan api dari meta
2. Modul Page = untuk membuat halaman/keterangan (Judul, isi halaman, gambar, kategori, waktu posting)
2. Modul Tenaga Pendidik, berisi:
   - Nama
   - Tempat, Tanggal Lahir (TTL)
   - Alamat
   - No. Telepon/WA
   - Mata Pelajaran (Mapel)
   - Foto
3. Modul Siswa Masih Aktif, berisi:
   - Nama Lengkap
   - Tempat, Tanggal Lahir (TTL)
   - Alamat
   - Tahun Masuk
   - Foto

   Ketika lulus, data tambahan:
   - Tahun Lulus
   - Kuliah/Kerja
   - Tempat Kuliah/Kerja
   - Jurusan/Jabatan
   - No. Hp/WA
4. Modul E-Osis :
   1. Data Calon
      - Menampilkan daftar calon ketua & wakil OSIS beserta detail:
        - Nama Ketua
        - Foto Ketua
        - Nama Wakil
        - Foto Wakil
        - Visi Misi
        - Jenis Pencalonan (misal: Ketua/Wakil, Pasangan, dll)
      - Fitur tambah/edit/hapus data calon.

   2. Monitor Hasil
      - Menampilkan hasil sementara dan akhir pemilihan:
        - Jumlah suara masing-masing calon/pasangan
        - Persentase perolehan suara
        - Grafik hasil voting (opsional)
      - Fitur refresh data hasil.

   3. Data Pemilih
      - Menampilkan daftar pemilih yang sudah dan belum memilih.
      - Data pemilih meliputi:
        - Nama
        - NIS/NISN
        - Kelas
        - Status (Sudah/Belum Memilih)
      - Fitur tambah/edit/hapus data pemilih.

   Tampilan tambah data:
   - Form input:
     - Nama Ketua (input text)
     - Foto Ketua (upload gambar)
     - Nama Wakil (input text)
     - Foto Wakil (upload gambar)
     - Visi Misi (textarea)
     - Jenis Pencalonan (dropdown/select)

   Tampilan Dashboard (contoh):
   - Statistik jumlah calon, jumlah pemilih, jumlah suara masuk
   - Grafik hasil voting (pie chart/bar chart)
   - List calon beserta perolehan suara
   - Tombol untuk tambah data calon & pemilih

   Berikut ini tampilannya (contoh wireframe sederhana):

   ```
   +------------------------------------------------------+
   | Dashboard E-Osis                                     |
   +-------------------+----------------------------------+
   | [Tambah Calon]    | Statistik:                      |
   | [Tambah Pemilih]  | - Jumlah Calon: 3               |
   |                   | - Jumlah Pemilih: 120           |
   |                   | - Suara Masuk: 100              |
   +-------------------+----------------------------------+
   | Calon OSIS:                                       V |
   | 1. Ketua: A, Wakil: B | Suara: 40 (40%)             |
   | 2. Ketua: C, Wakil: D | Suara: 35 (35%)             |
   | 3. Ketua: E, Wakil: F | Suara: 25 (25%)             |
   +------------------------------------------------------+
   | Grafik Hasil Voting (Pie/Bar Chart)                  |
   +------------------------------------------------------+
   ```
5. E-Lulus (Fitur Import Data Kelulusan)
   - Import data kelulusan siswa dengan kolom:
     - Nama
     - NISN
     - NIS
     - Jurusan
     - Tahun Ajaran
     - Status
   - Siswa dapat melakukan input NISN atau NIS pada form.
   - Setelah input, sistem akan menampilkan keterangan:
     ```
     Selamat Nama_Siswa!
     Kamu Dinyatakan LULUS!
     ```
6. Modul Sarpras (Sarana dan Prasarana)

   Master Data:
   - Kategori Sarpras
   - Nama Barang

   Prasarana:
   - Nama Ruang
   - Data Tanah
   - Data Bangunan

   Sarana:
   - Tambahan Sarana

   Untuk akses lebih detail, silakan kunjungi:
   https://maudu.aplikasimadrasah.com/administrator

   Login:
   - Username: admin
   - Password: password

## 🤝 Contributing

Kontribusi sangat diterima! Silakan ikuti langkah berikut:

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 Lisensi

Distributed under the MIT License. See `LICENSE` for more information.

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Alpine.js](https://alpinejs.dev/)
- [Instagram Basic Display API](https://developers.facebook.com/docs/instagram-basic-display-api)