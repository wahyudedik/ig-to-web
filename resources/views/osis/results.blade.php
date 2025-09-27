<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Hasil Pemilihan OSIS</h1>
                <p class="text-slate-600 mt-1">Statistik dan hasil pemilihan ketua dan wakil ketua OSIS</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('osis.voting') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Voting
                </a>
                <a href="{{ route('osis.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke OSIS
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Total Pemilih</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $total_pemilih }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Sudah Memilih</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $sudah_memilih }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Belum Memilih</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $belum_memilih }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-600">Partisipasi</p>
                        <p class="text-2xl font-bold text-slate-900">
                            {{ $total_pemilih > 0 ? round(($sudah_memilih / $total_pemilih) * 100, 1) : 0 }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div class="space-y-6">
            <h2 class="text-xl font-semibold text-slate-900">Hasil Pemilihan</h2>

            @if ($calon->count() > 0)
                <div class="space-y-4">
                    @foreach ($calon as $index => $candidate)
                        <div class="bg-white rounded-xl border border-slate-200 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full font-semibold">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-900">
                                            {{ $candidate->full_candidate_name }}</h3>
                                        <p class="text-sm text-slate-600">{{ $candidate->pencalonan_type_display }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-slate-900">{{ $candidate->total_votes }}</p>
                                    <p class="text-sm text-slate-600">suara ({{ $candidate->vote_percentage }}%)</p>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="w-full bg-slate-200 rounded-full h-3">
                                    <div class="bg-blue-600 h-3 rounded-full transition-all duration-500"
                                        style="width: {{ $candidate->vote_percentage }}%"></div>
                                </div>
                            </div>

                            <!-- Candidate Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Ketua -->
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                                        @if ($candidate->ketua_photo_url)
                                            <img src="{{ $candidate->ketua_photo_url }}"
                                                alt="{{ $candidate->nama_ketua }}"
                                                class="w-16 h-16 rounded-full object-cover">
                                        @else
                                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-900">{{ $candidate->nama_ketua }}</h4>
                                        <p class="text-sm text-slate-600">Ketua OSIS</p>
                                        <p class="text-xs text-slate-500">{{ $candidate->kelas_ketua }}</p>
                                    </div>
                                </div>

                                <!-- Wakil -->
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                        @if ($candidate->wakil_photo_url)
                                            <img src="{{ $candidate->wakil_photo_url }}"
                                                alt="{{ $candidate->nama_wakil }}"
                                                class="w-16 h-16 rounded-full object-cover">
                                        @else
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-slate-900">{{ $candidate->nama_wakil }}</h4>
                                        <p class="text-sm text-slate-600">Wakil Ketua OSIS</p>
                                        <p class="text-xs text-slate-500">{{ $candidate->kelas_wakil }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="text-slate-500">Belum ada data hasil pemilihan</p>
                </div>
            @endif
        </div>

        <!-- Recent Votes -->
        @if ($recent_votes->count() > 0)
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-slate-900 mb-4">Voting Terbaru</h2>
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <div class="space-y-3">
                        @foreach ($recent_votes as $vote)
                            <div class="flex items-center space-x-3 p-3 hover:bg-slate-50 rounded-lg">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900">{{ $vote->pemilih->nama }}</p>
                                    <p class="text-xs text-slate-500">{{ $vote->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
