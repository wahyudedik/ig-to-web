<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('common.tambah_data_guru') }}
            </h2>
            <a href="{{ route('admin.guru.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('common.back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.guru.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('common.personal_info') }}</h3>

                                <!-- NIP -->
                                <div>
                                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP
                                        *</label>
                                    <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nip') border-red-500 @else border-gray-300 @enderror"
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
                                        value="{{ old('nama_lengkap') }}"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_lengkap') border-red-500 @else border-gray-300 @enderror"
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
                                            value="{{ old('gelar_depan') }}"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gelar_depan') border-red-500 @else border-gray-300 @enderror">
                                        @error('gelar_depan')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="gelar_belakang"
                                            class="block text-sm font-medium text-gray-700 mb-1">Gelar Belakang</label>
                                        <input type="text" name="gelar_belakang" id="gelar_belakang"
                                            value="{{ old('gelar_belakang') }}"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gelar_belakang') border-red-500 @else border-gray-300 @enderror">
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
                                                {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">Laki-laki</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="jenis_kelamin" value="P"
                                                {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}
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
                                            value="{{ old('tanggal_lahir') }}"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_lahir') border-red-500 @else border-gray-300 @enderror"
                                            required>
                                        @error('tanggal_lahir')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="tempat_lahir"
                                            class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir *</label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir"
                                            value="{{ old('tempat_lahir') }}"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tempat_lahir') border-red-500 @else border-gray-300 @enderror"
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
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @else border-gray-300 @enderror"
                                        required>{{ old('alamat') }}</textarea>
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
                                            value="{{ old('no_telepon') }}"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_telepon') border-red-500 @else border-gray-300 @enderror">
                                        @error('no_telepon')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="no_wa" class="block text-sm font-medium text-gray-700 mb-1">No.
                                            WhatsApp</label>
                                        <input type="text" name="no_wa" id="no_wa"
                                            value="{{ old('no_wa') }}"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_wa') border-red-500 @else border-gray-300 @enderror">
                                        @error('no_wa')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @else border-gray-300 @enderror">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Foto -->
                                <div>
                                    <label for="foto"
                                        class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                                    <input type="file" name="foto" id="foto" accept="image/*"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('foto') border-red-500 @else border-gray-300 @enderror">
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
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status_kepegawaian') border-red-500 @else border-gray-300 @enderror"
                                        required>
                                        <option value="">Pilih Status</option>
                                        <option value="PNS"
                                            {{ old('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                        <option value="CPNS"
                                            {{ old('status_kepegawaian') == 'CPNS' ? 'selected' : '' }}>CPNS</option>
                                        <option value="GTT"
                                            {{ old('status_kepegawaian') == 'GTT' ? 'selected' : '' }}>GTT</option>
                                        <option value="GTY"
                                            {{ old('status_kepegawaian') == 'GTY' ? 'selected' : '' }}>GTY</option>
                                        <option value="Honorer"
                                            {{ old('status_kepegawaian') == 'Honorer' ? 'selected' : '' }}>Honorer
                                        </option>
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
                                        value="{{ old('jabatan') }}"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jabatan') border-red-500 @else border-gray-300 @enderror">
                                    @error('jabatan')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Masuk -->
                                <div>
                                    <label for="tanggal_masuk"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk *</label>
                                    <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                                        value="{{ old('tanggal_masuk') }}"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_masuk') border-red-500 @else border-gray-300 @enderror"
                                        required>
                                    @error('tanggal_mahir')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tanggal Keluar -->
                                <div>
                                    <label for="tanggal_keluar"
                                        class="block text-sm font-medium text-gray-700 mb-1">Tanggal Keluar</label>
                                    <input type="date" name="tanggal_keluar" id="tanggal_keluar"
                                        value="{{ old('tanggal_keluar') }}"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_keluar') border-red-500 @else border-gray-300 @enderror">
                                    @error('tanggal_keluar')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status Aktif -->
                                <div>
                                    <label for="status_aktif"
                                        class="block text-sm font-medium text-gray-700 mb-1">Status Aktif *</label>
                                    <select name="status_aktif" id="status_aktif"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status_aktif') border-red-500 @else border-gray-300 @enderror"
                                        required>
                                        <option value="">Pilih Status</option>
                                        <option value="aktif" {{ old('status_aktif') == 'aktif' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="tidak_aktif"
                                            {{ old('status_aktif') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif
                                        </option>
                                        <option value="pensiun"
                                            {{ old('status_aktif') == 'pensiun' ? 'selected' : '' }}>Pensiun</option>
                                        <option value="meninggal"
                                            {{ old('status_aktif') == 'meninggal' ? 'selected' : '' }}>Meninggal
                                        </option>
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
                                            value="{{ old('pendidikan_terakhir') }}"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pendidikan_terakhir') border-red-500 @else border-gray-300 @enderror"
                                            required>
                                        @error('pendidikan_terakhir')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="tahun_lulus"
                                            class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus *</label>
                                        <input type="text" name="tahun_lulus" id="tahun_lulus"
                                            value="{{ old('tahun_lulus') }}" inputmode="numeric" pattern="[0-9]{4}"
                                            maxlength="4" minlength="4"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tahun_lulus') border-red-500 @else border-gray-300 @enderror"
                                            placeholder="YYYY" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);">
                                        <small class="text-gray-500">Hanya tahun, contoh: 2023</small>
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
                                        value="{{ old('universitas') }}"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('universitas') border-red-500 @else border-gray-300 @enderror"
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
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sertifikasi') border-red-500 @else border-gray-300 @enderror">{{ old('sertifikasi') }}</textarea>
                                    @error('sertifikasi')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mata Pelajaran -->
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-sm font-medium text-gray-700">Mata Pelajaran *</label>
                                        <button type="button" onclick="openMataPelajaranModal()"
                                            class="px-3 py-1 bg-green-500 text-white text-sm rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Tambah
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto border rounded-md p-2">
                                        @if (count($subjects) > 0)
                                            @foreach ($subjects as $subject)
                                                <label class="flex items-center">
                                                    <input type="checkbox" name="mata_pelajaran[]"
                                                        value="{{ $subject }}"
                                                        {{ in_array($subject, old('mata_pelajaran', [])) ? 'checked' : '' }}
                                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                    <span
                                                        class="ml-2 text-sm text-gray-700">{{ $subject }}</span>
                                                </label>
                                            @endforeach
                                        @else
                                            <div class="col-span-2 text-center text-gray-500 py-4">
                                                Tidak ada mata pelajaran tersedia
                                            </div>
                                        @endif
                                    </div>
                                    @error('mata_pelajaran')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Pilih mata pelajaran yang diajarkan oleh guru
                                    </p>
                                </div>

                                <!-- Prestasi -->
                                <div>
                                    <label for="prestasi"
                                        class="block text-sm font-medium text-gray-700 mb-1">Prestasi</label>
                                    <textarea name="prestasi" id="prestasi" rows="3"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('prestasi') border-red-500 @else border-gray-300 @enderror">{{ old('prestasi') }}</textarea>
                                    @error('prestasi')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Catatan -->
                                <div>
                                    <label for="catatan"
                                        class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                                    <textarea name="catatan" id="catatan" rows="3"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('catatan') border-red-500 @else border-gray-300 @enderror">{{ old('catatan') }}</textarea>
                                    @error('catatan')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- User Account -->
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label for="user_id" class="block text-sm font-medium text-gray-700">User
                                            Account</label>
                                        <button type="button" onclick="openUserModal()"
                                            class="px-3 py-1 bg-green-500 text-white text-sm rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Tambah
                                        </button>
                                    </div>
                                    <select name="user_id" id="user_id"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @else border-gray-300 @enderror">
                                        <option value="">Pilih User Account (Opsional)</option>
                                        @if ($users->count() > 0)
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="" disabled>Tidak ada user tersedia</option>
                                        @endif
                                    </select>
                                    @error('user_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Hanya menampilkan user yang belum digunakan oleh guru lain
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('admin.guru.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Data Guru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Mata Pelajaran -->
    <div id="mataPelajaranModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Kelola Mata Pelajaran</h3>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tambah Mata Pelajaran Baru</label>
                        <div class="space-y-3">
                            <input type="text" id="newMataPelajaran" placeholder="Nama mata pelajaran"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button onclick="addMataPelajaran()"
                                class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Tambah Mata Pelajaran
                            </button>
                        </div>
                    </div>
                    <div class="border-t pt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Daftar Mata Pelajaran</h4>
                        <div id="mataPelajaranList" class="space-y-2 max-h-40 overflow-y-auto">
                            <!-- List will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <button onclick="closeMataPelajaranModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal User Account -->
    <div id="userModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Kelola User Account</h3>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tambah User Baru</label>
                        <div class="space-y-3">
                            <input type="text" id="newUserName" placeholder="Nama lengkap"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="email" id="newUserEmail" placeholder="Email"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="password" id="newUserPassword" placeholder="Password"
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button onclick="addUser()"
                                class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Tambah User
                            </button>
                        </div>
                    </div>
                    <div class="border-t pt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Daftar User</h4>
                        <div id="userList" class="space-y-2 max-h-40 overflow-y-auto">
                            <!-- List will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <button onclick="closeUserModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mata Pelajaran Functions
        function openMataPelajaranModal() {
            document.getElementById('mataPelajaranModal').classList.remove('hidden');
            loadMataPelajaranList();
        }

        function closeMataPelajaranModal() {
            document.getElementById('mataPelajaranModal').classList.add('hidden');
        }

        function addMataPelajaran() {
            const newMataPelajaran = document.getElementById('newMataPelajaran').value;

            if (!newMataPelajaran.trim()) {
                showError('Nama mata pelajaran harus diisi');
                return;
            }

            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Loading...';
            button.disabled = true;

            fetch('{{ route('admin.guru.addSubject') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        nama: newMataPelajaran
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw err;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Add to checkbox list
                        const container = document.querySelector('.grid.grid-cols-2.gap-2');
                        const label = document.createElement('label');
                        label.className = 'flex items-center';
                        label.innerHTML = `
                            <input type="checkbox" name="mata_pelajaran[]" value="${data.data.nama}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">${data.data.nama}</span>
                        `;
                        container.appendChild(label);

                        // Update list in modal
                        loadMataPelajaranList();

                        document.getElementById('newMataPelajaran').value = '';
                        showSuccess('Mata pelajaran berhasil ditambahkan!');
                    } else {
                        showError(data.message || 'Terjadi kesalahan saat menambahkan mata pelajaran');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    // Handle validation errors
                    if (error.errors) {
                        let errorMessages = [];
                        for (let field in error.errors) {
                            errorMessages.push(...error.errors[field]);
                        }
                        showError(errorMessages.join('<br>'));
                    } else if (error.message) {
                        showError(error.message);
                    } else {
                        showError('Terjadi kesalahan saat menambahkan mata pelajaran');
                    }
                })
                .finally(() => {
                    button.textContent = originalText;
                    button.disabled = false;
                });
        }

        function loadMataPelajaranList() {
            // This would typically fetch from an API endpoint
            // For now, we'll just show a placeholder
            document.getElementById('mataPelajaranList').innerHTML = '<p class="text-gray-500 text-sm">Loading...</p>';
        }

        // User Functions
        function openUserModal() {
            document.getElementById('userModal').classList.remove('hidden');
            loadUserList();
        }

        function closeUserModal() {
            document.getElementById('userModal').classList.add('hidden');
        }

        function addUser() {
            const name = document.getElementById('newUserName').value;
            const email = document.getElementById('newUserEmail').value;
            const password = document.getElementById('newUserPassword').value;
            // Validation
            if (!name.trim()) {
                showError('Nama lengkap harus diisi');
                return;
            }
            if (!email.trim()) {
                showError('Email harus diisi');
                return;
            }
            if (!password.trim()) {
                showError('Password harus diisi');
                return;
            }
            if (password.length < 8) {
                showError('Password minimal 8 karakter');
                return;
            }

            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Loading...';
            button.disabled = true;

            fetch('{{ route('admin.superadmin.users.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        name: name,
                        email: email,
                        password: password,
                        roles: ['guru'] // Use role instead of user_type
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw err;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Add to select dropdown
                        const select = document.getElementById('user_id');
                        const option = document.createElement('option');
                        option.value = data.data.id;
                        option.textContent = `${data.data.name} (${data.data.email})`;
                        select.appendChild(option);

                        // Update list in modal
                        loadUserList();

                        // Clear form
                        document.getElementById('newUserName').value = '';
                        document.getElementById('newUserEmail').value = '';
                        document.getElementById('newUserPassword').value = '';

                        showSuccess('User berhasil ditambahkan!');
                    } else {
                        showError(data.message || 'Terjadi kesalahan saat menambahkan user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    // Handle validation errors
                    if (error.errors) {
                        let errorMessages = [];
                        for (let field in error.errors) {
                            errorMessages.push(...error.errors[field]);
                        }
                        showError(errorMessages.join('<br>'));
                    } else if (error.message) {
                        showError(error.message);
                    } else {
                        showError('Terjadi kesalahan saat menambahkan user');
                    }
                })
                .finally(() => {
                    button.textContent = originalText;
                    button.disabled = false;
                });
        }

        function loadUserList() {
            // This would typically fetch from an API endpoint
            // For now, we'll just show a placeholder
            document.getElementById('userList').innerHTML = '<p class="text-gray-500 text-sm">Loading...</p>';
        }
    </script>
</x-app-layout>
