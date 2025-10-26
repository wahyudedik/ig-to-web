# 🚀 Upgrade ke MCP Server v2.0 - SUPER ADVANCED

## ✨ Apa yang Baru di v2.0?

### 🔥 8 NEW ADVANCED TOOLS!

1. **🔍 detect_blade_errors** - Detect Blade template bugs
2. **🔍 detect_php_errors** - Detect PHP backend bugs  
3. **⚡ detect_n1_queries** - Find N+1 query problems
4. **🛡️ scan_security** - Security vulnerability scanner
5. **🧹 analyze_dead_code** - Find unused code
6. **📊 analyze_code_quality** - Code quality metrics
7. **🚀 profile_performance** - Performance profiler
8. **🔥 full_bug_scan** - Run ALL scans at once!

---

## 📥 Upgrade Steps (2 Menit!)

### Step 1: Update Config

Buka file: `%APPDATA%\Claude\claude_desktop_config.json`

**Ganti dari** (v1):
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

**Jadi** (v2):
```json
{
  "mcpServers": {
    "ig-to-web-v2": {
      "command": "node",
      "args": ["E:\\PROJEK  LARAVEL\\ig-to-web\\mcp-server\\index-v2.js"],
      "cwd": "E:\\PROJEK  LARAVEL\\ig-to-web\\mcp-server"
    }
  }
}
```

**Perubahan:** Hanya ubah 2 hal:
1. `"ig-to-web"` → `"ig-to-web-v2"`
2. `"index.js"` → `"index-v2.js"`

---

### Step 2: Restart Claude Desktop

1. **Quit** Claude Desktop (File → Quit)
2. **Buka lagi** Claude Desktop
3. Tunggu 5 detik

---

### Step 3: Test!

Di Claude, tanyakan:
```
"Apa saja tools yang tersedia?"
```

Kamu harus melihat **19 tools** (11 old + 8 new)! ✨

---

## 🧪 Quick Test Commands

Coba tools baru:

### Test 1: Scan Blade Errors
```
"Scan all Blade templates for errors"
```

### Test 2: Security Scan
```
"Run security scan on my Laravel app"
```

### Test 3: Find N+1 Queries
```
"Find N+1 queries in controllers"
```

### Test 4: FULL BUG SCAN! 🔥
```
"Run full bug scan on entire project"
```

---

## ❓ Troubleshooting

### Issue 1: Server not found

**Problem**: Claude says "ig-to-web-v2 not found"

**Solution**:
1. Cek typo di config file
2. Pastikan path benar
3. Restart Claude Desktop **sepenuhnya** (Quit, bukan minimize)

---

### Issue 2: Old tools still showing

**Problem**: Masih lihat tools lama, bukan v2

**Solution**:
1. Pastikan file config sudah disave
2. Hapus cache: `%APPDATA%\Claude\Cache\`
3. Restart Claude Desktop

---

### Issue 3: "Cannot find module"

**Problem**: Error "Cannot find module '@modelcontextprotocol/sdk'"

**Solution**:
```bash
cd mcp-server
npm install
```

---

## 🔄 Rollback to v1 (Jika Perlu)

Jika ada masalah, kembali ke v1:

Edit config:
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

Restart Claude.

---

## 📊 Feature Comparison

| Feature | v1.0 | v2.0 |
|---------|------|------|
| **Read files** | ✅ | ✅ |
| **List directories** | ✅ | ✅ |
| **Search files** | ✅ | ✅ |
| **Artisan commands** | ✅ | ✅ |
| **Get routes** | ✅ | ✅ |
| **Get models** | ✅ | ✅ |
| **Get controllers** | ✅ | ✅ |
| **DB queries** | ✅ | ✅ |
| **Read logs** | ✅ | ✅ |
| **Tinker** | ✅ | ✅ |
| **Bug Detection** | ❌ | ✅ NEW! |
| **Security Scan** | ❌ | ✅ NEW! |
| **N+1 Detector** | ❌ | ✅ NEW! |
| **Dead Code Analysis** | ❌ | ✅ NEW! |
| **Code Quality Metrics** | ❌ | ✅ NEW! |
| **Performance Profiling** | ❌ | ✅ NEW! |
| **Auto-fix Suggestions** | ❌ | ✅ NEW! |
| **Full Bug Scan** | ❌ | ✅ NEW! |

---

## 🎯 Recommended Usage

### Daily Development
```
"Find PHP errors in the file I'm working on"
"Check for security issues in AuthController"
```

### Before Commit
```
"Run detect_php_errors on app/Http/Controllers"
"Scan for Blade errors in views"
```

### Before Deploy
```
"Run full bug scan"
"Show me all critical security issues"
```

### Weekly Audit
```
"Find all N+1 queries"
"Analyze dead code in app/"
"Profile performance issues"
```

---

## 📚 Documentation

- **Full Features**: [ADVANCED_FEATURES.md](ADVANCED_FEATURES.md)
- **Cheatsheet**: [CHEATSHEET.md](CHEATSHEET.md)
- **Examples**: [EXAMPLES.md](EXAMPLES.md)
- **README**: [README.md](README.md)

---

## ✅ Upgrade Checklist

- [ ] Backup current config
- [ ] Update config to v2
- [ ] Restart Claude Desktop
- [ ] Test with "What tools are available?"
- [ ] Run a sample bug scan
- [ ] Read ADVANCED_FEATURES.md
- [ ] Try full_bug_scan on project
- [ ] Fix critical bugs found
- [ ] Celebrate! 🎉

---

## 🎉 Success!

Kalau sudah lihat 8 new tools di Claude, **upgrade berhasil!** ✨

Sekarang kamu punya:
- ✅ Bug detection otomatis
- ✅ Security vulnerability scanner
- ✅ N+1 query detector
- ✅ Dead code analyzer
- ✅ Code quality metrics
- ✅ Performance profiler
- ✅ Dan masih banyak lagi!

**Happy bug hunting! 🐛🔍✨**

---

**Version**: 2.0.0  
**Date**: October 26, 2025  
**Status**: ✅ Production Ready  
**Upgrade Time**: ~2 minutes  
**Difficulty**: Easy ⭐

