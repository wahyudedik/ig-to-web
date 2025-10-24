@extends('layouts.landing')

@section('content')
    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url({{ asset('assets/img/breadcrumb/01.jpg') }})">
        <div class="container">
            <h2 class="breadcrumb-title">Panduan Setup Instagram API</h2>
            <ul class="breadcrumb-menu">
                <li><a href="/">Beranda</a></li>
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="active">Setup Instagram</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- Documentation Content -->
    <div class="py-5 bg-light">
        <div class="container">
            <!-- Header -->
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <div class="mb-4">
                        <i class="fab fa-instagram fa-4x"
                            style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    </div>
                    <p class="lead text-muted">Panduan langkah demi langkah untuk mengintegrasikan Instagram dengan website
                        sekolah Anda</p>
                </div>
            </div>

            <!-- Overview -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        Gambaran Umum
                    </h2>
                    <p class="card-text">
                        Panduan ini akan membantu Anda mengatur integrasi Instagram API untuk website sekolah Anda.
                        Integrasi ini akan secara otomatis mengambil dan menampilkan postingan Instagram sekolah Anda di
                        website.
                    </p>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>Yang akan Anda dapatkan:</strong> Tampilan feed Instagram otomatis, dashboard analitik, dan
                        tools manajemen konten.
                    </div>
                </div>
            </div>

            <!-- Prerequisites -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">
                        <i class="fas fa-list-check text-success mr-2"></i>
                        Persyaratan
                    </h2>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Akun Facebook Business</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Akun Instagram Business</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Akses ke Facebook Developer
                            Console</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Akses Superadmin ke website
                            sekolah Anda</li>
                    </ul>
                </div>
            </div>

            <!-- Setup Steps -->
            @for ($i = 1; $i <= 7; $i++)
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="h4 mb-3">
                            <span class="badge bg-primary rounded-circle"
                                style="width: 2rem; height: 2rem; display: inline-flex; align-items: center; justify-content: center;">{{ $i }}</span>
                            @if ($i == 1)
                                Buat Facebook App
                            @elseif($i == 2)
                                Tambahkan Produk Instagram Basic Display
                            @elseif($i == 3)
                                Konfigurasi Instagram Basic Display
                            @elseif($i == 4)
                                Dapatkan Access Token
                            @elseif($i == 5)
                                Dapatkan User ID
                            @elseif($i == 6)
                                Konfigurasi Pengaturan Website
                            @elseif($i == 7)
                                Lihat Feed Instagram Anda
                            @endif
                        </h2>

                        @if ($i == 1)
                            <ol class="ps-3">
                                <li>Buka Facebook Developers: <a href="https://developers.facebook.com" target="_blank"
                                        class="text-primary">https://developers.facebook.com <i
                                            class="fas fa-external-link-alt text-xs"></i></a></li>
                                <li>Klik "My Apps" → "Create App"</li>
                                <li>Pilih "Consumer" sebagai tipe aplikasi</li>
                                <li>Isi detail aplikasi Anda dan klik "Create App"</li>
                            </ol>
                        @elseif($i == 2)
                            <ol class="ps-3">
                                <li>Di dashboard aplikasi Anda, klik "Add Product"</li>
                                <li>Cari "Instagram Basic Display" dan klik "Set Up"</li>
                                <li>Anda akan melihat produk Instagram Basic Display ditambahkan ke aplikasi Anda</li>
                            </ol>
                        @elseif($i == 3)
                            <ol class="ps-3">
                                <li>Buka "Instagram Basic Display" → "Basic Display"</li>
                                <li>Klik "Create New App"</li>
                                <li>Isi OAuth redirect URIs yang diperlukan</li>
                                <li>Klik "Create App"</li>
                            </ol>
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Penting:</strong> Ganti "yourdomain.com" dengan nama domain Anda yang sebenarnya.
                            </div>
                        @elseif($i == 4)
                            <ol class="ps-3">
                                <li>Di aplikasi Instagram Basic Display Anda, buka "User Token Generator"</li>
                                <li>Klik "Add or Remove Instagram Testers"</li>
                                <li>Tambahkan akun Instagram Anda sebagai tester</li>
                                <li>Kembali ke "User Token Generator"</li>
                                <li>Klik "Generate Token" di samping akun Instagram Anda</li>
                                <li>Salin access token yang dihasilkan</li>
                            </ol>
                        @elseif($i == 5)
                            <ol class="ps-3">
                                <li>Gunakan Instagram Basic Display API untuk mendapatkan user ID Anda</li>
                                <li>Buat GET request ke: <code class="bg-dark text-light px-2 py-1 rounded">GET
                                        https://graph.instagram.com/me?fields=id&access_token=ACCESS_TOKEN_ANDA</code></li>
                                <li>Response akan berisi user ID Anda</li>
                            </ol>
                        @elseif($i == 6)
                            <ol class="ps-3">
                                <li>Buka dashboard superadmin website sekolah Anda</li>
                                <li>Navigasi ke "Instagram Settings"</li>
                                <li>Masukkan Access Token dan User ID</li>
                                <li>Klik "Test Connection" untuk memverifikasi pengaturan Anda</li>
                                <li>Klik "Save Settings" untuk mengaktifkan integrasi</li>
                            </ol>
                        @elseif($i == 7)
                            <ol class="ps-3">
                                <li>Setelah menyimpan pengaturan, buka halaman feed Instagram website Anda</li>
                                <li>Kunjungi: <code class="bg-dark text-light px-2 py-1 rounded">/kegiatan</code></li>
                                <li>Anda akan melihat postingan Instagram ditampilkan secara otomatis</li>
                                <li>Feed akan diperbarui secara otomatis berdasarkan pengaturan sync Anda</li>
                            </ol>
                            <div class="alert alert-success mt-3">
                                <i class="fas fa-check-circle mr-2"></i>
                                <strong>Berhasil!</strong> Integrasi Instagram Anda sekarang aktif dan menampilkan postingan
                                di website Anda.
                            </div>
                        @endif
                    </div>
                </div>
            @endfor

            <!-- Troubleshooting -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">
                        <i class="fas fa-tools text-warning mr-2"></i>
                        Pemecahan Masalah
                    </h2>
                    <div class="accordion" id="troubleshootingAccordion">
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse1">
                                    Koneksi Gagal
                                </button>
                            </h3>
                            <div id="collapse1" class="accordion-collapse collapse show"
                                data-bs-parent="#troubleshootingAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Verifikasi Access Token Anda benar dan belum kadaluarsa</li>
                                        <li>Periksa bahwa User ID Anda benar</li>
                                        <li>Pastikan akun Instagram Anda adalah akun Business</li>
                                        <li>Pastikan aplikasi Anda disetujui untuk Instagram Basic Display</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse2">
                                    Tidak Ada Postingan yang Muncul
                                </button>
                            </h3>
                            <div id="collapse2" class="accordion-collapse collapse"
                                data-bs-parent="#troubleshootingAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Periksa apakah akun Instagram Anda memiliki postingan</li>
                                        <li>Verifikasi bahwa postingan bersifat publik</li>
                                        <li>Coba sinkronisasi data secara manual</li>
                                        <li>Periksa pengaturan frekuensi sinkronisasi</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3">
                                    Token Kadaluarsa
                                </button>
                            </h3>
                            <div id="collapse3" class="accordion-collapse collapse"
                                data-bs-parent="#troubleshootingAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Token Instagram kadaluarsa setelah 60 hari</li>
                                        <li>Generate token baru dari Facebook Developer Console</li>
                                        <li>Perbarui token di pengaturan website Anda</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support Links -->
            <div class="card shadow-sm mb-4 bg-primary text-white">
                <div class="card-body">
                    <h2 class="h4 mb-3">
                        <i class="fas fa-life-ring mr-2"></i>
                        Butuh Bantuan?
                    </h2>
                    <p class="mb-4">
                        Jika Anda masih mengalami kesulitan dalam setup integrasi Instagram, berikut beberapa sumber daya:
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="https://developers.facebook.com/docs/instagram-basic-display-api" target="_blank"
                            class="btn btn-light">
                            <i class="fas fa-book mr-2"></i>
                            Dokumentasi Instagram API
                        </a>
                        <a href="{{ route('admin.superadmin.instagram-settings') }}" class="btn btn-success">
                            <i class="fas fa-cog mr-2"></i>
                            Halaman Pengaturan
                        </a>
                        <a href="{{ route('public.instagram') }}" class="btn btn-warning">
                            <i class="fab fa-instagram mr-2"></i>
                            Lihat Feed
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
