<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - Website Sekolah</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Include the existing Tailwind CSS here */
        </style>
    @endif

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-lg mb-4">
                <i class="fas fa-graduation-cap text-2xl text-blue-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Daftar Akun</h1>
            <p class="text-white opacity-90">Bergabung dengan komunitas sekolah digital</p>
        </div>

        <!-- Form Card -->
        <div class="form-card rounded-2xl shadow-2xl p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-blue-600"></i>Nama Lengkap
                    </label>
                    <input id="name"
                        class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                        type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-blue-600"></i>Email
                    </label>
                    <input id="email"
                        class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                        type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        placeholder="Masukkan email">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-blue-600"></i>Password
                    </label>
                    <input id="password"
                        class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                        type="password" name="password" required autocomplete="new-password"
                        placeholder="Masukkan password">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-blue-600"></i>Konfirmasi Password
                    </label>
                    <input id="password_confirmation"
                        class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                        type="password" name="password_confirmation" required autocomplete="new-password"
                        placeholder="Konfirmasi password">
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="btn-primary w-full py-3 px-4 rounded-lg text-white font-semibold text-lg shadow-lg hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </button>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="text-blue-600 hover:text-blue-800 font-semibold transition-colors duration-300">
                            <i class="fas fa-sign-in-alt mr-1"></i>Masuk di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-white opacity-75 text-sm">
                <i class="fas fa-shield-alt mr-1"></i>
                Data Anda aman dan terlindungi
            </p>
        </div>
    </div>
</body>

</html>
