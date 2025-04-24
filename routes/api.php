<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;

Route::apiResource('absensi', AbsensiController::class);
//bagian menghapus data mahasiwa
Route::delete('/students/{id}', [AbsensiController::class, 'destroy']);
