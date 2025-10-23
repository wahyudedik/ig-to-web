# 📚 Contoh Penggunaan MCP Server

Dokumen ini berisi contoh-contoh nyata penggunaan MCP Server dengan Claude AI untuk membantu development project Laravel IG-to-Web.

## 🎯 Scenario 1: Debugging Route Error

### Problem
User melaporkan error 404 saat mengakses halaman OSIS.

### Conversation dengan Claude

**You**: "Tampilkan semua routes yang terkait dengan OSIS"

**Claude**: *Menggunakan tool `get_routes` dan filter OSIS*

**You**: "Baca file routes/web.php bagian OSIS"

**Claude**: *Menggunakan tool `read_file` untuk membaca routes*

**You**: "Sekarang baca controller OSISController"

**Claude**: *Membaca file controller dan menemukan masalah*

**Result**: Claude menemukan route menggunakan method yang salah dan memberikan solusi.

---

## 🎯 Scenario 2: Memahami Struktur Model

### Problem
Developer baru ingin memahami relasi antara model User dan model lainnya.

### Conversation dengan Claude

**You**: "Tampilkan semua models yang ada"

**Claude**: *Menggunakan tool `get_models`*

**You**: "Baca file app/Models/User.php"

**Claude**: *Membaca model User*

**You**: "Cari semua file yang menggunakan model User di folder Controllers"

**Claude**: *Menggunakan tool `search_files` dengan term "User" di app/Http/Controllers*

**Result**: Claude memberikan overview lengkap tentang bagaimana User model digunakan dalam aplikasi.

---

## 🎯 Scenario 3: Audit Kode untuk TODO Items

### Problem
Tim ingin tahu apa saja TODO yang masih pending dalam codebase.

### Conversation dengan Claude

**You**: "Cari semua TODO di folder app"

**Claude**: *Menggunakan tool `search_files` dengan term "TODO"*

**You**: "Kategorikan TODO berdasarkan prioritas dan folder"

**Claude**: *Menganalisis hasil dan membuat daftar terorganisir*

**Result**: Daftar lengkap TODO dengan lokasi file dan konteks.

---

## 🎯 Scenario 4: Setup Fitur Baru Instagram

### Problem
Ingin menambahkan fitur baru untuk Instagram integration.

### Conversation dengan Claude

**You**: "Tampilkan struktur folder app/Services dan baca InstagramService.php"

**Claude**: *List directory dan read file*

**You**: "Lihat semua controller yang menggunakan InstagramService"

**Claude**: *Search dan analisis usage*

**You**: "Apa saja routes yang terkait dengan Instagram?"

**Claude**: *Filter routes yang berhubungan dengan Instagram*

**Result**: Claude memberikan blueprint lengkap untuk menambahkan fitur baru.

---

## 🎯 Scenario 5: Refactoring Code

### Problem
Ingin refactor GuruController untuk mengurangi duplicate code.

### Conversation dengan Claude

**You**: "Baca file app/Http/Controllers/GuruController.php"

**Claude**: *Membaca controller*

**You**: "Identifikasi pattern yang berulang dan bisa di-extract ke method terpisah"

**Claude**: *Menganalisis dan menemukan duplicate code*

**You**: "Baca juga SiswaController untuk comparison"

**Claude**: *Membaca dan membandingkan*

**Result**: Claude memberikan rekomendasi refactoring dengan code examples.

---

## 🎯 Scenario 6: Troubleshooting Migration Error

### Problem
Migration gagal dengan error foreign key constraint.

### Conversation dengan Claude

**You**: "Jalankan artisan migrate:status"

**Claude**: *Menggunakan tool `artisan_command`*

**You**: "Tampilkan isi folder database/migrations"

**Claude**: *List directory migrations*

**You**: "Baca migration file yang error"

**Claude**: *Read specific migration file*

**Result**: Claude menemukan urutan migration yang salah dan memberikan solusi.

---

## 🎯 Scenario 7: Optimasi Query Database

### Problem
Dashboard loading lambat karena query yang tidak optimal.

### Conversation dengan Claude

**You**: "Baca file app/Http/Controllers/DashboardController.php"

**Claude**: *Membaca controller*

**You**: "Cari semua query yang tidak menggunakan eager loading"

**Claude**: *Menganalisis query patterns*

**You**: "Baca models yang digunakan untuk memahami relasi"

**Claude**: *Membaca models terkait*

**Result**: Claude memberikan rekomendasi untuk optimasi dengan eager loading.

---

## 🎯 Scenario 8: Dokumentasi API Endpoint

### Problem
Perlu dokumentasi untuk semua API endpoints.

### Conversation dengan Claude

**You**: "Tampilkan semua routes yang dimulai dengan /api"

**Claude**: *Filter routes API*

**You**: "Untuk setiap endpoint, baca controller methodnya"

**Claude**: *Membaca controllers untuk API*

**You**: "Generate dokumentasi API dalam format Markdown"

**Claude**: *Membuat dokumentasi lengkap*

**Result**: Dokumentasi API lengkap dengan request/response examples.

---

## 🎯 Scenario 9: Security Audit

### Problem
Ingin memastikan tidak ada security vulnerability dalam code.

### Conversation dengan Claude

**You**: "Cari semua penggunaan 'DB::raw' di folder app"

**Claude**: *Search untuk raw queries*

**You**: "Cari semua input yang tidak di-validate"

**Claude**: *Search untuk $_GET, $_POST, request()->*

