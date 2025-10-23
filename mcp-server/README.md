# IG-to-Web MCP Server

Model Context Protocol (MCP) Server untuk project Laravel IG-to-Web. Server ini memungkinkan AI assistant untuk berinteraksi dengan project Laravel Anda.

## Fitur

### Tools (Alat)
1. **read_file** - Membaca isi file dalam project Laravel
2. **list_directory** - Menampilkan isi direktori
3. **artisan_command** - Menjalankan perintah Laravel Artisan
4. **search_files** - Mencari term tertentu di seluruh project
5. **get_routes** - Mendapatkan semua routes Laravel
6. **get_models** - Menampilkan semua Eloquent models
7. **get_controllers** - Menampilkan semua controllers

### Resources (Sumber Daya)
1. **laravel://config** - Akses ke file konfigurasi Laravel
2. **laravel://routes** - Semua routes yang terdaftar
3. **laravel://models** - Daftar semua Eloquent models

## Instalasi

1. Masuk ke direktori mcp-server:
```bash
cd mcp-server
```

2. Install dependencies:
```bash
npm install
```

## Cara Menggunakan

### Menjalankan Server

```bash
npm start
```

Atau untuk mode development dengan auto-reload:
```bash
npm run dev
```

### Konfigurasi di Claude Desktop

Tambahkan konfigurasi berikut ke file konfigurasi Claude Desktop Anda:

**Windows**: `%APPDATA%\Claude\claude_desktop_config.json`

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

### Konfigurasi di Cursor

Tambahkan ke settings Cursor Anda:

1. Buka Cursor Settings (Ctrl+,)
2. Cari "MCP"
3. Tambahkan server configuration:

```json
{
  "mcp.servers": {
    "ig-to-web": {
      "command": "node",
      "args": ["E:\\PROJEK  LARAVEL\\ig-to-web\\mcp-server\\index.js"],
      "cwd": "E:\\PROJEK  LARAVEL\\ig-to-web\\mcp-server"
    }
  }
}
```

## Contoh Penggunaan

### Membaca File
```
Tool: read_file
Arguments: { "path": "app/Models/User.php" }
```

### Menampilkan Direktori
```
Tool: list_directory
Arguments: { "path": "app/Http/Controllers" }
```

### Menjalankan Artisan Command
```
Tool: artisan_command
Arguments: { "command": "route:list" }
```

### Mencari di Files
```
Tool: search_files
Arguments: { "term": "InstagramService", "directory": "app" }
```

### Mendapatkan Routes
```
Tool: get_routes
Arguments: {}
```

### Mendapatkan Models
```
Tool: get_models
Arguments: {}
```

### Mendapatkan Controllers
```
Tool: get_controllers
Arguments: {}
```

## Struktur Project

```
mcp-server/
├── index.js          # Main server file
├── package.json      # Dependencies and scripts
└── README.md         # Documentation (file ini)
```

## Keamanan

Server ini dirancang untuk berjalan secara lokal dan hanya mengakses project Laravel Anda. Beberapa hal yang perlu diperhatikan:

- Server hanya dapat mengakses file dalam direktori project
- Perintah Artisan dijalankan dengan batasan buffer 10MB
- Direktori tertentu (node_modules, vendor, storage, .git) diabaikan dalam pencarian
- Hanya file teks yang dicari (php, js, css, html, json, md, txt)

## Troubleshooting

### Server tidak dapat membaca file
- Pastikan path yang diberikan benar dan relatif terhadap root project
- Periksa permission file

### Artisan command gagal
- Pastikan PHP terinstall dan dapat diakses dari command line
- Pastikan berada di direktori project Laravel yang valid

### Error "Cannot find module"
- Jalankan `npm install` di direktori mcp-server
- Pastikan Node.js versi 18+ terinstall

## Requirements

- Node.js 18+
- PHP 8.1+
- Laravel 10+
- NPM atau Yarn

## License

MIT License

