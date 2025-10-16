<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonial - {{ $link->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $link->title }}</h1>
                @if($link->description)
                    <p class="text-gray-600">{{ $link->description }}</p>
                @endif
                <div class="mt-4 text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    Active until: {{ $link->active_until->format('M d, Y H:i') }}
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="p-6">
                    <form action="{{ route('testimonials.public.store', $link->token) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Personal Information -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Position *</label>
                                <select name="position" id="position" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('position') border-red-500 @enderror">
                                    <option value="">Select your position</option>
                                    @foreach($link->target_audience as $audience)
                                        <option value="{{ $audience }}" {{ old('position') == $audience ? 'selected' : '' }}>
                                            {{ $audience }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('position')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Conditional Fields -->
                            <div id="class-field" class="mt-6 hidden">
                                <label for="class" class="block text-sm font-medium text-gray-700 mb-2">Class</label>
                                <input type="text" name="class" id="class" value="{{ old('class') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('class') border-red-500 @enderror"
                                    placeholder="e.g., XII IPA 1">
                                @error('class')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="graduation-year-field" class="mt-6 hidden">
                                <label for="graduation_year" class="block text-sm font-medium text-gray-700 mb-2">Graduation Year</label>
                                <input type="text" name="graduation_year" id="graduation_year" value="{{ old('graduation_year') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('graduation_year') border-red-500 @enderror"
                                    placeholder="e.g., 2023">
                                @error('graduation_year')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Testimonial Content -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Your Testimonial</h3>
                            
                            <div class="mb-6">
                                <label for="testimonial" class="block text-sm font-medium text-gray-700 mb-2">Testimonial *</label>
                                <textarea name="testimonial" id="testimonial" rows="6" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('testimonial') border-red-500 @enderror"
                                    placeholder="Share your experience and thoughts about the school...">{{ old('testimonial') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Minimum 50 characters, maximum 1000 characters</p>
                                @error('testimonial')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating *</label>
                                <div class="flex items-center space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" 
                                            {{ old('rating') == $i ? 'checked' : '' }} required
                                            class="h-4 w-4 text-yellow-400 focus:ring-yellow-400 border-gray-300">
                                        <label for="rating{{ $i }}" class="text-yellow-400 cursor-pointer">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-500">(1 = Poor, 5 = Excellent)</span>
                                </div>
                                @error('rating')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Photo (Optional)</label>
                                <input type="file" name="photo" id="photo" accept="image/*"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('photo') border-red-500 @enderror">
                                <p class="text-sm text-gray-500 mt-1">Maximum 2MB, formats: JPEG, PNG, JPG, GIF</p>
                                @error('photo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                class="px-8 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 font-medium">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Submit Testimonial
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 text-sm text-gray-500">
                <p>This testimonial will be reviewed by our admin team before being published.</p>
            </div>
        </div>
    </div>

    <script>
        // Show/hide conditional fields based on position
        document.getElementById('position').addEventListener('change', function() {
            const classField = document.getElementById('class-field');
            const graduationYearField = document.getElementById('graduation-year-field');
            
            if (this.value === 'Siswa') {
                classField.classList.remove('hidden');
                graduationYearField.classList.add('hidden');
            } else if (this.value === 'Alumni') {
                classField.classList.add('hidden');
                graduationYearField.classList.remove('hidden');
            } else {
                classField.classList.add('hidden');
                graduationYearField.classList.add('hidden');
            }
        });

        // Character counter for testimonial
        document.getElementById('testimonial').addEventListener('input', function() {
            const length = this.value.length;
            const minLength = 50;
            const maxLength = 1000;
            
            if (length < minLength) {
                this.setCustomValidity(`Please enter at least ${minLength} characters.`);
            } else if (length > maxLength) {
                this.setCustomValidity(`Please enter no more than ${maxLength} characters.`);
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>