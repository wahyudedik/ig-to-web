<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Detail Sarana</h1>
                <p class="text-slate-600 mt-1">{{ $sarana->kode_inventaris }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.sarpras.sarana.edit', $sarana) }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.sarpras.sarana.printInvoice', $sarana) }}" target="_blank" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Invoice
                </a>
                <a href="{{ route('admin.sarpras.sarana.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Sarana Info -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-slate-900">Informasi Sarana</h3>
                        <span class="font-mono text-sm font-semibold text-blue-600">
                            {{ $sarana->kode_inventaris }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-slate-600 mb-2">Ruang</h4>
                            <p class="text-lg font-semibold text-slate-900">{{ $sarana->ruang->nama_ruang ?? '-' }}</p>
                            <p class="text-sm text-slate-500">{{ $sarana->ruang->kode_ruang ?? '' }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-slate-600 mb-2">Tanggal</h4>
                            <p class="text-lg font-semibold text-slate-900">{{ $sarana->formatted_tanggal }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-slate-600 mb-2">Sumber Dana</h4>
                            <p class="text-lg font-semibold text-slate-900">{{ $sarana->sumber_dana ?? '-' }}</p>
                            @if ($sarana->kode_sumber_dana)
                                <p class="text-sm text-slate-500">{{ $sarana->kode_sumber_dana }}</p>
                            @endif
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-slate-600 mb-2">Total Jumlah</h4>
                            <p class="text-lg font-semibold text-slate-900">{{ $sarana->total_jumlah }}</p>
                        </div>
                    </div>

                    @if ($sarana->catatan)
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-slate-600 mb-2">Catatan</h4>
                            <p class="text-slate-900">{{ $sarana->catatan }}</p>
                        </div>
                    @endif
                </div>

                <!-- Barang List -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Daftar Barang</h3>
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Kode Barang</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                    <th>Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grandTotal = 0;
                                @endphp
                                @foreach ($sarana->barang as $index => $barang)
                                    @php
                                        $hargaBeli = $barang->harga_beli ?? 0;
                                        $jumlah = $barang->pivot->jumlah;
                                        $totalItem = $hargaBeli * $jumlah;
                                        $grandTotal += $totalItem;
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <p class="font-medium text-slate-900">{{ $barang->nama_barang }}</p>
                                        </td>
                                        <td>
                                            <span class="font-mono text-sm text-slate-600">{{ $barang->kode_barang }}</span>
                                        </td>
                                        <td>
                                            @if ($barang->kategori)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $barang->kategori->nama_kategori }}
                                                </span>
                                            @else
                                                <span class="text-slate-400">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="font-semibold text-slate-900">{{ $jumlah }}</span>
                                        </td>
                                        <td>
                                            <span class="text-slate-900">Rp {{ number_format($hargaBeli, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            <span class="font-semibold text-slate-900">Rp {{ number_format($totalItem, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $badgeColor = match ($barang->pivot->kondisi) {
                                                    'baik' => 'green',
                                                    'rusak' => 'red',
                                                    'hilang' => 'gray',
                                                    default => 'gray',
                                                };
                                                $kondisiText = match ($barang->pivot->kondisi) {
                                                    'baik' => 'Baik',
                                                    'rusak' => 'Rusak',
                                                    'hilang' => 'Hilang',
                                                    default => 'Tidak Diketahui',
                                                };
                                            @endphp
                                            <span class="badge badge-{{ $badgeColor }}">{{ $kondisiText }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-blue-50">
                                    <td colspan="6" class="text-right font-bold text-slate-900">Grand Total:</td>
                                    <td class="font-bold text-blue-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.sarpras.sarana.edit', $sarana) }}"
                            class="flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <span class="font-medium text-slate-900">Edit Sarana</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('admin.sarpras.sarana.printInvoice', $sarana) }}" target="_blank"
                            class="flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                </div>
                                <span class="font-medium text-slate-900">Cetak Invoice</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Statistik</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Total Barang</span>
                            <span class="text-sm font-semibold text-slate-900">{{ $sarana->barang->count() }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Total Jumlah</span>
                            <span class="text-sm font-semibold text-slate-900">{{ $sarana->total_jumlah }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Dibuat</span>
                            <span class="text-sm text-slate-900">{{ $sarana->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Diperbarui</span>
                            <span class="text-sm text-slate-900">{{ $sarana->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

