# 🚀 MCP Server untuk IG-to-Web

Project ini sudah dilengkapi dengan **MCP (Model Context Protocol) Server** yang memungkinkan AI assistant seperti Claude untuk berinteraksi langsung dengan codebase Laravel Anda!

## 📁 Struktur MCP Server

```
mcp-server/
├── index.js                              # Server utama
├── package.json                          # Dependencies
├── test.js                              # Test script
├── setup.bat                            # Setup untuk Windows (Batch)
├── setup.ps1                            # Setup untuk Windows (PowerShell)
├── README.md                            # Dokumentasi lengkap
├── INSTALL.md                           # Panduan instalasi detail
├── QUICKSTART.md                        # Quick start guide
└── claude_desktop_config.example.json   # Contoh konfigurasi
```

## ⚡ Quick Start (5 Menit)

### 1. Setup

**Pilih salah satu:**

**Option A - Batch File (Mudah):**
```cmd
cd mcp-server
setup.bat
```

**Option B - PowerShell:**
```powershell
cd mcp-server
.\setup.ps1
```

**Option C - Manual:**
```bash
cd mcp-server
npm install
npm test
```

### 2. Konfigurasi Claude Desktop

Buka: `%APPDATA%\Claude\claude_desktop_config.json`

Tambahkan:
```json
{
  "mcpServers": {
    "ig-to-web": {
      "command": "node",
      "args": ["E:\\PROJEK  LARAVEL\\ig-to-web\\mcp-server\\index.js"],
      "cwd": "E:\\PROJEK  LARAVEL\\ig-to-web\\mcp-server"
    }
  }
}
```

⚠️ **Ganti path sesuai lokasi project Anda!**

### 3. Restart Claude Desktop

### 4. Done! 🎉

## 🛠️ Fitur yang Tersedia

### Tools

| Tool | Fungsi | Contoh Pertanyaan |
|------|--------|-------------------|
| **read_file** | Baca file | "Baca file User.php di Models" |
| **list_directory** | List folder | "Tampilkan isi folder Controllers" |
| **artisan_command** | Jalankan artisan | "Jalankan migrate:status" |
| **search_files** | Cari dalam files | "Cari kata 'Instagram' di app" |
| **get_routes** | Lihat routes | "Tampilkan semua routes" |
| **get_models** | Lihat models | "Apa saja models yang ada?" |
| **get_controllers** | Lihat controllers | "List semua controllers" |

### Resources

| Resource | URI | Deskripsi |
|----------|-----|-----------|
| **Config** | `laravel://config` | File konfigurasi Laravel |
| **Routes** | `laravel://routes` | Semua routes terdaftar |
| **Models** | `laravel://models` | Semua Eloquent models |

## 💬 Contoh Penggunaan di Claude

Setelah setup, Anda bisa bertanya dengan bahasa natural:

```
"Tolong baca file app/Models/User.php"

"Tampilkan semua routes yang ada dalam aplikasi"

"Cari kata 'InstagramService' di seluruh folder app"

"Jalankan artisan command route:list"

"Apa saja controllers yang ada?"

"Tampilkan isi folder app/Http/Controllers"

"Baca konfigurasi database"
```

## 📚 Dokumentasi Lengkap

- **[QUICKSTART.md](mcp-server/QUICKSTART.md)** - Panduan cepat 5 menit
- **[INSTALL.md](mcp-server/INSTALL.md)** - Instalasi detail + troubleshooting
- **[README.md](mcp-server/README.md)** - Dokumentasi teknis lengkap

## 🧪 Testing

Sebelum menggunakan, test dulu untuk memastikan semua berjalan:

```bash
cd mcp-server
npm test
```

Atau di Windows:
```cmd
cd mcp-server
test.bat
```

## ❓ Troubleshooting

### Server tidak connect di Claude

1. ✅ Pastikan path di config benar (gunakan path absolut)
2. ✅ Restart Claude Desktop sepenuhnya
3. ✅ Cek logs: `%APPDATA%\Claude\logs\`

### npm install error

1. ✅ Jalankan terminal sebagai Administrator
2. ✅ Clear cache: `npm cache clean --force`
3. ✅ Install ulang: `npm install`

### Artisan command tidak jalan

1. ✅ Cek PHP terinstall: `php --version`
2. ✅ Test manual: `php artisan route:list`
3. ✅ Pastikan di direktori Laravel yang valid

## 📋 Requirements

- ✅ Node.js 18 atau lebih baru
- ✅ PHP 8.1+
- ✅ Laravel 10+
- ✅ npm atau yarn

## 🎯 Apa yang Bisa Dilakukan?

Dengan MCP Server, Claude bisa:

1. 📖 **Membaca file** - Akses langsung ke codebase
2. 🔍 **Search codebase** - Cari kata/fungsi di seluruh project
3. 🗂️ **Explore struktur** - List file dan folder
4. ⚙️ **Jalankan artisan** - Execute Laravel commands
5. 🛣️ **Lihat routes** - Daftar semua routes
6. 🎨 **Analisis models** - Lihat struktur database
7. 🎮 **Inspect controllers** - Lihat semua controllers

## 🔒 Keamanan

- ✅ Server berjalan lokal saja
- ✅ Hanya akses folder project
- ✅ Tidak ada koneksi internet keluar
- ✅ Direktori sensitif (node_modules, vendor, .git) diabaikan

## 🌟 Tips Penggunaan

1. **Gunakan bahasa natural** - Tidak perlu syntax khusus
2. **Spesifik dalam request** - Sebutkan path jika perlu
3. **Gabungkan pertanyaan** - "Baca file X lalu cari Y"
4. **Explore bebas** - "Apa saja yang ada di folder Z?"

## 📝 License

MIT License - Bebas digunakan dan dimodifikasi

---

**Selamat menggunakan MCP Server! 🎉**

Jika ada pertanyaan atau masalah, lihat dokumentasi di folder `mcp-server/`

