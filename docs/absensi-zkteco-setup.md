## Dokumentasi Setup Absensi Fingerprint ZKTeco (VPS aaPanel)

Dokumentasi ini menjelaskan cara menghubungkan perangkat absensi ZKTeco (face/fingerprint/RFID) ke aplikasi Laravel di VPS (aaPanel), termasuk konfigurasi jaringan, keamanan, dan cara kerja data di sistem.

### 1) Cara Kerja Integrasi yang Dipakai di Project Ini

Project ini memakai mode **PUSH iClock**:
- Perangkat ZKTeco mengirim log absensi ke server melalui endpoint:
  - `GET|POST /iclock/cdata?SN=...`
- Server menyimpan log mentah ke tabel `attendance_logs` dan membuat/menandai device di `attendance_devices`.
- Sistem membentuk rekap harian (first-in / last-out) dari log mentah lewat command:
  - `php artisan attendance:sync` (sudah dijadwalkan setiap 5 menit).

Keunggulan mode PUSH untuk VPS:
- Server tidak perlu bisa “mengakses IP lokal perangkat”.
- Cukup perangkat bisa mengakses **domain VPS** lewat internet.

### 2) Variabel ENV yang Perlu Ditambahkan

Tambahkan ke `.env` di VPS:

```
ATTENDANCE_ICLOCK_SECRET=buat-token-random-panjang
```

Fungsi:
- Mengamankan endpoint `iclock/cdata` dari request liar.
- Device wajib mengirim token pada query string.

Format URL yang direkomendasikan pada device:
- `https://domain-anda.com/iclock/cdata?token=ATTENDANCE_ICLOCK_SECRET`

Sistem juga akan menerima token lewat parameter:
- `token` atau `iclock_token`

Catatan:
- Jika `ATTENDANCE_ICLOCK_SECRET` kosong, endpoint menerima request tanpa token.

### 3) Setup VPS di aaPanel (Nginx/Apache)

#### A. Domain dan SSL
1. Buat website di aaPanel dengan domain (mis. `absensi.sekolah.sch.id`).
2. Aktifkan SSL (Let’s Encrypt). Disarankan HTTPS agar token tidak mudah disadap.

#### B. Web Root Laravel (Sangat Penting)
Set Document Root ke folder `public` Laravel, misalnya:
- `/www/wwwroot/absensi.sekolah.sch.id/public`

Jika root diarahkan ke folder project tanpa `/public`, routing Laravel biasanya akan bermasalah.

#### C. Rewrite / URL Routing
Pastikan rewrite Laravel aktif:
- Nginx: gunakan template Laravel (try_files ke `index.php`).
- Apache: pastikan `.htaccess` di folder `public` dibaca (AllowOverride).

#### D. Buka Port yang Dibutuhkan
Minimal:
- 80 (HTTP)
- 443 (HTTPS)

Opsional keamanan:
- Jika sekolah punya IP publik statis, whitelist IP tersebut untuk akses endpoint.

### 4) Menjalankan Scheduler di Production (Wajib untuk Rekap)

Di VPS, jalankan scheduler Laravel via cron aaPanel:
- Buat Cron Job: **Every 1 minute**
- Command:

```
cd /www/wwwroot/absensi.sekolah.sch.id && php artisan schedule:run >> /dev/null 2>&1
```

Scheduler ini akan menjalankan `attendance:sync` setiap 5 menit (sesuai konfigurasi schedule).

### 5) Setup Jaringan di Perangkat ZKTeco

Menu pada tiap tipe bisa sedikit berbeda, tetapi umumnya ada bagian **Network / TCP/IP**:

1. Set IP Address (contoh LAN sekolah):
   - IP: `192.168.1.201`
   - Subnet: `255.255.255.0`
   - Gateway: `192.168.1.1`
   - DNS: `8.8.8.8` atau DNS dari ISP
2. Pastikan waktu device benar (tanggal dan jam).
3. Pastikan device bisa akses internet (uji dengan ping jika tersedia).

### 6) Setup PUSH iClock pada ZKTeco (Face/Finger/RFID)

Pada device, cari menu seperti:
- **Communication / ADMS / Cloud Server / Push**

