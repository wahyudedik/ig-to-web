# Quick Start Guide - MCP Server

## Setup Cepat (5 Menit)

### Untuk Windows

1. **Buka PowerShell di folder `mcp-server`**
   ```powershell
   cd "E:\PROJEK  LARAVEL\ig-to-web\mcp-server"
   ```

2. **Jalankan setup script**
   ```powershell
   .\setup.ps1
   ```
   
   Atau manual:
   ```powershell
   npm install
   ```

3. **Konfigurasi Claude Desktop**
   
   Buka file: `%APPDATA%\Claude\claude_desktop_config.json`
   
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

4. **Restart Claude Desktop**

5. **Done!** 🎉

## Contoh Penggunaan di Claude

Setelah setup, Anda bisa bertanya:

### Membaca File
```
"Tolong baca file app/Models/User.php"
```

### Lihat Routes
```
"Tampilkan semua routes yang ada"
```

### Cari di Codebase
```
"Cari kata 'InstagramService' di seluruh project"
```

### Jalankan Artisan
```
"Jalankan artisan route:list"
```

### Lihat Models
```
"Tampilkan semua models yang ada"
```

### Lihat Controllers
```
"Tampilkan semua controllers"
```

### Lihat Isi Folder
```
"Tampilkan isi folder app/Http/Controllers"
```

## Tools yang Tersedia

| Tool | Deskripsi | Contoh |
|------|-----------|--------|
| `read_file` | Baca file | "Baca app/Models/User.php" |
| `list_directory` | List folder | "Tampilkan isi folder app" |
| `artisan_command` | Jalankan artisan | "Jalankan migrate:status" |
| `search_files` | Cari di files | "Cari 'Instagram' di app" |
| `get_routes` | Tampilkan routes | "Tampilkan semua routes" |
| `get_models` | List models | "Tampilkan models" |
| `get_controllers` | List controllers | "Tampilkan controllers" |

## Resources yang Tersedia

| Resource | URI | Deskripsi |
|----------|-----|-----------|
| Config | `laravel://config` | File konfigurasi Laravel |
| Routes | `laravel://routes` | Semua routes |
| Models | `laravel://models` | Semua models |

## Tips

1. **Gunakan bahasa natural** - Tidak perlu syntax khusus, berbicara normal saja
2. **Spesifik dalam request** - Sebutkan path lengkap jika perlu
3. **Gabungkan tools** - "Baca file X lalu cari kata Y di dalamnya"
4. **Explore codebase** - "Apa saja yang ada di folder controllers?"

## Troubleshooting Cepat

### Server tidak connect
1. Cek path di config benar
2. Restart Claude Desktop
3. Cek `%APPDATA%\Claude\logs\`

### npm install error
1. Jalankan sebagai Administrator
2. Clear npm cache: `npm cache clean --force`
3. Install ulang

### Artisan command error
1. Cek PHP terinstall: `php --version`
2. Test manual: `php artisan route:list`

## Next Steps

- Baca [README.md](README.md) untuk detail lengkap
- Baca [INSTALL.md](INSTALL.md) untuk troubleshooting
- Eksplorasi tools dengan bertanya ke Claude!

## Support

Jika ada masalah:
1. Cek logs di `%APPDATA%\Claude\logs\`
2. Pastikan semua dependencies terinstall
3. Verifikasi path di config benar

