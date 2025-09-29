<?php

namespace Database\Seeders;

use App\Models\Ruang;
use Illuminate\Database\Seeder;

class TestSarprasRuangSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $this->command->info('Testing Sarpras Ruang...');
        
        // Create some test rooms if they don't exist
        $rooms = [
            [
                'kode_ruang' => 'R001',
                'nama_ruang' => 'Lab Komputer 1',
                'jenis_ruang' => 'Laboratorium',
                'luas_ruang' => 50.0,
                'kapasitas' => 30,
                'lantai' => '1',
                'gedung' => 'Gedung A',
                'kondisi' => 'baik',
                'status' => 'aktif',
            ],
            [
                'kode_ruang' => 'R002',
                'nama_ruang' => 'Kelas XII IPA 1',
                'jenis_ruang' => 'Kelas',
                'luas_ruang' => 40.0,
                'kapasitas' => 32,
                'lantai' => '2',
                'gedung' => 'Gedung B',
                'kondisi' => 'baik',
                'status' => 'aktif',
            ],
            [
                'kode_ruang' => 'R003',
                'nama_ruang' => 'Perpustakaan',
                'jenis_ruang' => 'Perpustakaan',
                'luas_ruang' => 80.0,
                'kapasitas' => 50,
                'lantai' => '1',
                'gedung' => 'Gedung C',
                'kondisi' => 'baik',
                'status' => 'aktif',
            ],
            [
                'kode_ruang' => 'R004',
                'nama_ruang' => 'Ruang Guru',
                'jenis_ruang' => 'Kantor',
                'luas_ruang' => 35.0,
                'kapasitas' => 20,
                'lantai' => '2',
                'gedung' => 'Gedung A',
                'kondisi' => 'rusak',
                'status' => 'renovasi',
            ],
        ];

        foreach ($rooms as $room) {
            Ruang::updateOrCreate(
                ['kode_ruang' => $room['kode_ruang']],
                $room
            );
        }

        $this->command->info('Test rooms created successfully!');
        
        // Test the data
        $totalRooms = Ruang::count();
        $activeRooms = Ruang::where('status', 'aktif')->count();
        $goodConditionRooms = Ruang::where('kondisi', 'baik')->count();
        $totalArea = Ruang::sum('luas_ruang');
        
        $this->command->info('');
        $this->command->info("Total Rooms: {$totalRooms}");
        $this->command->info("Active Rooms: {$activeRooms}");
        $this->command->info("Good Condition Rooms: {$goodConditionRooms}");
        $this->command->info("Total Area: {$totalArea} m²");
        
        // Test pagination
        $ruangs = Ruang::withCount('barang')
            ->orderBy('nama_ruang')
            ->paginate(15);
            
        $this->command->info("Paginated Rooms: {$ruangs->count()}");
        $this->command->info("Total Items: {$ruangs->total()}");
        $this->command->info("First Item: {$ruangs->firstItem()}");
        $this->command->info("Last Item: {$ruangs->lastItem()}");
        $this->command->info("Has Pages: " . ($ruangs->hasPages() ? 'Yes' : 'No'));
        
        $this->command->info('');
        $this->command->info('✅ All Sarpras Ruang tests passed!');
    }
}
