# 📋 MCP Server Cheatsheet

## Setup Cepat

```bash
# 1. Install
cd mcp-server
npm install

# 2. Test
npm test

# 3. Configure Claude Desktop
# Edit: %APPDATA%\Claude\claude_desktop_config.json
# Add server config (see QUICKSTART.md)

# 4. Restart Claude Desktop
```

## Pertanyaan Umum ke Claude

### 📖 Membaca File

```
"Baca file app/Models/User.php"
"Tampilkan isi file routes/web.php"
"Lihat config/app.php"
```

### 🗂️ Menjelajah Folder

```
"Tampilkan isi folder app/Models"
"Apa saja yang ada di app/Http/Controllers?"
"List file di folder config"
```

### 🔍 Mencari

```
"Cari kata 'Instagram' di folder app"
"Temukan 'InstagramService' di seluruh project"
"Cari 'middleware' di app/Http"
```

### ⚙️ Artisan Commands

```
"Jalankan artisan route:list"
"Jalankan migrate:status"
"Jalankan list:commands"
"Jalankan about"
```

### 🛣️ Routes

```
"Tampilkan semua routes"
"List routes yang ada"
"Apa saja endpoint yang tersedia?"
```

### 🎨 Models

```
"Tampilkan semua models"
"List models yang ada"
"Apa saja model Eloquent?"
```

### 🎮 Controllers

```
"Tampilkan semua controllers"
"List controllers yang ada"
"Apa saja controller yang tersedia?"
```

### 🗄️ Database (NEW!)

```
"Query database: SELECT * FROM instagram_settings"
"Tampilkan data dari table users"
"Cek data instagram_settings limit 10"
"Jalankan PHP code: User::count()"
```

### 📊 Logs (NEW!)

```
"Baca log Laravel hari ini"
"Tampilkan 100 baris terakhir dari log"
"Lihat log tanggal 2025-01-15"
```

### 🔧 Konfigurasi

```
"Tampilkan konfigurasi database"
"Lihat konfigurasi mail"
"Baca config aplikasi"
```

## Tool Reference

### read_file
```json
{
  "tool": "read_file",
  "args": {
    "path": "app/Models/User.php"
  }
}
```

### list_directory
```json
{
  "tool": "list_directory",
  "args": {
    "path": "app/Http/Controllers"
  }
}
```

### search_files
```json
{
  "tool": "search_files",
  "args": {
    "term": "InstagramService",
    "directory": "app"
  }
}
```

### artisan_command
```json
{
  "tool": "artisan_command",
  "args": {
    "command": "route:list"
  }
}
```

### get_routes
```json
{
  "tool": "get_routes",
  "args": {}
}
```

### get_models
```json
{
  "tool": "get_models",
  "args": {}
}
```

### get_controllers
```json
{
  "tool": "get_controllers",
  "args": {}
}
```

### db_query (NEW!)
```json
{
  "tool": "db_query",
  "args": {
    "query": "SELECT * FROM instagram_settings"
  }
}
```

### db_table (NEW!)
```json
{
  "tool": "db_table",
  "args": {
    "table": "users",
    "limit": 10
  }
}
```

### read_logs (NEW!)
```json
{
  "tool": "read_logs",
  "args": {
    "lines": 100,
    "date": "2025-01-15"
  }
}
```

### tinker (NEW!)
```json
{
  "tool": "tinker",
  "args": {
    "code": "User::count()"
  }
}
```

## Resource Reference

### laravel://config
Akses semua file konfigurasi Laravel

### laravel://routes
Semua routes yang terdaftar dalam aplikasi

### laravel://models
Semua Eloquent models dengan kode lengkap

## Troubleshooting Cepat

| Masalah | Solusi |
|---------|--------|
| Server tidak connect | Restart Claude Desktop |
| npm install error | Jalankan sebagai Admin |
| Artisan error | Cek PHP terinstall |
| Path error | Gunakan path absolut |
| Module not found | `npm install` |

## Useful Commands

```bash
# Install dependencies
npm install

# Run tests
npm test

# Start server (manual test)
npm start

# Development mode
npm run dev

# Clean install
rm -rf node_modules
npm install
```

## File Locations

```
Config Claude (Windows): %APPDATA%\Claude\claude_desktop_config.json
Logs Claude: %APPDATA%\Claude\logs\
MCP Server: E:\PROJEK  LARAVEL\ig-to-web\mcp-server\
```

## Status Indicators

✅ Connected - Server terhubung ke Claude
⚠️ Connecting - Sedang menghubungkan
❌ Disconnected - Server tidak terhubung

## Tips & Tricks

1. **Kombinasi Tools**: "Baca file X lalu cari Y di dalamnya"
2. **Konteks**: Sebutkan path lengkap untuk hasil lebih akurat
3. **Natural Language**: Gunakan bahasa sehari-hari
4. **Batch Queries**: Tanya beberapa hal sekaligus
5. **Explore First**: Mulai dengan list directory

## Examples Workflow

### Debugging Route
```
1. "Tampilkan semua routes"
2. "Baca file routes/web.php"
3. "Baca controller yang handle route X"
```

### Explore Model
```
1. "Tampilkan semua models"
2. "Baca file app/Models/User.php"
3. "Cari penggunaan User model di controllers"
```

### Audit Codebase
```
1. "Cari kata 'TODO' di seluruh project"
2. "Cari 'deprecated' di app"
3. "List semua controllers"
```

## Need Help?

- 📖 Full docs: [README.md](README.md)
- 🚀 Quick start: [QUICKSTART.md](QUICKSTART.md)
- 🔧 Installation: [INSTALL.md](INSTALL.md)
- 🆘 Issues: Check logs in `%APPDATA%\Claude\logs\`

