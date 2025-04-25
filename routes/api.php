<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;

Route::get('/ambil-data', [AbsensiController::class, 'getMahasiswaMatakuliah']);

Route::apiResource('absensi', AbsensiController::class);

//bagian menghapus data mahasiwa
Route::delete('/students/{id}', [AbsensiController::class, 'destroy']);

Route::put('/absensi/{id}', [AbsensiController::class, 'update']);
