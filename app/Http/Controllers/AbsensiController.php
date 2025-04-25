<?php

namespace App\Http\Controllers;

use App\Http\Resources\AbsensResource;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class AbsensiController extends Controller
{
    // Ambil data mahasiswa dan mata kuliah
    public function getMahasiswaMatakuliah()
    {
        try {
            $responseMahasiswa = Http::get('http://localhost:8000/api/mahasiswas');
            $responseMatkul = Http::get('http://localhost:8001/api/matakuliah');

            return response()->json([
                'status' => 'Success',
                'message' => 'Data berhasil diambil dari service lain',
                'data' => [
                    'mahasiswa' => $responseMahasiswa->json()['data'],
                    'matakuliah' => $responseMatkul->json()['data'],
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    // Ambil semua data absensi
    public function index()
    {
        $absensis = Absensi::all();
        return new AbsensResource($absensis, 'Success', 'List of student');
    }

    // Simpan data absensi baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_mahasiswa' => 'required|integer',
            'id_matakuliah' => 'required|integer',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return new AbsensResource(null, 'Failed', $validator->errors());
        }

        try {
            // Ambil data mahasiswa dari service mahasiswa
            $mahasiswa = Http::get("http://localhost:8000/api/mahasiswas/{$request->id_mahasiswa}");
            $matakuliah = Http::get("http://localhost:8001/api/matakuliah/{$request->id_matakuliah}");

            if (!$mahasiswa->successful() || !$matakuliah->successful()) {
                return new AbsensResource(null, 'Failed', 'Gagal mengambil data mahasiswa atau matakuliah');
            }

            $absensi = Absensi::create([
                'id_mahasiswa' => $request->id_mahasiswa,
                'id_matakuliah' => $request->id_matakuliah,
                'status' => $request->status,
                'data_mahasiswa' => $mahasiswa->json('data'),
                'data_matakuliah' => $matakuliah->json('data'),
            ]);

            return new AbsensResource($absensi, 'Success', 'Student created successfully');
        } catch (\Exception $e) {
            return new AbsensResource(null, 'Failed', $e->getMessage());
        }
    }

    // Ambil satu data absensi berdasarkan ID
    public function show($id)
    {
        $absensis = Absensi::find($id);

        if ($absensis) {
            return new AbsensResource($absensis, 'Success', 'Student found');
        } else {
            return new AbsensResource(null, 'Failed', 'Student not found');
        }
    }

    // Update data absensi
    public function update(Request $request, $id)
    {
        $absensis = Absensi::find($id);
    
        if (!$absensis) {
            return new AbsensResource(null, 'Failed', 'Student not found');
        }
    
        $validator = Validator::make($request->all(), [
            'id_mahasiswa' => 'required|integer',
            'id_matakuliah' => 'required|integer',
            'status' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return new AbsensResource(null, 'Failed', $validator->errors());
        }
    
        try {
            // Ambil ulang data dari microservice
            $mahasiswa = Http::get("http://localhost:8000/api/mahasiswas/{$request->id_mahasiswa}");
            $matakuliah = Http::get("http://localhost:8001/api/matakuliah/{$request->id_matakuliah}");
    
            if (!$mahasiswa->successful() || !$matakuliah->successful()) {
                return new AbsensResource(null, 'Failed', 'Gagal mengambil data mahasiswa atau matakuliah');
            }
    
            $absensis->update([
                'id_mahasiswa' => $request->id_mahasiswa,
                'id_matakuliah' => $request->id_matakuliah,
                'status' => $request->status,
                'data_mahasiswa' => $mahasiswa->json('data'),
                'data_matakuliah' => $matakuliah->json('data'),
            ]);
    
            return new AbsensResource($absensis, 'Success', 'Student updated successfully');
        } catch (\Exception $e) {
            return new AbsensResource(null, 'Failed', $e->getMessage());
        }
    }
    

    // Hapus data absensi
    public function destroy($id)
    {
        $absensis = Absensi::find($id);

        if (!$absensis) {
            return new AbsensResource(null, 'Failed', 'Student not found');
        }

        $absensis->delete();

        return new AbsensResource(null, 'Success', 'Student deleted successfully');
    }

    // Menambahkan mahasiswa dari absensi
    public function createMahasiswaDariAbsensi(Request $request)
    {
        $response = Http::post('http://localhost:8000/api/mahasiswas', [
            'nama' => $request->nama,
            'email' => $request->email,
            'npm' => $request->npm
        ]);

        if ($response->successful()) {
            return response()->json([
                'status' => 'Success',
                'data' => $response->json()
            ]);
        }

        return response()->json([
            'status' => 'Failed',
            'message' => 'Gagal membuat mahasiswa',
            'data' => null
        ], 500);
    }

    // Update mahasiswa dari absensi
    public function updateMahasiswaDariAbsensi(Request $request, $id)
    {
        $response = Http::put("http://localhost:8000/api/mahasiswas/{$id}", [
            'nama' => $request->nama,
            'email' => $request->email,
            'npm' => $request->npm
        ]);

        if ($response->successful()) {
            return response()->json([
                'status' => 'Success',
                'data' => $response->json()
            ]);
        }

        return response()->json([
            'status' => 'Failed',
            'message' => 'Gagal memperbarui mahasiswa',
            'data' => null
        ], 500);
    }

    // Hapus mahasiswa dari absensi
    public function deleteMahasiswaDariAbsensi($id)
    {
        $response = Http::delete("http://localhost:8000/api/mahasiswas/{$id}");

        if ($response->successful()) {
            return response()->json([
                'status' => 'Success',
                'message' => 'Mahasiswa berhasil dihapus'
            ]);
        }

        return response()->json([
            'status' => 'Failed',
            'message' => 'Gagal menghapus mahasiswa',
            'data' => null
        ], 500);
    }
}
