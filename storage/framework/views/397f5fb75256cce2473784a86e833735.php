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
                <h1 class="text-2xl font-bold text-slate-900">Create New Page</h1>
                <p class="text-slate-600 mt-1">Create a new page or menu item</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="<?php echo e(route('admin.pages.index')); ?>" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Pages
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form action="<?php echo e(route('admin.pages.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-slate-900">Basic Information</h3>
                        </div>
                        <div class="card-body space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title
                                    *</label>
                                <input type="text" name="title" id="title" value="<?php echo e(old('title')); ?>" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="excerpt"
                                    class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
                                <textarea name="excerpt" id="excerpt" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('excerpt')); ?></textarea>
                                <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content
                                    *</label>
                                <textarea name="content" id="content" rows="10" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('content')); ?></textarea>
                                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-slate-900">SEO Settings</h3>
                        </div>
                        <div class="card-body space-y-4">
                            <div>
                                <label for="seo_title" class="block text-sm font-medium text-gray-700 mb-2">SEO
                                    Title</label>
                                <input type="text" name="seo_title" id="seo_title" value="<?php echo e(old('seo_title')); ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="seo_description" class="block text-sm font-medium text-gray-700 mb-2">SEO
                                    Description</label>
                                <textarea name="seo_description" id="seo_description" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('seo_description')); ?></textarea>
                            </div>

                            <div>
                                <label for="seo_keywords" class="block text-sm font-medium text-gray-700 mb-2">SEO
                                    Keywords</label>
                                <input type="text" name="seo_keywords" id="seo_keywords"
                                    value="<?php echo e(old('seo_keywords')); ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="keyword1, keyword2, keyword3">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Publish Settings -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-slate-900">Publish Settings</h3>
                        </div>
                        <div class="card-body space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status
                                    *</label>
                                <select name="status" id="status" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="draft" <?php echo e(old('status') == 'draft' ? 'selected' : ''); ?>>Draft
                                    </option>
                                    <option value="published" <?php echo e(old('status') == 'published' ? 'selected' : ''); ?>>
                                        Published</option>
                                    <option value="archived" <?php echo e(old('status') == 'archived' ? 'selected' : ''); ?>>
                                        Archived</option>
                                </select>
                                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="category"
                                    class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select name="category" id="category"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category); ?>"
                                            <?php echo e(old('category') == $category ? 'selected' : ''); ?>>
                                            <?php echo e(ucfirst($category)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div>
                                <label for="template" class="block text-sm font-medium text-gray-700 mb-2">Template
                                    *</label>
                                <select name="template" id="template" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($template); ?>"
                                            <?php echo e(old('template') == $template ? 'selected' : ''); ?>>
                                            <?php echo e(ucfirst($template)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['template'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                    <?php echo e(old('is_featured') ? 'checked' : ''); ?>

                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                    Featured Page
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Settings -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-slate-900">Menu Settings</h3>
                        </div>
                        <div class="card-body space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_menu" id="is_menu" value="1"
                                    <?php echo e(old('is_menu') ? 'checked' : ''); ?>

                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_menu" class="ml-2 block text-sm text-gray-900">
                                    Add to Menu
                                </label>
                            </div>

                            <div id="menu-settings" class="space-y-4" style="display: none;">
                                <div>
                                    <label for="menu_title" class="block text-sm font-medium text-gray-700 mb-2">Menu
                                        Title</label>
                                    <input type="text" name="menu_title" id="menu_title"
                                        value="<?php echo e(old('menu_title')); ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <p class="text-sm text-gray-500 mt-1">Leave empty to use page title</p>
                                </div>

                                <div>
                                    <label for="menu_position"
                                        class="block text-sm font-medium text-gray-700 mb-2">Menu Position</label>
                                    <select name="menu_position" id="menu_position"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="header"
                                            <?php echo e(old('menu_position') == 'header' ? 'selected' : ''); ?>>Header</option>
                                        <option value="footer"
                                            <?php echo e(old('menu_position') == 'footer' ? 'selected' : ''); ?>>Footer</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Parent
                                        Menu</label>
                                    <select name="parent_id" id="parent_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Main Menu Item</option>
                                        <?php $__currentLoopData = $parentPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parentPage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($parentPage->id); ?>"
                                                <?php echo e(old('parent_id') == $parentPage->id ? 'selected' : ''); ?>>
                                                <?php echo e($parentPage->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div>
                                    <label for="menu_icon" class="block text-sm font-medium text-gray-700 mb-2">Menu
                                        Icon</label>
                                    <input type="text" name="menu_icon" id="menu_icon"
                                        value="<?php echo e(old('menu_icon')); ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="fas fa-home">
                                    <p class="text-sm text-gray-500 mt-1">FontAwesome icon class</p>
                                </div>

                                <div>
                                    <label for="menu_url" class="block text-sm font-medium text-gray-700 mb-2">Custom
                                        URL</label>
                                    <input type="text" name="menu_url" id="menu_url"
                                        value="<?php echo e(old('menu_url')); ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="/custom-url or https://external.com">
                                    <p class="text-sm text-gray-500 mt-1">Leave empty to use page URL</p>
                                </div>

                                <div>
                                    <label for="menu_sort_order"
                                        class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                                    <input type="number" name="menu_sort_order" id="menu_sort_order"
                                        value="<?php echo e(old('menu_sort_order', 0)); ?>"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="menu_target_blank" id="menu_target_blank"
                                        value="1" <?php echo e(old('menu_target_blank') ? 'checked' : ''); ?>

                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="menu_target_blank" class="ml-2 block text-sm text-gray-900">
                                        Open in New Tab
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-slate-900">Featured Image</h3>
                        </div>
                        <div class="card-body">
                            <div>
                                <input type="file" name="featured_image" id="featured_image" accept="image/*"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <?php $__errorArgs = ['featured_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 mt-8">
                <a href="<?php echo e(route('admin.pages.index')); ?>" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Create Page
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuCheckbox = document.getElementById('is_menu');
            const menuSettings = document.getElementById('menu-settings');

            function toggleMenuSettings() {
                if (menuCheckbox.checked) {
                    menuSettings.style.display = 'block';
                } else {
                    menuSettings.style.display = 'none';
                }
            }

            menuCheckbox.addEventListener('change', toggleMenuSettings);
            toggleMenuSettings(); // Initial check
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
<?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/pages/create.blade.php ENDPATH**/ ?>