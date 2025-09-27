<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Calon OSIS</h1>
                <p class="text-slate-600 mt-1">{{ $calon->full_candidate_name }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('osis.calon.show', $calon) }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Detail
                </a>
                <a href="{{ route('osis.calon.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl border border-slate-200 p-8">
            <form method="POST" action="{{ route('osis.calon.update', $calon) }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Ketua Section -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Ketua</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_ketua" class="form-label">Nama Ketua</label>
                            <input type="text" id="nama_ketua" name="nama_ketua"
                                value="{{ old('nama_ketua', $calon->nama_ketua) }}"
                                class="form-input @error('nama_ketua') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan nama ketua">
                            @error('nama_ketua')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kelas_ketua" class="form-label">Kelas Ketua</label>
                            <input type="text" id="kelas_ketua" name="kelas_ketua"
                                value="{{ old('kelas_ketua', $calon->kelas_ketua) }}"
                                class="form-input @error('kelas_ketua') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan kelas ketua">
                            @error('kelas_ketua')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="ketua_photo" class="form-label">Foto Ketua</label>
                            <input type="file" id="ketua_photo" name="ketua_photo" accept="image/*"
                                class="form-input @error('ketua_photo') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('ketua_photo')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                            @if ($calon->ketua_photo_url)
                                <div class="mt-2">
                                    <img src="{{ $calon->ketua_photo_url }}" alt="Current photo"
                                        class="w-20 h-20 object-cover rounded-lg">
                                    <p class="text-xs text-slate-500 mt-1">Foto saat ini</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Wakil Section -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Wakil</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_wakil" class="form-label">Nama Wakil</label>
                            <input type="text" id="nama_wakil" name="nama_wakil"
                                value="{{ old('nama_wakil', $calon->nama_wakil) }}"
                                class="form-input @error('nama_wakil') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan nama wakil">
                            @error('nama_wakil')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kelas_wakil" class="form-label">Kelas Wakil</label>
                            <input type="text" id="kelas_wakil" name="kelas_wakil"
                                value="{{ old('kelas_wakil', $calon->kelas_wakil) }}"
                                class="form-input @error('kelas_wakil') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan kelas wakil">
                            @error('kelas_wakil')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="wakil_photo" class="form-label">Foto Wakil</label>
                            <input type="file" id="wakil_photo" name="wakil_photo" accept="image/*"
                                class="form-input @error('wakil_photo') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('wakil_photo')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                            @if ($calon->wakil_photo_url)
                                <div class="mt-2">
                                    <img src="{{ $calon->wakil_photo_url }}" alt="Current photo"
                                        class="w-20 h-20 object-cover rounded-lg">
                                    <p class="text-xs text-slate-500 mt-1">Foto saat ini</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Visi Misi Section -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Visi & Misi</h3>
                    <div>
                        <label for="visi_misi" class="form-label">Visi & Misi</label>
                        <textarea id="visi_misi" name="visi_misi" rows="8"
                            class="form-input @error('visi_misi') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Masukkan visi dan misi calon">{{ old('visi_misi', $calon->visi_misi) }}</textarea>
                        @error('visi_misi')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Settings Section -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Pengaturan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="pencalonan_type" class="form-label">Jenis Pencalonan</label>
                            <select id="pencalonan_type" name="pencalonan_type"
                                class="form-input @error('pencalonan_type') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                <option value="individu"
                                    {{ old('pencalonan_type', $calon->pencalonan_type) == 'individu' ? 'selected' : '' }}>
                                    Individu</option>
                                <option value="pasangan"
                                    {{ old('pencalonan_type', $calon->pencalonan_type) == 'pasangan' ? 'selected' : '' }}>
                                    Pasangan</option>
                            </select>
                            @error('pencalonan_type')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', $calon->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                            <label for="is_active" class="ml-2 text-sm text-slate-700">Aktif dalam pemilihan</label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('osis.calon.show', $calon) }}" class="btn btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
