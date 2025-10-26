# 📋 Development Rules - MCP Server

## 🎯 Peraturan Pengembangan

### 1. 📚 Dokumentasi

#### ❌ JANGAN Membuat Dokumentasi Terlalu Sering
- **Jangan** update dokumentasi setiap kali ada perubahan kecil
- **Jangan** membuat file dokumentasi baru untuk setiap feature minor
- **Jangan** duplicate informasi di multiple files

#### ✅ Kapan Membuat/Update Dokumentasi
- **HANYA** update dokumentasi jika:
  - ✅ Fitur sudah **FINAL** dan **FIX** (tested & working)
  - ✅ Ada breaking changes yang significant
  - ✅ Ada tools/features baru yang major
  - ✅ Bug fix yang mempengaruhi cara penggunaan

#### 📝 Best Practices Dokumentasi
1. **Consolidate** - Gabungkan update kecil, release dokumentasi sekaligus
2. **Test First** - Pastikan fitur bekerja sempurna sebelum dokumentasi
3. **User Focus** - Hanya dokumentasi yang user butuh tahu
4. **Keep It Simple** - Jangan over-document

---

### 2. 🔧 Development Workflow

#### Feature Development
```
1. Code feature
2. Test extensively
3. Fix bugs
4. Test again
5. ✅ BARU update dokumentasi (jika perlu)
```

#### Bug Fixing
```
1. Fix bug
2. Test
3. Commit
4. ❌ Skip dokumentasi untuk bug fix minor
5. ✅ Update docs jika breaking change
```

---

### 3. 📂 File Dokumentasi Priority

#### High Priority (Update jika major changes)
- `README.md` - Overview & quick start
- `QUICKSTART.md` - Getting started guide
- `CHEATSHEET.md` - Quick reference

#### Medium Priority (Update jika ada new features)
- `ADVANCED_FEATURES.md` - Detailed features
- `EXAMPLES.md` - Usage examples

#### Low Priority (Rarely update)
- `INSTALL.md` - Installation guide (stable)
- `UPGRADE_TO_V2.md` - Migration guide (one-time)

---

### 4. 🚫 Anti-Patterns (Hindari)

❌ **Jangan:**
- Update 5 file dokumentasi untuk 1 fitur kecil
- Buat dokumentasi sebelum fitur tested
- Copy-paste sama info ke multiple files
- Write documentation untuk internal functions
- Over-explain obvious things

✅ **Lakukan:**
- Batch documentation updates
- Document only user-facing changes
- Keep docs DRY (Don't Repeat Yourself)
- Write docs in bahasa yang clear & simple
- Focus on "how to use" bukan "how it works internally"

---

### 5. 🎯 Documentation Checklist

Sebelum update dokumentasi, tanya diri sendiri:

- [ ] Apakah fitur sudah **100% working & tested**?
- [ ] Apakah ini **breaking change** atau **major feature**?
- [ ] Apakah user **benar-benar butuh tahu** ini?
- [ ] Apakah bisa di-batch dengan update lain?
- [ ] Apakah info ini belum ada di docs existing?

**Jika jawaban 3+ adalah "Ya", baru update dokumentasi.**

---

### 6. 📊 Version Numbering

#### Major Update (x.0.0)
- Breaking changes
- Major new features
- Architecture changes
- **✅ WAJIB update ALL documentation**

#### Minor Update (2.x.0)
- New features (backwards compatible)
- New tools/functions
- **✅ Update feature-related docs only**

#### Patch Update (2.1.x)
- Bug fixes
- Performance improvements
- Minor tweaks
- **❌ SKIP dokumentasi (or batch updates)**

---

### 7. 🎨 Code Quality Over Documentation

**Priority Order:**
1. 🥇 **Working Code** - Code harus jalan sempurna
2. 🥈 **Tests** - Pastikan tested thoroughly
3. 🥉 **Comments in Code** - Inline comments jika perlu
4. 🏅 **User Documentation** - Baru dokumentasi user-facing

**Ingat:** Better to have **working undocumented feature** than **broken documented feature**.

---

### 8. 📝 Commit Message Guidelines

```
✅ Good:
- "Add read_env tool with security masking"
- "Fix N+1 query detection in controllers"
- "Update docs for v2.1.0 release"

❌ Bad:
- "Update docs" (too vague)
- "Add feature and update 10 markdown files" (do separately)
- "WIP: feature X (includes docs)" (docs should come after WIP)
```

---

### 9. 🔄 Review Cycle

#### Before Push:
1. Code works? ✅
2. Tested? ✅
3. Breaking changes? 
   - Yes → Update docs ✅
   - No → Skip docs ❌

#### Before Release:
1. Batch all doc updates
2. Review all changes
3. Update version number
4. One commit for all doc updates

---

### 10. 💡 Golden Rule

> **"Document when necessary, not when possible."**

**Dokumentasi adalah untuk USER, bukan untuk showcase jumlah file.**

---

## 📌 Quick Reference

| Scenario | Update Docs? |
|----------|-------------|
| New tool (tested & working) | ✅ Yes |
| Bug fix (minor) | ❌ No |
| Bug fix (breaking change) | ✅ Yes |
| Performance tweak | ❌ No |
| New feature (WIP) | ❌ No |
| New feature (final) | ✅ Yes |
| Refactoring (internal) | ❌ No |
| API change (user-facing) | ✅ Yes |
| Code comments | ❌ No docs needed |
| Version release | ✅ Yes (batch) |

---

## ✅ Summary

**TL;DR:**
1. ❌ Jangan dokumentasi terlalu sering
2. ✅ Dokumentasi HANYA jika fitur sudah FIX
3. 🎯 Focus on user-facing changes
4. 📦 Batch updates when possible
5. 🚀 Code quality > Documentation quantity

---

**Version**: 1.0  
**Last Updated**: October 26, 2025  
**Status**: ✅ Active Guidelines


