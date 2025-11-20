<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Detail Sarana</h1>
                <p class="text-slate-600 mt-1"><?php echo e($sarana->kode_inventaris); ?></p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="<?php echo e(route('admin.sarpras.sarana.edit', $sarana)); ?>" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="<?php echo e(route('admin.sarpras.sarana.printInvoice', $sarana)); ?>" target="_blank" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Invoice
                </a>
                <a href="<?php echo e(route('admin.sarpras.sarana.index')); ?>" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Sarana Info -->
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-slate-900">Informasi Sarana</h3>
                        <span class="font-mono text-sm font-semibold text-blue-600">
                            <?php echo e($sarana->kode_inventaris); ?>

                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-slate-600 mb-2">Ruang</h4>
                            <p class="text-lg font-semibold text-slate-900"><?php echo e($sarana->ruang->nama_ruang ?? '-'); ?></p>
                            <p class="text-sm text-slate-500"><?php echo e($sarana->ruang->kode_ruang ?? ''); ?></p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-slate-600 mb-2">Tanggal</h4>
                            <p class="text-lg font-semibold text-slate-900"><?php echo e($sarana->formatted_tanggal); ?></p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-slate-600 mb-2">Sumber Dana</h4>
                            <p class="text-lg font-semibold text-slate-900"><?php echo e($sarana->sumber_dana ?? '-'); ?></p>
                            <?php if($sarana->kode_sumber_dana): ?>
                                <p class="text-sm text-slate-500"><?php echo e($sarana->kode_sumber_dana); ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-slate-600 mb-2">Total Jumlah</h4>
                            <p class="text-lg font-semibold text-slate-900"><?php echo e($sarana->total_jumlah); ?></p>
                        </div>
                    </div>

                    <?php if($sarana->catatan): ?>
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-slate-600 mb-2">Catatan</h4>
                            <p class="text-slate-900"><?php echo e($sarana->catatan); ?></p>
                        </div>
                    <?php endif; ?>
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
                                <?php
                                    $grandTotal = 0;
                                ?>
                                <?php $__currentLoopData = $sarana->barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $hargaBeli = $barang->harga_beli ?? 0;
                                        $jumlah = $barang->pivot->jumlah;
                                        $totalItem = $hargaBeli * $jumlah;
                                        $grandTotal += $totalItem;
                                    ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td>
                                            <p class="font-medium text-slate-900"><?php echo e($barang->nama_barang); ?></p>
                                        </td>
                                        <td>
                                            <span class="font-mono text-sm text-slate-600"><?php echo e($barang->kode_barang); ?></span>
                                        </td>
                                        <td>
                                            <?php if($barang->kategori): ?>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <?php echo e($barang->kategori->nama_kategori); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="text-slate-400">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="font-semibold text-slate-900"><?php echo e($jumlah); ?></span>
                                        </td>
                                        <td>
                                            <span class="text-slate-900">Rp <?php echo e(number_format($hargaBeli, 0, ',', '.')); ?></span>
                                        </td>
                                        <td>
                                            <span class="font-semibold text-slate-900">Rp <?php echo e(number_format($totalItem, 0, ',', '.')); ?></span>
                                        </td>
                                        <td>
                                            <?php
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
                                            ?>
                                            <span class="badge badge-<?php echo e($badgeColor); ?>"><?php echo e($kondisiText); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                                <tr class="bg-blue-50">
                                    <td colspan="6" class="text-right font-bold text-slate-900">Grand Total:</td>
                                    <td class="font-bold text-blue-600">Rp <?php echo e(number_format($grandTotal, 0, ',', '.')); ?></td>
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
                        <a href="<?php echo e(route('admin.sarpras.sarana.edit', $sarana)); ?>"
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

                        <a href="<?php echo e(route('admin.sarpras.sarana.printInvoice', $sarana)); ?>" target="_blank"
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
                            <span class="text-sm font-semibold text-slate-900"><?php echo e($sarana->barang->count()); ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Total Jumlah</span>
                            <span class="text-sm font-semibold text-slate-900"><?php echo e($sarana->total_jumlah); ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Dibuat</span>
                            <span class="text-sm text-slate-900"><?php echo e($sarana->created_at->format('d M Y')); ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Diperbarui</span>
                            <span class="text-sm text-slate-900"><?php echo e($sarana->updated_at->format('d M Y')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>

<?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/sarpras/sarana/show.blade.php ENDPATH**/ ?>