Lalu atur:
- **Server URL**:
  - `https://domain-anda.com/iclock/cdata?token=TOKEN_ANDA`
- Jika device hanya mendukung HTTP:
  - `http://domain-anda.com/iclock/cdata?token=TOKEN_ANDA`
  - Disarankan tambah proteksi firewall (whitelist IP publik sekolah).

Setelah disimpan, device biasanya akan mengirim request periodik ke server.

### 7) Setup User di Device: Face, Finger, dan RFID

Prinsip utama agar data konsisten:
- Setiap orang punya **PIN/User ID unik** di device.
- Face/finger/card semuanya menempel ke **PIN yang sama**.

#### A. Membuat User + PIN
1. Masuk menu **Users / User Management**.
2. Tambahkan user baru.
3. Isi:
   - PIN / User ID (contoh `1001`)
   - Nama (opsional, tidak dipakai sistem untuk mapping)

#### B. Enroll Fingerprint
1. Pilih user.
2. Pilih menu **Fingerprint**.
3. Scan jari beberapa kali sampai sukses.
4. Disarankan:
   - 2–4 jari berbeda untuk cadangan.

#### C. Enroll Face
1. Pilih user.
2. Pilih menu **Face**.
3. Ikuti instruksi (posisi wajah, cahaya cukup).
4. Pastikan fitur face recognition aktif pada device.

#### D. Enroll RFID Card
1. Pilih user.
2. Pilih menu **Card / RFID**.
3. Tempel kartu ke reader untuk registrasi.

Catatan penting:
- Saat user menggunakan face/finger/RFID, log yang dikirim tetap mengandung **PIN**. Sistem web akan membedakan metode autentikasi dari kolom `verify_mode` bila device mengirimkannya.

### 8) Verifikasi di Website (Admin Panel)

#### A. Pastikan Device Terdeteksi
1. Setelah device mengirim data ke server, buka:
   - `/admin/absensi/devices`
2. Device akan muncul berdasarkan `SN` yang dikirim.

#### B. Mapping PIN ke Guru/Siswa/User
1. Buka:
   - `/admin/absensi/mapping`
2. Pilih `kind`:
   - `guru` untuk data guru
   - `siswa` untuk data siswa
   - `user` untuk akun user Laravel
3. Isi `guru_id` / `siswa_id` / `user_id` sesuai kind.
4. Isi `PIN` sama seperti PIN di device.

Cara cepat melihat ID:
- Buka detail data di admin, biasanya ID terlihat di URL (misalnya `/admin/guru/12` berarti `guru_id = 12`).

#### C. Rekap Harian
1. Buka:
   - `/admin/absensi`
2. Pilih tanggal.
3. Jika log sudah ada dan mapping benar, rekap akan terisi.

Jika rekap belum muncul, jalankan manual:
```
php artisan attendance:sync
```

### 9) Seeder (Data Contoh)

Seeder tersedia untuk membuat contoh device dan mapping awal:
- [AttendanceSeeder.php](file:///d:/PROJECT/LARAVEL/ig-to-web/database/seeders/AttendanceSeeder.php)

Jalankan:
1. Pastikan migrasi sudah dijalankan:
```
php artisan migrate
```
2. Jalankan seeder:
```
php artisan db:seed --class="Database\\Seeders\\AttendanceSeeder"
```

### 10) Troubleshooting Cepat

#### Device tidak muncul di `/admin/absensi/devices`
- Pastikan URL server di device benar (domain bisa diakses dari jaringan sekolah).
- Pastikan port 80/443 terbuka di VPS.
- Pastikan DNS domain mengarah ke VPS.
- Cek akses endpoint di browser:
  - `https://domain-anda.com/iclock/cdata?SN=TEST&token=TOKEN`
  - Harus merespon `OK` (403 jika token salah).

#### Muncul 403 Forbidden
- Token device tidak sama dengan `ATTENDANCE_ICLOCK_SECRET`.
- Pastikan URL device berisi `?token=...`.

#### Log ada tapi rekap kosong
- Mapping PIN belum dibuat di `/admin/absensi/mapping`.
- Jalankan `php artisan attendance:sync` atau pastikan scheduler berjalan.

