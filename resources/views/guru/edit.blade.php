<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Data Guru') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('guru.show', $guru) }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Lihat Detail
                </a>
                <a href="{{ route('guru.index') }}"
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
                    <form method="POST" action="{{ route('guru.update', $guru) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Personal</h3>

                                <!-- NIP -->
                                <div>
                                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP
                                        *</label>
                                    <input type="text" name="nip" id="nip"
                                        value="{{ old('nip', $guru->nip) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nip') border-red-500 @enderror"
                                        required>
                                    @error('nip')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nama Lengkap -->
                                <div>
                                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                        Lengkap *</label>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap"
                                        value="{{ old('nama_lengkap', $guru->nama_lengkap) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_lengkap') border-red-500 @enderror"
                                        required>
                                    @error('nama_lengkap')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gelar -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="gelar_depan"
                                            class="block text-sm font-medium text-gray-700 mb-1">Gelar Depan</label>
                                        <input type="text" name="gelar_depan" id="gelar_depan"
                                            value="{{ old('gelar_depan', $guru->gelar_depan) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gelar_depan') border-red-500 @enderror">
                                        @error('gelar_depan')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="gelar_belakang"
                                            class="block text-sm font-medium text-gray-700 mb-1">Gelar Belakang</label>
                                        <input type="text" name="gelar_belakang" id="gelar_belakang"
                                            value="{{ old('gelar_belakang', $guru->gelar_belakang) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gelar_belakang') border-red-500 @enderror">
                                        @error('gelar_belakang')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin *</label>
                                    <div class="flex space-x-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="jenis_kelamin" value="L"
                                                {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">Laki-laki</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="jenis_kelamin" value="P"
                                                {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'checked' : '' }}
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
                                            value="{{ old('tanggal_lahir', $guru->tanggal_lahir->format('Y-m-d')) }}"
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
                                            value="{{ old('tempat_lahir', $guru->tempat_lahir) }}"
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
                                        required>{{ old('alamat', $guru->alamat) }}</textarea>
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
                                            value="{{ old('no_telepon', $guru->no_telepon) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_telepon') border-red-500 @enderror">
                                        @error('no_telepon')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="no_wa" class="block text-sm font-medium text-gray-700 mb-1">No.
                                            WhatsApp</label>
                                        <input type="text" name="no_wa" id="no_wa"
                                            value="{{ old('no_wa', $guru->no_wa) }}"
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
                                        value="{{ old('email', $guru->email) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Foto -->
                                <div>
                                    <label for="foto"
                                        class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                                    @if ($guru->foto)
                                        <div class="mb-2">
                                            <img src="{{ $guru->photo_url }}" alt="Current photo"
                                                class="h-20 w-20 rounded-full object-cover">
                                            <p class="text-sm text-gray-500 mt-1">Foto saat ini</p>
                                        </div>
                                    @endif
                                    <input type="file" name="foto" id="foto" accept="image/*"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('foto') border-red-500 @enderror">
                                    <p class="text-gray-500 text-xs mt-1">Max size: 2MB, Formats: JPEG, PNG, JPG, GIF
                                    </p>
                                    @error('foto')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Professional Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Profesional</h3>

                                <!-- Status Kepegawaian -->
                                <div>
                                    <label for="status_kepegawaian"
                                        class="block text-sm font-medium text-gray-700 mb-1">Status Kepegawaian
                                        *</label>
                                    <select name="status_kepegawaian" id="status_kepegawaian"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status_kepegawaian') border-red-500 @enderror"
                                        required>
                                        <option value="">Pilih Status</option>
                                        <option value="PNS"
                                            {{ old('status_kepegawaian', $guru->status_kepegawaian) == 'PNS' ? 'selected' : '' }}>
                                            PNS</option>
                                        <option value="CPNS"
                                            {{ old('status_kepegawaian', $guru->status_kepegawaian) == 'CPNS' ? 'selected' : '' }}>
                                            CPNS</option>
                                        <option value="GTT"
                                            {{ old('status_kepegawaian', $guru->status_kepegawaian) == 'GTT' ? 'selected' : '' }}>
                                            GTT</option>
                                        <option value="GTY"
                                            {{ old('status_kepegawaian', $guru->status_kepegawaian) == 'GTY' ? 'selected' : '' }}>
                                            GTY</option>
                                        <option value="Honorer"
                                            {{ old('status_kepegawaian', $guru->status_kepegawaian) == 'Honorer' ? 'selected' : '' }}>
                                            Honorer</option>
                                    </select>
                                    @error('status_kepegawaian')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jabatan -->
                                <div>
                                    <label for="jabatan"
                                        class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                    <input type="text" name="jabatan" id="jabatan"
                                        value="{{ old('jabatan', $guru->jabatan) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jabatan') border-red-500 @enderror">
                                    @error('jabatan')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Masuk -->
                                <div>
                                    <label for="tanggal_masuk"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk *</label>
                                    <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                                        value="{{ old('tanggal_masuk', $guru->tanggal_masuk->format('Y-m-d')) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_masuk') border-red-500 @enderror"
                                        required>
                                    @error('tanggal_masuk')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Keluar -->
                                <div>
                                    <label for="tanggal_keluar"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tanggal Keluar</label>
                                    <input type="date" name="tanggal_keluar" id="tanggal_keluar"
                                        value="{{ old('tanggal_keluar', $guru->tanggal_keluar?->format('Y-m-d')) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_keluar') border-red-500 @enderror">
                                    @error('tanggal_keluar')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status Aktif -->
                                <div>
                                    <label for="status_aktif"
                                        class="block text-sm font-medium text-gray-700 mb-1">Status Aktif *</label>
                                    <select name="status_aktif" id="status_aktif"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status_aktif') border-red-500 @enderror"
                                        required>
                                        <option value="">Pilih Status</option>
                                        <option value="aktif"
                                            {{ old('status_aktif', $guru->status_aktif) == 'aktif' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="tidak_aktif"
                                            {{ old('status_aktif', $guru->status_aktif) == 'tidak_aktif' ? 'selected' : '' }}>
                                            Tidak Aktif</option>
                                        <option value="pensiun"
                                            {{ old('status_aktif', $guru->status_aktif) == 'pensiun' ? 'selected' : '' }}>
                                            Pensiun</option>
                                        <option value="meninggal"
                                            {{ old('status_aktif', $guru->status_aktif) == 'meninggal' ? 'selected' : '' }}>
                                            Meninggal</option>
                                    </select>
                                    @error('status_aktif')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Pendidikan -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="pendidikan_terakhir"
                                            class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Terakhir
                                            *</label>
                                        <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir"
                                            value="{{ old('pendidikan_terakhir', $guru->pendidikan_terakhir) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pendidikan_terakhir') border-red-500 @enderror"
                                            required>
                                        @error('pendidikan_terakhir')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="tahun_lulus"
                                            class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus *</label>
                                        <input type="text" name="tahun_lulus" id="tahun_lulus"
                                            value="{{ old('tahun_lulus', $guru->tahun_lulus) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tahun_lulus') border-red-500 @enderror"
                                            required>
                                        @error('tahun_lulus')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Universitas -->
                                <div>
                                    <label for="universitas"
                                        class="block text-sm font-medium text-gray-700 mb-1">Universitas *</label>
                                    <input type="text" name="universitas" id="universitas"
                                        value="{{ old('universitas', $guru->universitas) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('universitas') border-red-500 @enderror"
                                        required>
                                    @error('universitas')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Sertifikasi -->
                                <div>
                                    <label for="sertifikasi"
                                        class="block text-sm font-medium text-gray-700 mb-1">Sertifikasi</label>
                                    <textarea name="sertifikasi" id="sertifikasi" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sertifikasi') border-red-500 @enderror">{{ old('sertifikasi', $guru->sertifikasi) }}</textarea>
                                    @error('sertifikasi')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mata Pelajaran -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran
                                        *</label>
                                    <div
                                        class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto border border-gray-300 rounded-md p-2">
                                        @foreach ($subjects as $subject)
                                            <label class="flex items-center">
                                                <input type="checkbox" name="mata_pelajaran[]"
                                                    value="{{ $subject }}"
                                                    {{ in_array($subject, old('mata_pelajaran', $guru->mata_pelajaran ?? [])) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">{{ $subject }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('mata_pelajaran')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Prestasi -->
                                <div>
                                    <label for="prestasi"
                                        class="block text-sm font-medium text-gray-700 mb-1">Prestasi</label>
                                    <textarea name="prestasi" id="prestasi" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('prestasi') border-red-500 @enderror">{{ old('prestasi', $guru->prestasi) }}</textarea>
                                    @error('prestasi')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Catatan -->
                                <div>
                                    <label for="catatan"
                                        class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                                    <textarea name="catatan" id="catatan" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('catatan') border-red-500 @enderror">{{ old('catatan', $guru->catatan) }}</textarea>
                                    @error('catatan')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- User Account -->
                                <div>
                                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">User
                                        Account</label>
                                    <select name="user_id" id="user_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror">
                                        <option value="">Pilih User Account (Opsional)</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id', $guru->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('guru.show', $guru) }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Data Guru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
