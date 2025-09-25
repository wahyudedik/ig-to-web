<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Website Sekolah - Portal Digital Pendidikan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Include the existing Tailwind CSS here */
            /* ... existing styles ... */
        </style>
    @endif

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .feature-card {
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                            Website Sekolah
                        </h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="">Home</a>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="">Halaman</a>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="">Galeri</a>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="{{ route('instagram.activities') }}">Kegiatan</a>
                    <div class="relative group">
                        <button
                            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center focus:outline-none">
                            Modul
                            <svg class="ml-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.085l3.71-3.855a.75.75 0 1 1 1.08 1.04l-4.24 4.4a.75.75 0 0 1-1.08 0l-4.24-4.4a.75.75 0 0 1 .02-1.06z" />
                            </svg>
                        </button>
                        <div
                            class="absolute left-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-md shadow-lg opacity-0 group-hover:opacity-100 group-focus:opacity-100 transition-opacity duration-200 z-50">
                            <a class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 text-sm font-medium transition duration-300"
                                href="">E-Lulus</a>
                            <a class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 text-sm font-medium transition duration-300"
                                href="">E-OSIS</a>
                            <a class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 text-sm font-medium transition duration-300"
                                href="">Sarpras</a>
                        </div>
                    </div>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="">Tenaga Pendidik</a>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="">Data Siswa</a>
                    <a class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300"
                        href="">Kontak</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium transition duration-300">
                                Login
                            </a>
                            {{-- @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                                    Register
                                </a>
                            @endif --}}
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section flex items-center justify-center text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-6">
                Portal Digital Pendidikan
            </h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">
                Mengintegrasikan semua layanan sekolah dalam satu platform digital yang modern
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#features"
                    class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Jelajahi Fitur
                </a>
                <a href="#contact"
                    class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Fitur Unggulan
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    Semua layanan sekolah dalam satu platform yang terintegrasi
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Modul Kegiatan -->
                <div
                    class="feature-card bg-white dark:bg-gray-700 rounded-xl shadow-lg p-8 border border-gray-200 dark:border-gray-600">
                    <div
                        class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-calendar-alt text-2xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Modul Kegiatan</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Integrasi dengan Instagram sekolah untuk menampilkan kegiatan dan aktivitas terbaru
                    </p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Update otomatis dari Instagram</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Galeri kegiatan sekolah</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Timeline aktivitas</li>
                    </ul>
                </div>

                <!-- Modul Page -->
                <div
                    class="feature-card bg-white dark:bg-gray-700 rounded-xl shadow-lg p-8 border border-gray-200 dark:border-gray-600">
                    <div
                        class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-file-alt text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Modul Page</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Sistem manajemen konten untuk membuat halaman informasi sekolah
                    </p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Editor konten WYSIWYG</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Kategori dan tag</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Upload gambar</li>
                    </ul>
                </div>

                <!-- Modul Tenaga Pendidik -->
                <div
                    class="feature-card bg-white dark:bg-gray-700 rounded-xl shadow-lg p-8 border border-gray-200 dark:border-gray-600">
                    <div
                        class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-chalkboard-teacher text-2xl text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Tenaga Pendidik</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Database lengkap informasi guru dan tenaga kependidikan
                    </p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Profil lengkap guru</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Mata pelajaran</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Kontak informasi</li>
                    </ul>
                </div>

                <!-- Modul Siswa -->
                <div
                    class="feature-card bg-white dark:bg-gray-700 rounded-xl shadow-lg p-8 border border-gray-200 dark:border-gray-600">
                    <div
                        class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-user-graduate text-2xl text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Data Siswa</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Manajemen data siswa aktif dan alumni dengan informasi lengkap
                    </p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Data siswa aktif</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Informasi alumni</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Tracking kelulusan</li>
                    </ul>
                </div>

                <!-- E-OSIS -->
                <div
                    class="feature-card bg-white dark:bg-gray-700 rounded-xl shadow-lg p-8 border border-gray-200 dark:border-gray-600">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-vote-yea text-2xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">E-OSIS</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Sistem pemilihan OSIS digital dengan monitoring real-time
                    </p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Pemilihan online</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Monitoring hasil</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Dashboard admin</li>
                    </ul>
                </div>

                <!-- E-Lulus -->
                <div
                    class="feature-card bg-white dark:bg-gray-700 rounded-xl shadow-lg p-8 border border-gray-200 dark:border-gray-600">
                    <div
                        class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-certificate text-2xl text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">E-Lulus</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Sistem pengumuman kelulusan dengan verifikasi NISN/NIS
                    </p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Verifikasi otomatis</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Import data kelulusan</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Pengumuman real-time</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Features Section -->
    <section class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Detail Fitur
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    Penjelasan lengkap setiap modul dan fungsionalitas
                </p>
            </div>

            <!-- E-OSIS Detail -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-vote-yea text-xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">E-OSIS - Sistem Pemilihan Digital</h3>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Data Calon</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Nama Ketua & Wakil</li>
                            <li>• Foto Calon</li>
                            <li>• Visi Misi</li>
                            <li>• Jenis Pencalonan</li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Monitor Hasil</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Jumlah suara real-time</li>
                            <li>• Persentase perolehan</li>
                            <li>• Grafik hasil voting</li>
                            <li>• Dashboard statistik</li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Data Pemilih</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Daftar pemilih</li>
                            <li>• Status voting</li>
                            <li>• NIS/NISN</li>
                            <li>• Kelas</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- E-Lulus Detail -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8">
                <div class="flex items-center mb-6">
                    <div
                        class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-certificate text-xl text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">E-Lulus - Sistem Pengumuman Kelulusan
                    </h3>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Fitur Import Data</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Import data kelulusan Excel/CSV</li>
                            <li>• Kolom: Nama, NISN, NIS, Jurusan</li>
                            <li>• Tahun Ajaran & Status</li>
                            <li>• Validasi data otomatis</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Verifikasi Siswa</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Input NISN atau NIS</li>
                            <li>• Pengumuman kelulusan</li>
                            <li>• Tampilan hasil real-time</li>
                            <li>• Keamanan data</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Sarpras Detail -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                <div class="flex items-center mb-6">
                    <div
                        class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-building text-xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Sarpras - Sarana & Prasarana</h3>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Master Data</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Kategori Sarpras</li>
                            <li>• Nama Barang</li>
                            <li>• Kode Inventaris</li>
                            <li>• Klasifikasi</li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Prasarana</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Data Ruang</li>
                            <li>• Data Tanah</li>
                            <li>• Data Bangunan</li>
                            <li>• Kondisi & Status</li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Sarana</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                            <li>• Inventaris Barang</li>
                            <li>• Maintenance</li>
                            <li>• Laporan</li>
                            <li>• Monitoring</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section class="py-20 bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6">Lihat Demo Sistem</h2>
            <p class="text-xl mb-8 opacity-90">
                Akses demo lengkap untuk melihat semua fitur dalam aksi
            </p>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 max-w-2xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Demo Sarpras</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    Login ke sistem demo untuk melihat fitur Sarana & Prasarana
                </p>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        <strong>URL:</strong> https://www.maudu.aplikasimadrasah.com/admin
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        <strong>Username:</strong> sarpras
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        <strong>Password:</strong> password
                    </p>
                </div>
                <a href="https://www.maudu.aplikasimadrasah.com/admin" target="_blank"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-300">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Akses Demo
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Hubungi Kami
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">
                    Ingin mengimplementasikan sistem ini di sekolah Anda?
                </p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                        Informasi Kontak
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-blue-600 text-xl mr-4"></i>
                            <span class="text-gray-600 dark:text-gray-300">info@sekolahdigital.com</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-blue-600 text-xl mr-4"></i>
                            <span class="text-gray-600 dark:text-gray-300">+62 123 456 789</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-blue-600 text-xl mr-4"></i>
                            <span class="text-gray-600 dark:text-gray-300">Jl. Pendidikan No. 123, Jakarta</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                        Kirim Pesan
                    </h3>
                    <form class="space-y-4">
                        <div>
                            <input type="text" placeholder="Nama Lengkap"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <input type="email" placeholder="Email"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <textarea rows="4" placeholder="Pesan"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"></textarea>
                        </div>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-300">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Website Sekolah</h3>
                    <p class="text-gray-400">
                        Portal digital pendidikan terintegrasi untuk sekolah modern
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Fitur Utama</h4>
                    <ul class="text-gray-400 space-y-2">
                        <li>Modul Kegiatan</li>
                        <li>E-OSIS</li>
                        <li>E-Lulus</li>
                        <li>Sarpras</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Layanan</h4>
                    <ul class="text-gray-400 space-y-2">
                        <li>Implementasi</li>
                        <li>Training</li>
                        <li>Support</li>
                        <li>Maintenance</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Sosial Media</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Website Sekolah. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Smooth Scroll Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
