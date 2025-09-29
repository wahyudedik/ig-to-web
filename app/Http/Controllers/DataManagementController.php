<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\MataPelajaran;

class DataManagementController extends Controller
{
    // Kelas Management
    public function addKelas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:kelas,nama'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $kelas = DB::table('kelas')->insertGetId([
                'nama' => $request->nama,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil ditambahkan',
                'data' => ['id' => $kelas, 'nama' => $request->nama]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kelas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateKelas(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:kelas,nama,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            DB::table('kelas')->where('id', $id)->update([
                'nama' => $request->nama,
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil diupdate',
                'data' => ['id' => $id, 'nama' => $request->nama]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate kelas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteKelas($id)
    {
        try {
            DB::table('kelas')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kelas: ' . $e->getMessage()
            ], 500);
        }
    }

    // Jurusan Management
    public function addJurusan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:jurusan,nama'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $jurusan = DB::table('jurusan')->insertGetId([
                'nama' => $request->nama,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jurusan berhasil ditambahkan',
                'data' => ['id' => $jurusan, 'nama' => $request->nama]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan jurusan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateJurusan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:jurusan,nama,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            DB::table('jurusan')->where('id', $id)->update([
                'nama' => $request->nama,
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jurusan berhasil diupdate',
                'data' => ['id' => $id, 'nama' => $request->nama]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate jurusan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteJurusan($id)
    {
        try {
            DB::table('jurusan')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Jurusan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus jurusan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Ekstrakurikuler Management
    public function addEkstrakurikuler(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:ekstrakurikuler,nama'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $ekstrakurikuler = DB::table('ekstrakurikuler')->insertGetId([
                'nama' => $request->nama,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ekstrakurikuler berhasil ditambahkan',
                'data' => ['id' => $ekstrakurikuler, 'nama' => $request->nama]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan ekstrakurikuler: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateEkstrakurikuler(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:ekstrakurikuler,nama,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            DB::table('ekstrakurikuler')->where('id', $id)->update([
                'nama' => $request->nama,
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ekstrakurikuler berhasil diupdate',
                'data' => ['id' => $id, 'nama' => $request->nama]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate ekstrakurikuler: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteEkstrakurikuler($id)
    {
        try {
            DB::table('ekstrakurikuler')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ekstrakurikuler berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus ekstrakurikuler: ' . $e->getMessage()
            ], 500);
        }
    }

    // User Management
    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'user_type' => 'required|in:siswa,guru,admin'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'user_type' => $request->user_type,
                'email_verified_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => $user->user_type
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'user_type' => 'required|in:siswa,guru,admin'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $user = \App\Models\User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'user_type' => $request->user_type
            ]);

            if ($request->password) {
                $user->update(['password' => bcrypt($request->password)]);
            }

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diupdate',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => $user->user_type
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteUser($id)
    {
        try {
            \App\Models\User::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus user: ' . $e->getMessage()
            ], 500);
        }
    }

    // Mata Pelajaran Management
    public function addMataPelajaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:mata_pelajaran,nama'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $mataPelajaran = MataPelajaran::create([
                'nama' => $request->nama
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mata pelajaran berhasil ditambahkan.',
                'data' => $mataPelajaran
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan mata pelajaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateMataPelajaran(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:mata_pelajaran,nama,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $mataPelajaran = MataPelajaran::findOrFail($id);
            $mataPelajaran->update([
                'nama' => $request->nama
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mata pelajaran berhasil diperbarui.',
                'data' => $mataPelajaran
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui mata pelajaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteMataPelajaran($id)
    {
        try {
            $mataPelajaran = MataPelajaran::findOrFail($id);
            $mataPelajaran->delete();

            return response()->json([
                'success' => true,
                'message' => 'Mata pelajaran berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus mata pelajaran: ' . $e->getMessage()
            ], 500);
        }
    }
}
