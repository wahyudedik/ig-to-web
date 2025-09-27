<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Maintenance</h1>
                <p class="text-slate-600 mt-1">Update maintenance record information</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('sarpras.maintenance.show', $maintenance) }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View
                </a>
                <a href="{{ route('sarpras.maintenance.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-slate-900">Maintenance Information</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('sarpras.maintenance.update', $maintenance) }}"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Item Type -->
                        <div>
                            <label for="item_type" class="form-label">Item Type</label>
                            <select id="item_type" name="item_type" required
                                class="form-input @error('item_type') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                <option value="">Select item type</option>
                                <option value="barang"
                                    {{ old('item_type', $maintenance->item_type) === 'barang' ? 'selected' : '' }}>
                                    Barang</option>
                                <option value="ruang"
                                    {{ old('item_type', $maintenance->item_type) === 'ruang' ? 'selected' : '' }}>Ruang
                                </option>
                            </select>
                            @error('item_type')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Item ID -->
                        <div>
                            <label for="item_id" class="form-label">Item</label>
                            <select id="item_id" name="item_id" required
                                class="form-input @error('item_id') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                <option value="">Select item</option>
                                @if ($maintenance->item_type === 'barang')
                                    @foreach (\App\Models\Barang::all() as $barang)
                                        <option value="{{ $barang->id }}"
                                            {{ old('item_id', $maintenance->item_id) == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->nama }}
                                        </option>
                                    @endforeach
                                @elseif($maintenance->item_type === 'ruang')
                                    @foreach (\App\Models\Ruang::all() as $ruang)
                                        <option value="{{ $ruang->id }}"
                                            {{ old('item_id', $maintenance->item_id) == $ruang->id ? 'selected' : '' }}>
                                            {{ $ruang->nama }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('item_id')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Maintenance Type -->
                        <div>
                            <label for="maintenance_type" class="form-label">Maintenance Type</label>
                            <select id="maintenance_type" name="maintenance_type" required
                                class="form-input @error('maintenance_type') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                <option value="">Select maintenance type</option>
                                <option value="preventive"
                                    {{ old('maintenance_type', $maintenance->maintenance_type) === 'preventive' ? 'selected' : '' }}>
                                    Preventive</option>
                                <option value="corrective"
                                    {{ old('maintenance_type', $maintenance->maintenance_type) === 'corrective' ? 'selected' : '' }}>
                                    Corrective</option>
                                <option value="emergency"
                                    {{ old('maintenance_type', $maintenance->maintenance_type) === 'emergency' ? 'selected' : '' }}>
                                    Emergency</option>
                            </select>
                            @error('maintenance_type')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" required
                                class="form-input @error('status') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                <option value="">Select status</option>
                                <option value="pending"
                                    {{ old('status', $maintenance->status) === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="in_progress"
                                    {{ old('status', $maintenance->status) === 'in_progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="completed"
                                    {{ old('status', $maintenance->status) === 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="cancelled"
                                    {{ old('status', $maintenance->status) === 'cancelled' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                            @error('status')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="form-label">Priority</label>
                            <select id="priority" name="priority" required
                                class="form-input @error('priority') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                <option value="">Select priority</option>
                                <option value="low"
                                    {{ old('priority', $maintenance->priority) === 'low' ? 'selected' : '' }}>Low
                                </option>
                                <option value="medium"
                                    {{ old('priority', $maintenance->priority) === 'medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="high"
                                    {{ old('priority', $maintenance->priority) === 'high' ? 'selected' : '' }}>High
                                </option>
                            </select>
                            @error('priority')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cost -->
                        <div>
                            <label for="cost" class="form-label">Cost (Rp)</label>
                            <input type="number" id="cost" name="cost"
                                value="{{ old('cost', $maintenance->cost) }}"
                                class="form-input @error('cost') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Enter maintenance cost">
                            @error('cost')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label for="duration_hours" class="form-label">Duration (Hours)</label>
                            <input type="number" id="duration_hours" name="duration_hours"
                                value="{{ old('duration_hours', $maintenance->duration_hours) }}"
                                class="form-input @error('duration_hours') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Enter duration in hours">
                            @error('duration_hours')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Scheduled Date -->
                        <div>
                            <label for="scheduled_date" class="form-label">Scheduled Date</label>
                            <input type="date" id="scheduled_date" name="scheduled_date"
                                value="{{ old('scheduled_date', $maintenance->scheduled_date?->format('Y-m-d')) }}"
                                class="form-input @error('scheduled_date') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('scheduled_date')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Completed Date -->
                        <div>
                            <label for="completed_date" class="form-label">Completed Date</label>
                            <input type="date" id="completed_date" name="completed_date"
                                value="{{ old('completed_date', $maintenance->completed_date?->format('Y-m-d')) }}"
                                class="form-input @error('completed_date') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('completed_date')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="form-input @error('description') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Enter maintenance description">{{ old('description', $maintenance->description) }}</textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="form-label">Notes</label>
                        <textarea id="notes" name="notes" rows="3"
                            class="form-input @error('notes') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Enter maintenance notes">{{ old('notes', $maintenance->notes) }}</textarea>
                        @error('notes')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Photos -->
                    <div>
                        <label for="photos" class="form-label">Photos</label>
                        <input type="file" id="photos" name="photos[]" multiple accept="image/*"
                            class="form-input @error('photos') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                        <p class="text-sm text-slate-500 mt-1">You can select multiple photos. Existing photos will be
                            replaced.</p>
                        @error('photos')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Photos -->
                    @if ($maintenance->photos && count($maintenance->photos) > 0)
                        <div>
                            <label class="form-label">Current Photos</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach ($maintenance->photos as $photo)
                                    <div class="relative">
                                        <img src="{{ $maintenance->getPhotoUrl($photo) }}" alt="Current photo"
                                            class="w-full h-24 object-cover rounded-lg">
                                        <button type="button"
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600"
                                            onclick="removePhoto('{{ $photo }}')">
                                            ×
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-200">
                        <a href="{{ route('sarpras.maintenance.show', $maintenance) }}" class="btn btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Update Maintenance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Update item options based on item type
        document.getElementById('item_type').addEventListener('change', function() {
            const itemType = this.value;
            const itemSelect = document.getElementById('item_id');

            // Clear existing options
            itemSelect.innerHTML = '<option value="">Select item</option>';

            if (itemType === 'barang') {
                // Add barang options (this would be populated via AJAX in a real implementation)
                itemSelect.innerHTML += '<option value="1">Sample Barang 1</option>';
                itemSelect.innerHTML += '<option value="2">Sample Barang 2</option>';
            } else if (itemType === 'ruang') {
                // Add ruang options (this would be populated via AJAX in a real implementation)
                itemSelect.innerHTML += '<option value="1">Sample Ruang 1</option>';
                itemSelect.innerHTML += '<option value="2">Sample Ruang 2</option>';
            }
        });

        function removePhoto(photoName) {
            if (confirm('Are you sure you want to remove this photo?')) {
                // In a real implementation, this would make an AJAX call to remove the photo
                console.log('Removing photo:', photoName);
            }
        }
    </script>
</x-app-layout>
