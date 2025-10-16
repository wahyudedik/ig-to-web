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
            <?php echo e(__('Edit Role')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Roles
                        </a>
                    </div>

                    <form action="<?php echo e(route('admin.roles.update', $role)); ?>" method="POST" id="editRoleForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Role Information -->
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Role Information</h3>

                                    <div class="mb-4">
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Role
                                            Name *</label>
                                        <input type="text" name="name" id="name"
                                            value="<?php echo e(old('name', $role->name)); ?>" required
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <?php if($role->display_name): ?>
                                        <div class="mb-4">
                                            <label for="display_name"
                                                class="block text-sm font-medium text-gray-700 mb-1">Display
                                                Name</label>
                                            <input type="text" name="display_name" id="display_name"
                                                value="<?php echo e(old('display_name', $role->display_name)); ?>"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    <?php endif; ?>

                                    <?php if($role->description): ?>
                                        <div class="mb-4">
                                            <label for="description"
                                                class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                            <textarea name="description" id="description" rows="3"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo e(old('description', $role->description)); ?></textarea>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Permissions -->
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Permissions</h3>
                                    <div class="max-h-96 overflow-y-auto border border-gray-300 rounded-md p-4">
                                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $modulePermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="mb-4">
                                                <h4 class="text-sm font-medium text-gray-700 mb-2">
                                                    <?php echo e(ucfirst($module)); ?></h4>
                                                <div class="space-y-2">
                                                    <?php $__currentLoopData = $modulePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="<?php echo e($permission->name); ?>"
                                                                <?php echo e(in_array($permission->name, $rolePermissions) ? 'checked' : ''); ?>

                                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                            <span
                                                                class="ml-2 text-sm text-gray-700"><?php echo e($permission->display_name ?? $permission->name); ?></span>
                                                        </label>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-8">
                            <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Update Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('editRoleForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const permissions = Array.from(document.querySelectorAll('input[name="permissions[]"]:checked'))
                .map(input => input.value);

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Updating...';
            submitBtn.disabled = true;

            fetch(this.action, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: formData.get('name'),
                        display_name: formData.get('display_name'),
                        description: formData.get('description'),
                        permissions: permissions
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Role updated successfully!');
                        window.location.href = '<?php echo e(route('admin.roles.index')); ?>';
                    } else {
                        alert('Error updating role: ' + data.message);
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const errorMessage = error.message || 'Unknown error occurred';
                    alert('Error updating role: ' + errorMessage);
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
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
<?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/role-management/edit.blade.php ENDPATH**/ ?>