<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Calon OSIS</h1>
                <p class="text-slate-600 mt-1">Tambah data calon ketua dan wakil OSIS</p>
            </div>
            <a href="{{ route('osis.calon.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl border border-slate-200 p-8">
            <form method="POST" action="{{ route('osis.calon.store') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <!-- Jenis Pencalonan -->
                <div>
                    <label for="jenis_pencalonan" class="form-label">Jenis Pencalonan *</label>
                    <select name="jenis_pencalonan" id="jenis_pencalonan" required
                        class="form-input @error('jenis_pencalonan') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                        <option value="">Pilih Jenis Pencalonan</option>
                        <option value="ketua" {{ old('jenis_pencalonan') === 'ketua' ? 'selected' : '' }}>Ketua OSIS
                        </option>
                        <option value="wakil" {{ old('jenis_pencalonan') === 'wakil' ? 'selected' : '' }}>Wakil Ketua
                            OSIS</option>
                        <option value="pasangan" {{ old('jenis_pencalonan') === 'pasangan' ? 'selected' : '' }}>Pasangan
                            Ketua & Wakil</option>
                    </select>
                    @error('jenis_pencalonan')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" required
                        class="form-input @error('jenis_kelamin') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-slate-600 mt-1">Pilih jenis kelamin calon (untuk filter pemilihan berdasarkan
                        gender siswa)</p>
                </div>

                <!-- Ketua OSIS -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Data Ketua OSIS
                        </h3>

                        <div>
                            <label for="nama_ketua" class="form-label">Nama Ketua *</label>
                            <input type="text" name="nama_ketua" id="nama_ketua" value="{{ old('nama_ketua') }}"
                                required
                                class="form-input @error('nama_ketua') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan nama ketua">
                            @error('nama_ketua')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="foto_ketua" class="form-label">Foto Ketua</label>
                            <input type="file" name="foto_ketua" id="foto_ketua" accept="image/*"
                                class="form-input @error('foto_ketua') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('foto_ketua')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Data Wakil Ketua
                            OSIS</h3>

                        <div>
                            <label for="nama_wakil" class="form-label">Nama Wakil *</label>
                            <input type="text" name="nama_wakil" id="nama_wakil" value="{{ old('nama_wakil') }}"
                                required
                                class="form-input @error('nama_wakil') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan nama wakil">
                            @error('nama_wakil')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="foto_wakil" class="form-label">Foto Wakil</label>
                            <input type="file" name="foto_wakil" id="foto_wakil" accept="image/*"
                                class="form-input @error('foto_wakil') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('foto_wakil')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Visi Misi -->
                <div>
                    <label for="visi_misi" class="form-label">Visi & Misi *</label>
                    <textarea name="visi_misi" id="visi_misi" rows="6" required
                        class="form-input @error('visi_misi') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                        placeholder="Tuliskan visi dan misi calon OSIS">{{ old('visi_misi') }}</textarea>
                    @error('visi_misi')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active" class="form-label">Status</label>
                    <div class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                        <label for="is_active" class="ml-2 text-sm text-slate-700">Aktif dalam pemilihan</label>
                    </div>
                    @error('is_active')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('osis.calon.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Calon
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
