<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Data Calon OSIS</h1>
                <p class="text-slate-600 mt-1">Kelola data calon ketua dan wakil OSIS</p>
            </div>
            <a href="{{ route('osis.calon.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Calon
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filters -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Jenis Pencalonan</label>
                    <select name="jenis_pencalonan" class="form-input">
                        <option value="">Semua Jenis</option>
                        <option value="ketua" {{ request('jenis_pencalonan') === 'ketua' ? 'selected' : '' }}>Ketua
                        </option>
                        <option value="wakil" {{ request('jenis_pencalonan') === 'wakil' ? 'selected' : '' }}>Wakil
                        </option>
                        <option value="pasangan" {{ request('jenis_pencalonan') === 'pasangan' ? 'selected' : '' }}>
                            Pasangan</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama calon..."
                        class="form-input">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="btn btn-primary w-full">Filter</button>
                </div>
            </form>
        </div>

        <!-- Calon List -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Daftar Calon ({{ $calons->total() }})</h3>
            </div>

            <div class="divide-y divide-slate-200">
                @forelse($calons as $calon)
                    <div class="p-6 hover:bg-slate-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <span
                                        class="text-xl font-bold text-orange-600">#{{ $loop->iteration + ($calons->currentPage() - 1) * $calons->perPage() }}</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-slate-900">{{ $calon->full_candidate_name }}
                                    </h4>
                                    <p class="text-sm text-slate-600">{{ $calon->pencalonan_type_display }}</p>
                                    <div class="flex items-center space-x-4 mt-2">
                                        <span
                                            class="badge {{ $calon->is_active ? 'badge-success' : 'badge-warning' }}">
                                            {{ $calon->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                        <span class="text-sm text-slate-500">{{ $calon->votings_count }} suara</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('osis.calon.show', $calon) }}" class="btn btn-secondary text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat
                                </a>
                                <a href="{{ route('osis.calon.edit', $calon) }}" class="btn btn-secondary text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('osis.calon.destroy', $calon) }}" class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus calon ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <h3 class="text-lg font-medium text-slate-900 mb-2">Belum ada calon</h3>
                        <p class="text-slate-600 mb-4">Mulai dengan menambahkan calon OSIS pertama</p>
                        <a href="{{ route('osis.calon.create') }}" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Calon Pertama
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($calons->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $calons->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
