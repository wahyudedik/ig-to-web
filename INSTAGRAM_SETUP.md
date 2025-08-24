# Instagram API Integration Setup

Halaman ini menjelaskan cara mengintegrasikan Instagram API dengan website sekolah untuk menampilkan postingan Instagram secara otomatis.

## Fitur yang Tersedia

- ✅ Tampilan postingan Instagram dalam format grid yang responsif
- ✅ Cache data untuk performa optimal
- ✅ Auto-refresh setiap 30 menit
- ✅ Manual refresh dengan tombol
- ✅ Tampilan like count dan comment count
- ✅ Link langsung ke postingan Instagram
- ✅ Dark mode support
- ✅ Mobile responsive

## Setup Instagram API

### 1. Membuat Facebook App

1. Kunjungi [Facebook Developers](https://developers.facebook.com/)
2. Buat aplikasi baru atau gunakan yang sudah ada
3. Pilih "Consumer" sebagai jenis aplikasi
4. Isi informasi aplikasi yang diperlukan

### 2. Menambahkan Instagram Basic Display

1. Di dashboard aplikasi, klik "Add Product"
2. Pilih "Instagram Basic Display"
3. Ikuti langkah setup yang diberikan

### 3. Mengatur Instagram Basic Display

1. **Basic Settings:**
   - App Domains: `yourdomain.com`
   - Privacy Policy URL: `https://yourdomain.com/privacy`
   - Terms of Service URL: `https://yourdomain.com/terms`

2. **Instagram Basic Display Settings:**
   - Client OAuth Settings:
     - Valid OAuth Redirect URIs: `https://yourdomain.com/instagram/callback`
   - Deauthorize Callback URL: `https://yourdomain.com/instagram/deauthorize`
   - Data Deletion Request URL: `https://yourdomain.com/instagram/data-deletion`

### 4. Mendapatkan Access Token

1. **Untuk testing:**
   - Gunakan Instagram Basic Display API
   - Generate token melalui Instagram Basic Display

2. **Untuk production:**
   - Gunakan Instagram Graph API
   - Hubungkan dengan Facebook Page
   - Generate Page Access Token

### 5. Konfigurasi Environment Variables

Tambahkan variabel berikut ke file `.env`:

```env
# Instagram API Configuration
INSTAGRAM_ACCESS_TOKEN=your_access_token_here
INSTAGRAM_USER_ID=your_user_id_here
INSTAGRAM_APP_ID=your_app_id_here
INSTAGRAM_APP_SECRET=your_app_secret_here
INSTAGRAM_REDIRECT_URI=https://yourdomain.com/instagram/callback
```

### 6. Mengaktifkan Real API

Untuk menggunakan API Instagram yang sebenarnya, edit file `app/Services/InstagramService.php`:

1. Uncomment bagian API call yang sudah disediakan
2. Comment bagian mock data
3. Pastikan access token dan user ID sudah benar

```php
// Uncomment ini untuk menggunakan API sebenarnya
$response = Http::get($this->baseUrl . "/{$this->userId}/media", [
    'fields' => 'id,caption,media_type,media_url,permalink,timestamp,like_count,comment_count',
    'access_token' => $this->accessToken,
    'limit' => $limit
]);
```

## Struktur Data

### Format Data Instagram Post

```php
[
    'id' => 'post_id',
    'caption' => 'Caption postingan',
    'media_url' => 'URL gambar/video',
    'media_type' => 'IMAGE|VIDEO|CAROUSEL_ALBUM',
    'permalink' => 'URL postingan Instagram',
    'timestamp' => '2024-01-01T12:00:00+0000',
    'like_count' => 123,
    'comment_count' => 45
]
```

## API Endpoints

### Halaman Utama
- `GET /kegiatan` - Halaman tampilan kegiatan Instagram

### API Endpoints
- `GET /kegiatan/posts` - Mendapatkan data postingan (JSON)
- `GET /kegiatan/refresh` - Refresh data postingan
- `GET /kegiatan/account` - Informasi akun Instagram
- `GET /kegiatan/validate` - Validasi koneksi Instagram

## Cache Management

Data Instagram di-cache selama 1 jam untuk performa optimal:

```php
// Cache duration: 1 hour
Cache::remember('instagram_posts', 3600, function () {
    return $this->fetchPosts();
});
```

## Customization

### Mengubah Tampilan

File view: `resources/views/instagram/activities.blade.php`

### Mengubah Logika API

File service: `app/Services/InstagramService.php`

### Mengubah Controller

File controller: `app/Http/Controllers/InstagramController.php`

## Troubleshooting

### Error: "Invalid access token"
- Pastikan access token masih valid
- Regenerate token jika diperlukan
- Periksa permission yang diberikan

### Error: "Rate limit exceeded"
- Instagram API memiliki rate limit
- Implementasikan delay antara request
- Gunakan cache untuk mengurangi request

### Error: "Permission denied"
- Pastikan aplikasi sudah disetujui oleh Instagram
- Periksa scope permission yang diminta
- Pastikan akun Instagram terhubung dengan benar

## Security Considerations

1. **Jangan expose access token** di frontend
2. **Gunakan HTTPS** untuk semua request
3. **Validasi input** sebelum mengirim ke API
4. **Implementasikan rate limiting** untuk mencegah abuse
5. **Monitor API usage** untuk mendeteksi anomali

## Monitoring

### Log Files
- API errors: `storage/logs/laravel.log`
- Cache hits/misses: Monitor cache performance

### Health Check
- Endpoint: `/kegiatan/validate`
- Returns connection status

## Performance Optimization

1. **Cache Strategy:**
   - Cache data selama 1 jam
   - Implement lazy loading untuk gambar
   - Use CDN untuk gambar

2. **Database Optimization:**
   - Index pada kolom yang sering di-query
   - Optimize query untuk data besar

3. **Frontend Optimization:**
   - Lazy load images
   - Implement infinite scroll
   - Use WebP format for images

## Support

Untuk bantuan lebih lanjut:
- Dokumentasi Instagram API: [Instagram Basic Display API](https://developers.facebook.com/docs/instagram-basic-display-api)
- Laravel Documentation: [Laravel HTTP Client](https://laravel.com/docs/http-client)
- Facebook Developers: [Facebook Developers](https://developers.facebook.com/)
