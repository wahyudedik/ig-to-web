# Panduan Instalasi MCP Server

## Langkah-langkah Instalasi

### 1. Install Dependencies

Buka terminal/PowerShell di direktori `mcp-server` dan jalankan:

```bash
npm install
```

### 2. Test Server

Jalankan server untuk memastikan tidak ada error:

```bash
npm start
```

Jika berhasil, Anda akan melihat pesan:
```
IG-to-Web MCP Server running on stdio
```

Tekan Ctrl+C untuk menghentikan.

### 3. Konfigurasi Claude Desktop

#### Lokasi File Konfigurasi
- **Windows**: `%APPDATA%\Claude\claude_desktop_config.json`
- **macOS**: `~/Library/Application Support/Claude/claude_desktop_config.json`
- **Linux**: `~/.config/Claude/claude_desktop_config.json`

#### Cara Setup

1. Buka atau buat file `claude_desktop_config.json`

2. Tambahkan konfigurasi berikut:

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

3. **Penting**: Ganti path sesuai dengan lokasi project Anda!

4. Restart Claude Desktop

### 4. Verifikasi

Setelah restart Claude Desktop:

1. Buka Claude
2. Lihat di bagian bawah jendela chat
3. Anda harus melihat icon atau indicator bahwa MCP server "ig-to-web" terhubung
4. Coba tanyakan: "Apa saja tools yang tersedia?"

## Konfigurasi untuk Cursor

### Setup di Cursor

1. Buka Cursor
2. Tekan `Ctrl+,` (Settings)
3. Cari "MCP" atau buka settings.json
4. Tambahkan:

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

5. Restart Cursor

## Troubleshooting

### Error: Cannot find module '@modelcontextprotocol/sdk'

**Solusi**: Jalankan `npm install` di direktori mcp-server

### Error: Node is not recognized

**Solusi**: 
1. Install Node.js dari https://nodejs.org/ (versi LTS)
2. Restart terminal/PowerShell
3. Verifikasi dengan: `node --version`

### Server tidak muncul di Claude

**Solusi**:
1. Pastikan path di config benar (gunakan path absolut)
2. Pastikan tidak ada typo di file JSON
3. Restart Claude Desktop sepenuhnya (quit dan buka lagi)
4. Cek logs di: `%APPDATA%\Claude\logs\`

### Permission Error

**Solusi**:
1. Jalankan terminal/PowerShell as Administrator
2. Install ulang dependencies: `npm install`

### Artisan Command Tidak Jalan

**Solusi**:
1. Pastikan PHP terinstall: `php --version`
2. Pastikan berada di direktori Laravel yang valid
3. Coba jalankan manual: `php artisan route:list`

## Cara Menggunakan

Setelah terkonfigurasi, Anda bisa bertanya ke Claude:

- "Baca file User.php di folder Models"
- "Tampilkan semua routes"
- "Cari kata 'Instagram' di folder app"
- "Jalankan artisan command migrate:status"
- "Tampilkan semua models"

## Update MCP Server

Jika ada update di file `index.js`:

1. Tidak perlu install ulang
2. Cukup restart Claude Desktop atau Cursor
3. Perubahan akan langsung diterapkan

## Uninstall

Untuk menghapus MCP server:

1. Hapus konfigurasi dari `claude_desktop_config.json`
2. Restart Claude Desktop
3. (Optional) Hapus folder `mcp-server`

