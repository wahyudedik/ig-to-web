<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Siswa Dashboard</h1>
                <p class="text-slate-600 mt-1">Welcome back, {{ Auth::user()->name }}!</p>
            </div>
            <div class="flex items-center space-x-2">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mr-1.5"></span>
                    Siswa
                </span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Card -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-8">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-slate-600">Anda login sebagai <span class="font-semibold text-blue-600">Siswa</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Student Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- My Classes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Kelas Saya</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Lihat kelas yang diikuti</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Learning Materials -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Materi Pembelajaran
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Download materi ajar</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Grades -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Nilai Saya</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Lihat nilai dan rapor</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignments -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Tugas</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Lihat dan kerjakan tugas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Jadwal</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Jadwal pelajaran</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pesan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Chat dengan guru</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- E-Lulus (Only for Grade 12) -->
            @php
                $user = Auth::user();
                $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();
                $isGrade12 = $siswa && str_contains($siswa->kelas, 'XII');
            @endphp

            @if ($isGrade12)
                <div
                    class="bg-gradient-to-r from-green-500 to-blue-600 text-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-3xl">🎓</span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium">E-Lulus</h3>
                                <p class="text-sm opacity-90">Cek status kelulusan Anda</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('kelulusan.check') }}"
                                class="inline-flex items-center px-4 py-2 bg-white text-green-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                <span class="mr-2">🔍</span>
                                Cek Status Kelulusan
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Today's Schedule -->
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Jadwal Hari Ini</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100">Matematika - Pak Budi</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">07:00 - 08:30</p>
                        </div>
                        <span
                            class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Selesai</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100">Fisika - Bu Sari</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">09:00 - 10:30</p>
                        </div>
                        <span
                            class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">Berlangsung</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100">Bahasa Indonesia - Pak Ahmad
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">11:00 - 12:30</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Akan
                            Datang</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Assignments -->
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Tugas Terbaru</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100">Tugas Matematika - Aljabar</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Deadline: 20 Januari 2024</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Belum
                            Dikerjakan</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100">Essay Fisika - Gerak Lurus</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Deadline: 22 Januari 2024</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Sedang
                            Dikerjakan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Aksi Cepat</h3>
                <div class="flex flex-wrap gap-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Lihat Jadwal
                    </button>
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Download Materi
                    </button>
                    <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        Lihat Nilai
                    </button>
                    <a href="{{ route('instagram.activities') }}"
                        class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                        Lihat Instagram
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