**You**: "Baca semua Policy files"

**Claude**: *Read all policies untuk audit authorization*

**Result**: Claude memberikan security audit report dengan recommendations.

---

## 🎯 Scenario 10: Setup Testing

### Problem
Ingin membuat test untuk fitur OSIS voting.

### Conversation dengan Claude

**You**: "Baca file tests/Feature yang sudah ada"

**Claude**: *Membaca existing tests*

**You**: "Baca OsisElectionController untuk memahami flow"

**Claude**: *Membaca controller*

**You**: "Baca model OsisElection dan Voting"

**Claude**: *Membaca models*

**You**: "Buatkan test case untuk voting feature"

**Claude**: *Generate test cases berdasarkan code analysis*

**Result**: Test file lengkap yang siap digunakan.

---

## 🎯 Scenario 11: Performance Analysis

### Problem
Aplikasi terasa lambat di production.

### Conversation dengan Claude

**You**: "Jalankan artisan route:list dan tampilkan yang tidak menggunakan middleware cache"

**Claude**: *Analisis routes*

**You**: "Cari semua query N+1 problem di Controllers"

**Claude**: *Search dan analisis query patterns*

**You**: "Baca config/cache.php dan config/session.php"

**Claude**: *Membaca konfigurasi*

**Result**: Claude memberikan performance optimization checklist.

---

## 🎯 Scenario 12: Onboarding Developer Baru

### Problem
Developer baru perlu memahami arsitektur aplikasi.

### Conversation dengan Claude

**You**: "Jelaskan struktur folder app/ secara detail"

**Claude**: *List dan jelaskan setiap folder*

**You**: "Apa saja modul utama dalam aplikasi ini?"

**Claude**: *Menganalisis controllers, models, dan routes*

**You**: "Bagaimana flow dari landing page ke dashboard?"

**Claude**: *Trace code flow*

**Result**: Onboarding documentation lengkap dengan diagram flow.

---

## 💡 Tips & Best Practices

### 1. Gunakan Context
Berikan context yang cukup dalam pertanyaan:
```
❌ "Baca controller"
✅ "Baca GuruController untuk memahami CRUD operations"
```

### 2. Bertahap
Pecah pertanyaan kompleks menjadi beberapa steps:
```
1. "Tampilkan struktur folder Controllers"
2. "Baca UserController"
3. "Cari penggunaan UserController di routes"
```

### 3. Spesifik
Gunakan path lengkap jika perlu:
```
❌ "Baca User.php"
✅ "Baca app/Models/User.php"
```

### 4. Kombinasi Tools
Manfaatkan berbagai tools dalam satu conversation:
```
1. Search → untuk menemukan
2. Read → untuk memahami detail
3. Artisan → untuk verifikasi
```

### 5. Iteratif
Gunakan hasil dari query sebelumnya:
```
"Dari hasil search tadi, baca file yang paling sering muncul"
```

---

## 🚀 Advanced Use Cases

### Multi-file Refactoring
```
1. "Cari pattern duplicate di semua Controllers"
2. "Identifikasi code yang bisa di-extract ke Service"
3. "Generate Service class baru dengan best practices"
```

### Database Schema Analysis
```
1. "List semua migrations"
2. "Baca migrations untuk memahami schema"
3. "Bandingkan dengan Models untuk konsistensi"
```

### Dependency Analysis
```
1. "Baca composer.json"
2. "Cari penggunaan package X di codebase"
3. "Identifikasi dependencies yang tidak terpakai"
```

---

## 🎓 Learning Patterns

### Untuk Pemula
- Mulai dengan explore: "Tampilkan struktur folder"
- Pelajari satu modul: "Jelaskan modul Guru"
- Trace flow: "Bagaimana proses login bekerja?"

### Untuk Intermediate
- Analisis pattern: "Apa pattern yang digunakan di Controllers?"
- Compare implementations: "Bandingkan GuruController dengan SiswaController"
- Optimization: "Identifikasi area yang bisa dioptimasi"

### Untuk Advanced
- Architecture review: "Analisis architecture decisions"
- Security audit: "Review security implementations"
- Performance tuning: "Identifikasi bottlenecks"

---

## 📝 Template Queries

### Debugging
```
"Trace error [error message] di codebase"
"Cari penyebab bug di [fitur]"
"Analisis flow dari [start] sampai [end]"
```

### Development
```
"Bagaimana cara menambahkan fitur [X]?"
"Apa saja yang perlu diubah untuk [Y]?"
"Generate boilerplate untuk [Z]"
```

### Maintenance
```
"Identifikasi deprecated code"
"Cari TODO yang high priority"
"Analisis technical debt"
```

### Documentation
```
"Generate API documentation"
"Buat diagram flow untuk [fitur]"
"Dokumentasikan [modul]"
```

---

## ✅ Checklist: Memaksimalkan MCP Server

- [ ] Setup MCP server dengan benar
- [ ] Familiarize dengan semua tools yang tersedia
- [ ] Baca CHEATSHEET.md untuk reference cepat
- [ ] Mulai dengan queries sederhana
- [ ] Eksplorasi codebase secara sistematis
- [ ] Kombinasikan multiple tools
- [ ] Gunakan untuk daily development tasks
- [ ] Share tips dengan team
- [ ] Dokumentasikan use cases yang berguna
- [ ] Berikan feedback untuk improvement

---

**Happy coding with MCP Server! 🚀**

