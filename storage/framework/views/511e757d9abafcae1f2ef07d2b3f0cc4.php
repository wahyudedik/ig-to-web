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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Manage Testimonials')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            <?php if(session('success')): ?>
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <!-- Error Message -->
            <?php if(session('error')): ?>
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-comments text-2xl text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Testimonials</p>
                                <p class="text-2xl font-semibold text-gray-900"><?php echo e($testimonials->total()); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-2xl text-green-600"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Approved</p>
                                <p class="text-2xl font-semibold text-gray-900"><?php echo e($testimonials->where('is_approved', true)->count()); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-star text-2xl text-yellow-600"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Featured</p>
                                <p class="text-2xl font-semibold text-gray-900"><?php echo e($testimonials->where('is_featured', true)->count()); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock text-2xl text-orange-600"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Pending</p>
                                <p class="text-2xl font-semibold text-gray-900"><?php echo e($testimonials->where('is_approved', false)->count()); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="flex flex-wrap gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="rounded-md border-gray-300">
                                <option value="">All</option>
                                <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Approved</option>
                                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="featured" <?php echo e(request('status') == 'featured' ? 'selected' : ''); ?>>Featured</option>
                            </select>
                        </div>
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                            <select name="position" id="position" class="rounded-md border-gray-300">
                                <option value="">All</option>
                                <option value="Siswa" <?php echo e(request('position') == 'Siswa' ? 'selected' : ''); ?>>Siswa</option>
                                <option value="Guru" <?php echo e(request('position') == 'Guru' ? 'selected' : ''); ?>>Guru</option>
                                <option value="Alumni" <?php echo e(request('position') == 'Alumni' ? 'selected' : ''); ?>>Alumni</option>
                            </select>
                        </div>
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>" 
                                placeholder="Search by name or testimonial..." class="rounded-md border-gray-300">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Testimonials Table -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Testimonials</h3>
                        <div class="text-sm text-gray-500">
                            Showing <?php echo e($testimonials->firstItem()); ?> to <?php echo e($testimonials->lastItem()); ?> of <?php echo e($testimonials->total()); ?> results
                        </div>
                    </div>

                    <?php if($testimonials->count() > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Testimonial</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="max-w-xs">
                                                    <p class="text-sm text-gray-900 truncate"><?php echo e(Str::limit($testimonial->testimonial, 100)); ?></p>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <?php if($testimonial->photo): ?>
                                                        <img class="h-10 w-10 rounded-full object-cover" src="<?php echo e(Storage::url($testimonial->photo)); ?>" alt="<?php echo e($testimonial->name); ?>">
                                                    <?php else: ?>
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <i class="fas fa-user text-gray-600"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900"><?php echo e($testimonial->name); ?></div>
                                                        <div class="text-sm text-gray-500">
                                                            <?php if($testimonial->position === 'Alumni'): ?>
                                                                Alumni <?php echo e($testimonial->graduation_year); ?>

                                                            <?php elseif($testimonial->position === 'Siswa'): ?>
                                                                <?php echo e($testimonial->class); ?>

                                                            <?php else: ?>
                                                                <?php echo e($testimonial->position); ?>

                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex flex-col space-y-1">
                                                    <?php if($testimonial->is_approved): ?>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <i class="fas fa-check mr-1"></i>Approved
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            <i class="fas fa-clock mr-1"></i>Pending
                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if($testimonial->is_featured): ?>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                            <i class="fas fa-star mr-1"></i>Featured
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                                        <i class="fas fa-star text-sm <?php echo e($i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300'); ?>"></i>
                                                    <?php endfor; ?>
                                                    <span class="ml-2 text-sm text-gray-500"><?php echo e($testimonial->rating); ?>/5</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php echo e($testimonial->created_at->format('M d, Y')); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <!-- View Button -->
                                                    <button onclick="viewTestimonial(<?php echo e($testimonial->id); ?>)" 
                                                        class="text-blue-600 hover:text-blue-900" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </button>

                                                    <!-- Approve/Reject Buttons -->
                                                    <?php if(!$testimonial->is_approved): ?>
                                                        <form method="POST" action="<?php echo e(route('admin.testimonials.approve', $testimonial)); ?>" class="inline">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Approve">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    <?php else: ?>
                                                        <form method="POST" action="<?php echo e(route('admin.testimonials.reject', $testimonial)); ?>" class="inline">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900" title="Reject">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>

                                                    <!-- Featured Toggle -->
                                                    <form method="POST" action="<?php echo e(route('admin.testimonials.toggle-featured', $testimonial)); ?>" class="inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="<?php echo e($testimonial->is_featured ? 'text-purple-600 hover:text-purple-900' : 'text-gray-400 hover:text-purple-600'); ?>" 
                                                            title="<?php echo e($testimonial->is_featured ? 'Remove from Featured' : 'Add to Featured'); ?>">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Delete Button -->
                                                    <form method="POST" action="<?php echo e(route('admin.testimonials.destroy', $testimonial)); ?>" class="inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            <?php echo e($testimonials->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <i class="fas fa-comments text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No testimonials found</h3>
                            <p class="text-gray-500">There are no testimonials matching your criteria.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- View Testimonial Modal -->
    <div id="testimonialModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Testimonial Details</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="testimonialContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewTestimonial(id) {
            // Show loading state
            document.getElementById('testimonialContent').innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-2xl text-gray-400 mb-4"></i>
                    <p class="text-gray-500">Loading testimonial details...</p>
                </div>
            `;
            document.getElementById('testimonialModal').classList.remove('hidden');

            // Fetch testimonial details via AJAX
            fetch(`/admin/testimonials/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const testimonial = data.testimonial;
                        document.getElementById('testimonialContent').innerHTML = `
                            <div class="space-y-4">
                                <!-- Author Info -->
                                <div class="flex items-center space-x-3">
                                    <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">${testimonial.name}</h4>
                                        <p class="text-sm text-gray-600">${testimonial.position} ${testimonial.graduation_year || testimonial.class || ''}</p>
                                    </div>
                                </div>

                                <!-- Rating -->
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium">Rating:</span>
                                    <div class="flex items-center">
                                        ${Array.from({length: 5}, (_, i) => 
                                            `<i class="fas fa-star text-sm ${i < testimonial.rating ? 'text-yellow-400' : 'text-gray-300'}"></i>`
                                        ).join('')}
                                    </div>
                                    <span class="text-sm text-gray-500">${testimonial.rating}/5</span>
                                </div>

                                <!-- Testimonial Content -->
                                <div>
                                    <p class="text-gray-900 bg-gray-50 rounded p-3">${testimonial.testimonial}</p>
                                </div>

                                <!-- Status -->
                                <div class="flex items-center space-x-2">
                                    ${testimonial.is_approved ? 
                                        '<span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">Approved</span>' :
                                        '<span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">Pending</span>'
                                    }
                                    ${testimonial.is_featured ? 
                                        '<span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded">Featured</span>' : ''
                                    }
                                </div>
                            </div>
                        `;
                    } else {
                        document.getElementById('testimonialContent').innerHTML = `
                            <div class="text-center py-8">
                                <i class="fas fa-exclamation-triangle text-2xl text-red-400 mb-4"></i>
                                <p class="text-red-500">Error loading testimonial details</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('testimonialContent').innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-exclamation-triangle text-2xl text-red-400 mb-4"></i>
                            <p class="text-red-500">Error loading testimonial details</p>
                        </div>
                    `;
                });
        }

        function closeModal() {
            document.getElementById('testimonialModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('testimonialModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
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
<?php endif; ?><?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/admin/testimonials/index.blade.php ENDPATH**/ ?>