<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Pengecekan Status Kelulusan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Success Message -->
                    <div class="text-center mb-8">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">
                            Selamat {{ $kelulusan->nama }}!
                        </h3>
                        <p class="text-lg text-gray-600">
                            @if ($kelulusan->status === 'lulus')
                                Kamu Dinyatakan <span class="font-bold text-green-600">LULUS</span>!
                            @elseif($kelulusan->status === 'tidak_lulus')
                                Status: <span class="font-bold text-red-600">TIDAK LULUS</span>
                            @else
                                Status: <span class="font-bold text-yellow-600">MENGULANG</span>
                            @endif
                        </p>
                    </div>

                    <!-- Student Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Basic Information -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Siswa</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nama:</span>
                                    <span class="font-medium">{{ $kelulusan->nama }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">NISN:</span>
                                    <span class="font-medium">{{ $kelulusan->nisn }}</span>
                                </div>
                                @if ($kelulusan->nis)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">NIS:</span>
                                        <span class="font-medium">{{ $kelulusan->nis }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jurusan:</span>
                                    <span class="font-medium">{{ $kelulusan->major_display }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tahun Ajaran:</span>
                                    <span class="font-medium">{{ $kelulusan->graduation_year_display }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status:</span>
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if ($kelulusan->status_badge_color == 'green') bg-green-100 text-green-800
                                        @elseif($kelulusan->status_badge_color == 'red') bg-red-100 text-red-800
                                        @elseif($kelulusan->status_badge_color == 'yellow') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $kelulusan->status_display }}
                                    </span>
                                </div>
                                @if ($kelulusan->tanggal_lulus)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tanggal Lulus:</span>
                                        <span
                                            class="font-medium">{{ $kelulusan->tanggal_lulus->format('d F Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Photo -->
                        <div class="flex flex-col items-center">
                            @if ($kelulusan->foto)
                                <img src="{{ $kelulusan->photo_url }}" alt="{{ $kelulusan->nama }}"
                                    class="h-48 w-48 rounded-full object-cover mb-4">
                            @else
                                <div class="h-48 w-48 rounded-full bg-gray-300 flex items-center justify-center mb-4">
                                    <span
                                        class="text-gray-600 text-4xl font-medium">{{ substr($kelulusan->nama, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Current Activity -->
                    @if ($kelulusan->tempat_kuliah || $kelulusan->tempat_kerja)
                        <div class="mt-8 bg-blue-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Saat Ini</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if ($kelulusan->tempat_kuliah)
                                    <div>
                                        <h5 class="font-medium text-gray-700 mb-2">Pendidikan Lanjutan</h5>
                                        <p class="text-gray-600">{{ $kelulusan->education_path }}</p>
                                    </div>
                                @endif
                                @if ($kelulusan->tempat_kerja)
                                    <div>
                                        <h5 class="font-medium text-gray-700 mb-2">Pekerjaan</h5>
                                        <p class="text-gray-600">{{ $kelulusan->career_path }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Contact Information -->
                    @if ($kelulusan->no_hp || $kelulusan->no_wa || $kelulusan->alamat)
                        <div class="mt-8 bg-green-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kontak</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if ($kelulusan->contact_info)
                                    <div>
                                        <h5 class="font-medium text-gray-700 mb-2">Kontak</h5>
                                        <p class="text-gray-600">{{ $kelulusan->contact_info }}</p>
                                    </div>
                                @endif
                                @if ($kelulusan->alamat)
                                    <div>
                                        <h5 class="font-medium text-gray-700 mb-2">Alamat</h5>
                                        <p class="text-gray-600">{{ $kelulusan->alamat }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Achievements -->
                    @if ($kelulusan->prestasi)
                        <div class="mt-8 bg-yellow-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Prestasi</h4>
                            <p class="text-gray-600">{{ $kelulusan->prestasi }}</p>
                        </div>
                    @endif

                    <!-- Notes -->
                    @if ($kelulusan->catatan)
                        <div class="mt-8 bg-purple-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h4>
                            <p class="text-gray-600">{{ $kelulusan->catatan }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-8 flex justify-center space-x-4">
                        <a href="{{ route('lulus.check') }}"
                            class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Cek Status Lain
                        </a>
                        @if ($kelulusan->status === 'lulus')
                            <button onclick="window.print()"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Cetak Hasil
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .bg-white {
                box-shadow: none !important;
            }
        }
    </style>
</x-app-layout>
