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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Data Management</h1>
                                <p class="text-gray-600 mt-2">Kelola data kelas, jurusan, ekstrakurikuler, dan mata
                                    pelajaran</p>
                            </div>
                            <a href="<?php echo e(route('admin.settings.index')); ?>"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-blue-600">Total Kelas</p>
                                    <p class="text-2xl font-bold text-blue-900"><?php echo e($kelasCount); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-green-600">Total Jurusan</p>
                                    <p class="text-2xl font-bold text-green-900"><?php echo e($jurusanCount); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-purple-600">Total Ekstrakurikuler</p>
                                    <p class="text-2xl font-bold text-purple-900"><?php echo e($ekstrakurikulerCount); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-orange-600">Total Mata Pelajaran</p>
                                    <p class="text-2xl font-bold text-orange-900"><?php echo e($mataPelajaranCount); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="mb-6">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8">
                                <button onclick="showTab('kelas')" id="tab-kelas"
                                    class="tab-button active py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                                    Kelas
                                </button>
                                <button onclick="showTab('jurusan')" id="tab-jurusan"
                                    class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Jurusan
                                </button>
                                <button onclick="showTab('ekstrakurikuler')" id="tab-ekstrakurikuler"
                                    class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Ekstrakurikuler
                                </button>
                                <button onclick="showTab('mata-pelajaran')" id="tab-mata-pelajaran"
                                    class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Mata Pelajaran
                                </button>
                            </nav>
                        </div>
                    </div>

                    <!-- Kelas Tab -->
                    <div id="content-kelas" class="tab-content">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">Data Kelas</h2>
                            <button onclick="openModal('kelas')"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>Tambah Kelas
                            </button>
                        </div>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul class="divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-medium text-gray-900"><?php echo e($item->nama); ?></h3>
                                                <?php if($item->deskripsi): ?>
                                                    <p class="text-sm text-gray-600 mt-1"><?php echo e($item->deskripsi); ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button
                                                    onclick="editItem('kelas', <?php echo e($item->id); ?>, '<?php echo e($item->nama); ?>', '<?php echo e($item->deskripsi); ?>')"
                                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                    <i class="fas fa-edit mr-1"></i>Edit
                                                </button>
                                                <button
                                                    onclick="deleteItem('kelas', <?php echo e($item->id); ?>, '<?php echo e($item->nama); ?>')"
                                                    class="text-red-600 hover:text-red-900 text-sm font-medium">
                                                    <i class="fas fa-trash mr-1"></i>Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data kelas
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Jurusan Tab -->
                    <div id="content-jurusan" class="tab-content hidden">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">Data Jurusan</h2>
                            <button onclick="openModal('jurusan')"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>Tambah Jurusan
                            </button>
                        </div>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul class="divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $jurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-medium text-gray-900"><?php echo e($item->nama); ?></h3>
                                                <?php if($item->deskripsi): ?>
                                                    <p class="text-sm text-gray-600 mt-1"><?php echo e($item->deskripsi); ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button
                                                    onclick="editItem('jurusan', <?php echo e($item->id); ?>, '<?php echo e($item->nama); ?>', '<?php echo e($item->deskripsi); ?>')"
                                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                    <i class="fas fa-edit mr-1"></i>Edit
                                                </button>
                                                <button
                                                    onclick="deleteItem('jurusan', <?php echo e($item->id); ?>, '<?php echo e($item->nama); ?>')"
                                                    class="text-red-600 hover:text-red-900 text-sm font-medium">
                                                    <i class="fas fa-trash mr-1"></i>Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data jurusan
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Ekstrakurikuler Tab -->
                    <div id="content-ekstrakurikuler" class="tab-content hidden">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">Data Ekstrakurikuler</h2>
                            <button onclick="openModal('ekstrakurikuler')"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>Tambah Ekstrakurikuler
                            </button>
                        </div>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul class="divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $ekstrakurikuler; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-medium text-gray-900"><?php echo e($item->nama); ?></h3>
                                                <?php if($item->deskripsi): ?>
                                                    <p class="text-sm text-gray-600 mt-1"><?php echo e($item->deskripsi); ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button
                                                    onclick="editItem('ekstrakurikuler', <?php echo e($item->id); ?>, '<?php echo e($item->nama); ?>', '<?php echo e($item->deskripsi); ?>')"
                                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                    <i class="fas fa-edit mr-1"></i>Edit
                                                </button>
                                                <button
                                                    onclick="deleteItem('ekstrakurikuler', <?php echo e($item->id); ?>, '<?php echo e($item->nama); ?>')"
                                                    class="text-red-600 hover:text-red-900 text-sm font-medium">
                                                    <i class="fas fa-trash mr-1"></i>Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data ekstrakurikuler
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Mata Pelajaran Tab -->
                    <div id="content-mata-pelajaran" class="tab-content hidden">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">Data Mata Pelajaran</h2>
                            <button onclick="openModal('mata-pelajaran')"
                                class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>Tambah Mata Pelajaran
                            </button>
                        </div>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul class="divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $mataPelajaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-medium text-gray-900"><?php echo e($item->nama); ?></h3>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button
                                                    onclick="editItem('mata-pelajaran', <?php echo e($item->id); ?>, '<?php echo e($item->nama); ?>', '')"
                                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                    <i class="fas fa-edit mr-1"></i>Edit
                                                </button>
                                                <button
                                                    onclick="deleteItem('mata-pelajaran', <?php echo e($item->id); ?>, '<?php echo e($item->nama); ?>')"
                                                    class="text-red-600 hover:text-red-900 text-sm font-medium">
                                                    <i class="fas fa-trash mr-1"></i>Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data mata pelajaran
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 id="modal-title" class="text-lg font-medium text-gray-900"></h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="modal-form">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                        <input type="text" id="modal-nama" name="nama" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div id="deskripsi-field" class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea id="modal-deskripsi" name="deskripsi" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" id="modal-submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <style>
        .tab-button.active {
            border-bottom-color: #3b82f6;
            color: #3b82f6;
        }
    </style>

    <script>
        let currentType = '';
        let currentId = null;

        // Tab functionality
        function showTab(type) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
                button.classList.add('border-transparent', 'text-gray-500');
                button.classList.remove('border-blue-500', 'text-blue-600');
            });

            // Show selected tab content
            document.getElementById('content-' + type).classList.remove('hidden');

            // Add active class to selected tab button
            const activeButton = document.getElementById('tab-' + type);
            activeButton.classList.add('active');
            activeButton.classList.remove('border-transparent', 'text-gray-500');
            activeButton.classList.add('border-blue-500', 'text-blue-600');
        }

        // Modal functionality
        function openModal(type, id = null, nama = '', deskripsi = '') {
            currentType = type;
            currentId = id;

            const modal = document.getElementById('modal');
            const title = document.getElementById('modal-title');
            const namaInput = document.getElementById('modal-nama');
            const deskripsiInput = document.getElementById('modal-deskripsi');
            const deskripsiField = document.getElementById('deskripsi-field');
            const submitButton = document.getElementById('modal-submit');

            // Set title
            const typeNames = {
                'kelas': 'Kelas',
                'jurusan': 'Jurusan',
                'ekstrakurikuler': 'Ekstrakurikuler',
                'mata-pelajaran': 'Mata Pelajaran'
            };

            title.textContent = id ? `Edit ${typeNames[type]}` : `Tambah ${typeNames[type]}`;

            // Set values
            namaInput.value = nama;
            deskripsiInput.value = deskripsi;

            // Show/hide deskripsi field
            if (type === 'mata-pelajaran') {
                deskripsiField.style.display = 'none';
            } else {
                deskripsiField.style.display = 'block';
            }

            // Set submit button text
            submitButton.textContent = id ? 'Update' : 'Simpan';

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            document.getElementById('modal-form').reset();
            currentType = '';
            currentId = null;
        }

        function editItem(type, id, nama, deskripsi) {
            openModal(type, id, nama, deskripsi);
        }

        function deleteItem(type, id, nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus ${nama}?`)) {
                const url = `<?php echo e(url('admin/settings/data-management')); ?>/${type}/${id}`;

                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus data');
                    });
            }
        }

        // Form submission
        document.getElementById('modal-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            let url = '';
            let method = '';

            if (currentId) {
                // Update
                url = `<?php echo e(url('admin/settings/data-management')); ?>/${currentType}/${currentId}`;
                method = 'PUT';
            } else {
                // Create
                url = `<?php echo e(url('admin/settings/data-management')); ?>/${currentType}`;
                method = 'POST';
            }

            fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        closeModal();
                        location.reload();
                    } else {
                        if (data.errors) {
                            let errorMessage = 'Validation errors:\n';
                            for (const [field, errors] of Object.entries(data.errors)) {
                                errorMessage += `${field}: ${errors.join(', ')}\n`;
                            }
                            alert(errorMessage);
                        } else {
                            alert(data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data');
                });
        });
    </script>
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
<?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/settings/data-management.blade.php ENDPATH**/ ?>