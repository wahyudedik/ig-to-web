<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Kategori Sarpras</h1>
                <p class="text-slate-600 mt-1">{{ $kategori->nama_kategori }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('sarpras.kategori.show', $kategori) }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Detail
                </a>
                <a href="{{ route('sarpras.kategori.index') }}" class="btn btn-secondary">
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
            <form method="POST" action="{{ route('sarpras.kategori.update', $kategori) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kode_kategori" class="form-label">Kode Kategori</label>
                            <input type="text" id="kode_kategori" name="kode_kategori"
                                value="{{ old('kode_kategori', $kategori->kode_kategori) }}"
                                class="form-input @error('kode_kategori') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan kode kategori (contoh: ELEK)" required>
                            @error('kode_kategori')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" id="nama_kategori" name="nama_kategori"
                                value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                class="form-input @error('nama_kategori') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan nama kategori" required>
                            @error('nama_kategori')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Deskripsi</h3>
                    <div>
                        <label for="deskripsi" class="form-label">Deskripsi Kategori</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            class="form-input @error('deskripsi') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Masukkan deskripsi kategori">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Settings -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Pengaturan</h3>
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', $kategori->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                        <label for="is_active" class="ml-2 text-sm text-slate-700">Aktif</label>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('sarpras.kategori.show', $kategori) }}" class="btn btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
