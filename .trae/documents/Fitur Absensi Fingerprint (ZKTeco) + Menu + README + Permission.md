## Ringkasan Kebutuhan
- Tambah sub-menu **Absensi** di dropdown **Academic** pada navbar admin.
- Buat modul **Absensi** yang mengambil log dari mesin fingerprint **ZKTeco**.
- Tambah **permission** untuk modul absensi (role tetap: superadmin, admin, guru, siswa, sarpras).
- Update README: dokumentasi absensi + dokumentasi fitur surat.

## Temuan Struktur Saat Ini
- Dropdown **Academic** ada di [navigation.blade.php](file:///d:/PROJECT/LARAVEL/ig-to-web/resources/views/layouts/navigation.blade.php#L25-L75).
- Fitur **Surat** sudah ada:
  - Routes: `admin/surat/*` di [web.php](file:///d:/PROJECT/LARAVEL/ig-to-web/routes/web.php#L92-L115).
  - Controller & permission middleware: [LetterOutController.php](file:///d:/PROJECT/LARAVEL/ig-to-web/app/Http/Controllers/LetterOutController.php), [LetterInController.php](file:///d:/PROJECT/LARAVEL/ig-to-web/app/Http/Controllers/LetterInController.php), [LetterFormatController.php](file:///d:/PROJECT/LARAVEL/ig-to-web/app/Http/Controllers/LetterFormatController.php).
  - Struktur tabel surat: [create_surat_tables.php](file:///d:/PROJECT/LARAVEL/ig-to-web/database/migrations/2026_02_03_000000_create_surat_tables.php).
  - Permission surat sudah didefinisikan di [PermissionSeeder.php](file:///d:/PROJECT/LARAVEL/ig-to-web/database/seeders/PermissionSeeder.php#L687-L811).

## Desain Modul Absensi (ZKTeco)
### A. Alur Integrasi yang Stabil
- Pilih pendekatan **Pull** (server menarik data log dari perangkat) karena paling umum dan stabil untuk ZKTeco di LAN.
- Protokol yang ditarget: koneksi ke perangkat via **Ethernet** (umumnya port 4370). Implementasi akan:
  - Connect → baca attendance logs → simpan ke DB → deduplicate → update `last_sync_at`.
- Catatan operasional:
  - Server aplikasi harus **satu jaringan** dengan perangkat (LAN/VPN), dan port device terbuka.

### B. Data Model & Tabel
- `attendance_devices`: konfigurasi perangkat (nama, IP, port, comm key, status aktif, last sync).
- `attendance_identities`: pemetaan “siapa” (guru/siswa/user) ke `device_pin` (PIN/ID di mesin).
- `attendance_logs`: log mentah dari device (waktu scan, pin, mode verifikasi, in/out, payload mentah).
- (Opsional tahap lanjut) `attendances`: rekap harian (first-in/last-out, status hadir/terlambat).

### C. Service Layer
- Tambah service `ZKTecoClient` (mis. `app/Services/ZKTeco/...`) untuk:
  - `connect()` / `disconnect()`
  - `fetchAttendanceLogs()`
  - (opsional) `fetchUsers()`
- Saat implementasi, akan diputuskan opsi paling aman:
  - memakai library PHP yang sudah terbukti/aktif (dicek dulu di ekosistem composer), atau
  - implementasi internal ringan (socket/UDP/TCP) mengikuti protokol ZKTeco yang umum dipakai.

### D. Command + Scheduler
- Artisan command: `attendance:sync` (bisa per device atau semua).
- Tambah jadwal di [console.php](file:///d:/PROJECT/LARAVEL/ig-to-web/routes/console.php) agar sync otomatis (mis. setiap 1–5 menit, `withoutOverlapping`).

## UI/Routes yang Akan Ditambahkan
### A. Menu
- Tambah item **Absensi** di dropdown **Academic** pada [navigation.blade.php](file:///d:/PROJECT/LARAVEL/ig-to-web/resources/views/layouts/navigation.blade.php#L25-L75).
- Visibility mengikuti pola yang ada:
  - tampil untuk role `guru|admin|superadmin`, atau jika user punya permission `attendance.view`.

### B. Routes
- Tambah group route `admin/absensi` (index, log viewer, sync manual, device management, mapping PIN).
- Middleware mengikuti praktik di proyek: `auth`, `verified`, dan/atau `role:guru|admin|superadmin` + permission middleware pada controller.

## Permission Absensi (Role Tetap Sama)
- Tambah permission baru di [PermissionSeeder.php](file:///d:/PROJECT/LARAVEL/ig-to-web/database/seeders/PermissionSeeder.php):
  - `attendance.view`
  - `attendance.sync`
  - `attendance.devices.view/create/edit/delete`
  - `attendance.mapping.manage`
  - `attendance.export` (opsional)
- Default perilaku saat ini: **superadmin otomatis dapat semua permission** (sesuai seeder); role lain bisa di-assign manual lewat UI role/permission yang sudah ada.

## Update README
- Tambah section **Absensi Fingerprint (ZKTeco)**:
  - cara kerja (pull/sync), prasyarat jaringan, konfigurasi device, mapping PIN.
  - rekomendasi device (sesuai daftar Anda): MB20, MB160, MB360, iFace 302/402.
- Tambah section **E-Surat**:
  - Surat Masuk, Surat Keluar, Format Surat (segment generator), counter per tahun/bulan/unit, upload scan, cetak PDF, audit log.
- Update daftar isi README agar dua fitur ini mudah ditemukan.

## Kriteria Selesai
- Menu **Absensi** muncul di dropdown Academic sesuai permission.
- Modul absensi bisa menyimpan log dari ZKTeco ke DB dan menampilkannya.
- Permission absensi tersedia di tabel permissions.
- README ter-update dengan dokumentasi Absensi & Surat.

Jika Anda setuju, setelah keluar dari plan mode saya akan mulai implementasi bertahap: (1) permission + menu + routes, (2) DB + service ZKTeco + command sync, (3) UI dasar absensi + dokumentasi README.