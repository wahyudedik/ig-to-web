Fitur :
1. Modul Kegiatan = ambil dari data instagram sekolah mmenggunakan api dari meta
2. Modul Page = untuk membuat halaman/keterangan (Judul, isi halaman, gambar, kategori, waktu posting)
2. Modul Tenaga Pendidik, berisi:
   - Nama
   - Tempat, Tanggal Lahir (TTL)
   - Alamat
   - No. Telepon/WA
   - Mata Pelajaran (Mapel)
   - Foto
3. Modul Siswa Masih Aktif, berisi:
   - Nama Lengkap
   - Tempat, Tanggal Lahir (TTL)
   - Alamat
   - Tahun Masuk
   - Foto

   Ketika lulus, data tambahan:
   - Tahun Lulus
   - Kuliah/Kerja
   - Tempat Kuliah/Kerja
   - Jurusan/Jabatan
   - No. Hp/WA
4. Modul E-Osis :
   1. Data Calon
      - Menampilkan daftar calon ketua & wakil OSIS beserta detail:
        - Nama Ketua
        - Foto Ketua
        - Nama Wakil
        - Foto Wakil
        - Visi Misi
        - Jenis Pencalonan (misal: Ketua/Wakil, Pasangan, dll)
      - Fitur tambah/edit/hapus data calon.

   2. Monitor Hasil
      - Menampilkan hasil sementara dan akhir pemilihan:
        - Jumlah suara masing-masing calon/pasangan
        - Persentase perolehan suara
        - Grafik hasil voting (opsional)
      - Fitur refresh data hasil.

   3. Data Pemilih
      - Menampilkan daftar pemilih yang sudah dan belum memilih.
      - Data pemilih meliputi:
        - Nama
        - NIS/NISN
        - Kelas
        - Status (Sudah/Belum Memilih)
      - Fitur tambah/edit/hapus data pemilih.

   Tampilan tambah data:
   - Form input:
     - Nama Ketua (input text)
     - Foto Ketua (upload gambar)
     - Nama Wakil (input text)
     - Foto Wakil (upload gambar)
     - Visi Misi (textarea)
     - Jenis Pencalonan (dropdown/select)

   Tampilan Dashboard (contoh):
   - Statistik jumlah calon, jumlah pemilih, jumlah suara masuk
   - Grafik hasil voting (pie chart/bar chart)
   - List calon beserta perolehan suara
   - Tombol untuk tambah data calon & pemilih

   Berikut ini tampilannya (contoh wireframe sederhana):

   ```
   +------------------------------------------------------+
   | Dashboard E-Osis                                     |
   +-------------------+----------------------------------+
   | [Tambah Calon]    | Statistik:                      |
   | [Tambah Pemilih]  | - Jumlah Calon: 3               |
   |                   | - Jumlah Pemilih: 120           |
   |                   | - Suara Masuk: 100              |
   +-------------------+----------------------------------+
   | Calon OSIS:                                       V |
   | 1. Ketua: A, Wakil: B | Suara: 40 (40%)             |
   | 2. Ketua: C, Wakil: D | Suara: 35 (35%)             |
   | 3. Ketua: E, Wakil: F | Suara: 25 (25%)             |
   +------------------------------------------------------+
   | Grafik Hasil Voting (Pie/Bar Chart)                  |
   +------------------------------------------------------+
   ```
5. E-Lulus (Fitur Import Data Kelulusan)
   - Import data kelulusan siswa dengan kolom:
     - Nama
     - NISN
     - NIS
     - Jurusan
     - Tahun Ajaran
     - Status
   - Siswa dapat melakukan input NISN atau NIS pada form.
   - Setelah input, sistem akan menampilkan keterangan:
     ```
     Selamat Nama_Siswa!
     Kamu Dinyatakan LULUS!
     ```
6. Modul Sarpras (Sarana dan Prasarana)

   Master Data:
   - Kategori Sarpras
   - Nama Barang

   Prasarana:
   - Nama Ruang
   - Data Tanah
   - Data Bangunan

   Sarana:
   - Tambahan Sarana

   Untuk akses lebih detail, silakan kunjungi:
   https://www.maudu.aplikasimadrasah.com/admin

   Login:
   - Username: sarpras
   - Password: password