<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Data Siswa') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('siswa.show', $siswa) }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Lihat Detail
                </a>
                <a href="{{ route('siswa.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('siswa.update', $siswa) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Personal</h3>

                                <!-- NIS -->
                                <div>
                                    <label for="nis" class="block text-sm font-medium text-gray-700 mb-1">NIS
                                        *</label>
                                    <input type="text" name="nis" id="nis"
                                        value="{{ old('nis', $siswa->nis) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nis') border-red-500 @enderror"
                                        required>
                                    @error('nis')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- NISN -->
                                <div>
                                    <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN
                                        *</label>
                                    <input type="text" name="nisn" id="nisn"
                                        value="{{ old('nisn', $siswa->nisn) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nisn') border-red-500 @enderror"
                                        required>
                                    @error('nisn')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nama Lengkap -->
                                <div>
                                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                        Lengkap *</label>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap"
                                        value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_lengkap') border-red-500 @enderror"
                                        required>
                                    @error('nama_lengkap')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jenis Kelamin -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin *</label>
                                    <div class="flex space-x-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="jenis_kelamin" value="L"
                                                {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">Laki-laki</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="jenis_kelamin" value="P"
                                                {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">Perempuan</span>
                                        </label>
                                    </div>
                                    @error('jenis_kelamin')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal & Tempat Lahir -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="tanggal_lahir"
                                            class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir *</label>
                                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                            value="{{ old('tanggal_lahir', $siswa->tanggal_lahir->format('Y-m-d')) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_lahir') border-red-500 @enderror"
                                            required>
                                        @error('tanggal_lahir')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="tempat_lahir"
                                            class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir *</label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir"
                                            value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tempat_lahir') border-red-500 @enderror"
                                            required>
                                        @error('tempat_lahir')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div>
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                                        *</label>
                                    <textarea name="alamat" id="alamat" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @enderror"
                                        required>{{ old('alamat', $siswa->alamat) }}</textarea>
                                    @error('alamat')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kontak -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">No.
                                            Telepon</label>
                                        <input type="text" name="no_telepon" id="no_telepon"
                                            value="{{ old('no_telepon', $siswa->no_telepon) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_telepon') border-red-500 @enderror">
                                        @error('no_telepon')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="no_wa" class="block text-sm font-medium text-gray-700 mb-1">No.
                                            WhatsApp</label>
                                        <input type="text" name="no_wa" id="no_wa"
                                            value="{{ old('no_wa', $siswa->no_wa) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_wa') border-red-500 @enderror">
                                        @error('no_wa')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $siswa->email) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Current Photo -->
                                @if ($siswa->foto)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Saat
                                            Ini</label>
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ $siswa->photo_url }}" alt="{{ $siswa->nama_lengkap }}"
                                                class="w-20 h-20 object-cover rounded-lg">
                                            <div>
                                                <p class="text-sm text-gray-600">Foto saat ini</p>
                                                <label class="flex items-center mt-1">
                                                    <input type="checkbox" name="remove_photo" value="1"
                                                        class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                                    <span class="ml-2 text-sm text-red-600">Hapus foto</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- New Photo -->
                                <div>
                                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ $siswa->foto ? 'Ganti Foto' : 'Foto' }}
                                    </label>
                                    <input type="file" name="foto" id="foto" accept="image/*"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('foto') border-red-500 @enderror">
                                    <p class="text-gray-500 text-xs mt-1">Max size: 2MB, Formats: JPEG, PNG, JPG, GIF
                                    </p>
                                    @error('foto')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Academic Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Akademik</h3>

                                <!-- Kelas -->
                                <div>
                                    <label for="kelas"
                                        class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                                    <select name="kelas" id="kelas"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kelas') border-red-500 @enderror">
                                        <option value="">Pilih Kelas</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k }}"
                                                {{ old('kelas', $siswa->kelas) == $k ? 'selected' : '' }}>
                                                {{ $k }}</option>
                                        @endforeach
                                    </select>
                                    @error('kelas')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jurusan -->
                                <div>
                                    <label for="jurusan"
                                        class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                                    <select name="jurusan" id="jurusan"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jurusan') border-red-500 @enderror">
                                        <option value="">Pilih Jurusan</option>
                                        @foreach ($jurusan as $j)
                                            <option value="{{ $j }}"
                                                {{ old('jurusan', $siswa->jurusan) == $j ? 'selected' : '' }}>
                                                {{ $j }}</option>
                                        @endforeach
                                    </select>
                                    @error('jurusan')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tahun Masuk -->
                                <div>
                                    <label for="tahun_masuk"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tahun Masuk *</label>
                                    <input type="number" name="tahun_masuk" id="tahun_masuk"
                                        value="{{ old('tahun_masuk', $siswa->tahun_masuk) }}" min="2000"
                                        max="{{ date('Y') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tahun_masuk') border-red-500 @enderror"
                                        required>
                                    @error('tahun_masuk')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tahun Lulus -->
                                <div>
                                    <label for="tahun_lulus"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus</label>
                                    <input type="number" name="tahun_lulus" id="tahun_lulus"
                                        value="{{ old('tahun_lulus', $siswa->tahun_lulus) }}" min="2000"
                                        max="{{ date('Y') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tahun_lulus') border-red-500 @enderror">
                                    @error('tahun_lulus')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status
                                        *</label>
                                    <select name="status" id="status"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror"
                                        required>
                                        <option value="">Pilih Status</option>
                                        <option value="aktif"
                                            {{ old('status', $siswa->status) == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="lulus"
                                            {{ old('status', $siswa->status) == 'lulus' ? 'selected' : '' }}>Lulus
                                        </option>
                                        <option value="pindah"
                                            {{ old('status', $siswa->status) == 'pindah' ? 'selected' : '' }}>Pindah
                                        </option>
                                        <option value="keluar"
                                            {{ old('status', $siswa->status) == 'keluar' ? 'selected' : '' }}>Keluar
                                        </option>
                                        <option value="meninggal"
                                            {{ old('status', $siswa->status) == 'meninggal' ? 'selected' : '' }}>
                                            Meninggal</option>
                                    </select>
                                    @error('status')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Ekstrakurikuler -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ekstrakurikuler</label>
                                    <div
                                        class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto border border-gray-300 rounded-md p-2">
                                        @foreach ($ekstrakurikuler as $eks)
                                            <label class="flex items-center">
                                                <input type="checkbox" name="ekstrakurikuler[]"
                                                    value="{{ $eks }}"
                                                    {{ in_array($eks, old('ekstrakurikuler', $siswa->ekstrakurikuler ?? [])) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">{{ $eks }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('ekstrakurikuler')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Parent Information -->
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Orang Tua</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Ayah -->
                                <div class="space-y-4">
                                    <h4 class="text-md font-medium text-gray-800">Ayah</h4>
                                    <div>
                                        <label for="nama_ayah"
                                            class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                                        <input type="text" name="nama_ayah" id="nama_ayah"
                                            value="{{ old('nama_ayah', $siswa->nama_ayah) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_ayah') border-red-500 @enderror">
                                        @error('nama_ayah')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="pekerjaan_ayah"
                                            class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah</label>
                                        <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah"
                                            value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pekerjaan_ayah') border-red-500 @enderror">
                                        @error('pekerjaan_ayah')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Ibu -->
                                <div class="space-y-4">
                                    <h4 class="text-md font-medium text-gray-800">Ibu</h4>
                                    <div>
                                        <label for="nama_ibu"
                                            class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                                        <input type="text" name="nama_ibu" id="nama_ibu"
                                            value="{{ old('nama_ibu', $siswa->nama_ibu) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_ibu') border-red-500 @enderror">
                                        @error('nama_ibu')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="pekerjaan_ibu"
                                            class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu</label>
                                        <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu"
                                            value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pekerjaan_ibu') border-red-500 @enderror">
                                        @error('pekerjaan_ibu')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Kontak Orang Tua -->
                            <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-4">
                                <div>
                                    <label for="no_telepon_ortu"
                                        class="block text-sm font-medium text-gray-700 mb-1">No. Telepon Orang
                                        Tua</label>
                                    <input type="text" name="no_telepon_ortu" id="no_telepon_ortu"
                                        value="{{ old('no_telepon_ortu', $siswa->no_telepon_ortu) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_telepon_ortu') border-red-500 @enderror">
                                    @error('no_telepon_ortu')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="alamat_ortu"
                                        class="block text-sm font-medium text-gray-700 mb-1">Alamat Orang Tua</label>
                                    <textarea name="alamat_ortu" id="alamat_ortu" rows="2"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat_ortu') border-red-500 @enderror">{{ old('alamat_ortu', $siswa->alamat_ortu) }}</textarea>
                                    @error('alamat_ortu')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Prestasi -->
                                <div>
                                    <label for="prestasi"
                                        class="block text-sm font-medium text-gray-700 mb-1">Prestasi</label>
                                    <textarea name="prestasi" id="prestasi" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('prestasi') border-red-500 @enderror">{{ old('prestasi', $siswa->prestasi) }}</textarea>
                                    @error('prestasi')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Catatan -->
                                <div>
                                    <label for="catatan"
                                        class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                                    <textarea name="catatan" id="catatan" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('catatan') border-red-500 @enderror">{{ old('catatan', $siswa->catatan) }}</textarea>
                                    @error('catatan')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- User Account -->
                            <div class="mt-6">
                                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">User
                                    Account</label>
                                <select name="user_id" id="user_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror">
                                    <option value="">Pilih User Account (Opsional)</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id', $siswa->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('siswa.show', $siswa) }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Data Siswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
