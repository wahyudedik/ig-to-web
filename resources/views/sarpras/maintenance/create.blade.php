<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Maintenance Sarpras</h1>
                <p class="text-slate-600 mt-1">Tambah data maintenance dan perawatan sarana prasarana</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('sarpras.maintenance.index') }}" class="btn btn-secondary">
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
            <form method="POST" action="{{ route('sarpras.maintenance.store') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <!-- Basic Information -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="jenis_maintenance" class="form-label">Jenis Maintenance</label>
                            <input type="text" id="jenis_maintenance" name="jenis_maintenance"
                                value="{{ old('jenis_maintenance') }}"
                                class="form-input @error('jenis_maintenance') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan jenis maintenance" required>
                            @error('jenis_maintenance')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_maintenance" class="form-label">Tanggal Maintenance</label>
                            <input type="date" id="tanggal_maintenance" name="tanggal_maintenance"
                                value="{{ old('tanggal_maintenance') }}"
                                class="form-input @error('tanggal_maintenance') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                required>
                            @error('tanggal_maintenance')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="item_type" class="form-label">Tipe Item</label>
                            <select id="item_type" name="item_type"
                                class="form-input @error('item_type') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                required>
                                <option value="">Pilih Tipe Item</option>
                                <option value="barang" {{ old('item_type') == 'barang' ? 'selected' : '' }}>Barang
                                </option>
                                <option value="ruang" {{ old('item_type') == 'ruang' ? 'selected' : '' }}>Ruang
                                </option>
                            </select>
                            @error('item_type')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="item_id" class="form-label">Item</label>
                            <select id="item_id" name="item_id"
                                class="form-input @error('item_id') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                required>
                                <option value="">Pilih Item</option>
                                <!-- Options will be populated by JavaScript based on item_type -->
                            </select>
                            @error('item_id')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="border-b border-slate-200 pb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Detail Maintenance</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status"
                                class="form-input @error('status') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                required>
                                <option value="">Pilih Status</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="dalam_proses" {{ old('status') == 'dalam_proses' ? 'selected' : '' }}>
                                    Dalam Proses</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                            </select>
                            @error('status')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="biaya" class="form-label">Biaya (Rp)</label>
                            <input type="number" id="biaya" name="biaya" value="{{ old('biaya') }}"
                                class="form-input @error('biaya') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan biaya maintenance" min="0">
                            @error('biaya')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="durasi" class="form-label">Durasi (jam)</label>
                            <input type="number" id="durasi" name="durasi" value="{{ old('durasi') }}"
                                class="form-input @error('durasi') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan durasi maintenance" min="0" step="0.5">
                            @error('durasi')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="photo" class="form-label">Foto Maintenance</label>
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
                        <label for="deskripsi" class="form-label">Deskripsi Maintenance</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            class="form-input @error('deskripsi') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Masukkan deskripsi maintenance">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('sarpras.maintenance.index') }}" class="btn btn-secondary">
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
                        Simpan Maintenance
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('item_type').addEventListener('change', function() {
            const itemType = this.value;
            const itemSelect = document.getElementById('item_id');

            // Clear existing options
            itemSelect.innerHTML = '<option value="">Pilih Item</option>';

            if (itemType === 'barang') {
                @foreach ($barang_list as $barang)
                    itemSelect.innerHTML +=
                        '<option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>';
                @endforeach
            } else if (itemType === 'ruang') {
                @foreach ($ruang_list as $ruang)
                    itemSelect.innerHTML +=
                        '<option value="{{ $ruang->id }}">{{ $ruang->nama_ruang }}</option>';
                @endforeach
            }
        });
    </script>
</x-app-layout>
