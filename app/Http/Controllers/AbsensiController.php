<?php

namespace App\Http\Controllers;

use App\Http\Resources\AbsensResource;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Resources\AbsensResourceResource;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    // Ambil semua data absensi
    public function index()
    {
        $absensis = Absensi::all();
        return new AbsensResource ($absensis, 'Success', 'List of student');
    }

    // Simpan data absensi baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_mahasiswa' => 'required|integer',
            'id_matakuliah' => 'required|integer',
            'status' => 'required|string',
            'data_mahasiswa' => 'nullable|array',
            'data_matakuliah' => 'nullable|array',

        ]);

        if ($validator->fails()) {
            // Mengembalikan error jika validasi gagal, dengan 'data' = null
            return new AbsensResource(null, 'Failed', $validator->errors());
        }

        // Jika validasi sukses, buat siswa baru
        $absensis = Absensi::create($request->all());
        // Mengembalikan respons sukses dengan data siswa yang baru dibuat
        return new AbsensResource($absensis, 'Success', 'Student created successfully');
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
        // Cari data siswa berdasarkan ID
        $absensis = Absensi::find($id);

        // Jika siswa tidak ditemukan, kembalikan response error
        if (!$absensis) {
            return new AbsensResource(null, 'Failed', 'Student not found');
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_mahasiswa' => 'required|integer',
            'id_matakuliah' => 'required|integer',
            'status' => 'required|string',
            'data_mahasiswa' => 'nullable|json',
            'data_matakuliah' => 'nullable|json',
        ]);

        // Jika validasi gagal, kembalikan response error
        if ($validator->fails()) {
            return new AbsensResource(null, 'Failed', $validator->errors());
        }

        // Update data siswa
        $absensis->update($request->all());

        // Kembalikan response sukses dengan data terbaru
        return new AbsensResource($absensis, 'Success', 'Student updated successfully');
    }

    // Hapus data absensi
    public function destroy($id)
    {
        // Cari siswa berdasarkan ID
        $absensis = Absensi::find($id);

        // Jika siswa tidak ditemukan, kembalikan response error
        if (!$absensis) {
            return new AbsensResource(null, 'Failed', 'Student not found');
        }

        // Hapus data siswa
        $absensis->delete();

        // Kembalikan response sukses
        return new AbsensResource(null, 'Success', 'Student deleted successfully');
    }
}
