<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900">Data Management</h1>
                        <p class="text-gray-600 mt-2">Kelola data kelas, jurusan, dan ekstrakurikuler</p>
                    </div>

                    <!-- Kelas Section -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">Data Kelas</h2>
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded">
                                {{ $kelas->count() }} Kelas
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($kelas as $k)
                                <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-900">{{ $k->nama }}</span>
                                        <div class="flex space-x-2">
                                            <button class="text-yellow-600 hover:text-yellow-800 text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button class="text-red-600 hover:text-red-800 text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Jurusan Section -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">Data Jurusan</h2>
                            <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded">
                                {{ $jurusan->count() }} Jurusan
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($jurusan as $j)
                                <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-900">{{ $j->nama }}</span>
                                        <div class="flex space-x-2">
                                            <button class="text-yellow-600 hover:text-yellow-800 text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button class="text-red-600 hover:text-red-800 text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Ekstrakurikuler Section -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">Data Ekstrakurikuler</h2>
                            <span class="bg-purple-100 text-purple-800 text-sm font-medium px-2.5 py-0.5 rounded">
                                {{ $ekstrakurikuler->count() }} Ekstrakurikuler
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($ekstrakurikuler as $e)
                                <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-900">{{ $e->nama }}</span>
                                        <div class="flex space-x-2">
                                            <button class="text-yellow-600 hover:text-yellow-800 text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button class="text-red-600 hover:text-red-800 text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="flex justify-end">
                        <a href="{{ route('settings.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
