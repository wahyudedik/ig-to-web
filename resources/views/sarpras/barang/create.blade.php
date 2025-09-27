<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Barang Sarpras</h1>
                <p class="text-slate-600 mt-1">Tambah barang baru ke dalam sistem sarana dan prasarana</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('sarpras.barang.index') }}" class="btn btn-secondary">
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
            <form method="POST" action="{{ route('sarpras.barang.store') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <!-- Basic Information -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}"
                                class="form-input @error('nama_barang') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan nama barang" required>
                            @error('nama_barang')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kode_barang" class="form-label">Kode Barang</label>
                            <input type="text" id="kode_barang" name="kode_barang" value="{{ old('kode_barang') }}"
                                class="form-input @error('kode_barang') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan kode barang">
                            @error('kode_barang')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select id="kategori_id" name="kategori_id"
                                class="form-input @error('kategori_id') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori_list as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="ruang_id" class="form-label">Lokasi/Ruang</label>
                            <select id="ruang_id" name="ruang_id"
                                class="form-input @error('ruang_id') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                <option value="">Pilih Ruang</option>
                                @foreach ($ruang_list as $ruang)
                                    <option value="{{ $ruang->id }}"
                                        {{ old('ruang_id') == $ruang->id ? 'selected' : '' }}>
                                        {{ $ruang->nama_ruang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ruang_id')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Detail Barang</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kondisi" class="form-label">Kondisi</label>
                            <select id="kondisi" name="kondisi"
                                class="form-input @error('kondisi') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                required>
                                <option value="">Pilih Kondisi</option>
                                <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak_ringan" {{ old('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>
                                    Rusak Ringan</option>
                                <option value="rusak_berat" {{ old('kondisi') == 'rusak_berat' ? 'selected' : '' }}>
                                    Rusak Berat</option>
                            </select>
                            @error('kondisi')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <input type="number" id="harga" name="harga" value="{{ old('harga') }}"
                                class="form-input @error('harga') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan harga barang">
                            @error('harga')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tahun_pembelian" class="form-label">Tahun Pembelian</label>
                            <input type="number" id="tahun_pembelian" name="tahun_pembelian"
                                value="{{ old('tahun_pembelian') }}"
                                class="form-input @error('tahun_pembelian') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan tahun pembelian" min="1900" max="{{ date('Y') }}">
                            @error('tahun_pembelian')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="photo" class="form-label">Foto Barang</label>
                            <input type="file" id="photo" name="photo" accept="image/*"
                                class="form-input @error('photo') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('photo')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Deskripsi</h3>
                    <div>
                        <label for="deskripsi" class="form-label">Deskripsi Barang</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            class="form-input @error('deskripsi') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Masukkan deskripsi barang">{{ old('deskripsi') }}</textarea>
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
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                        <label for="is_active" class="ml-2 text-sm text-slate-700">Aktif</label>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('sarpras.barang.index') }}" class="btn btn-secondary">
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
                        Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
