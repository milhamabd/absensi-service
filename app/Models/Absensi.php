<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_mahasiswa',
        'id_matakuliah',
        'status',
        'data_mahasiswa',  // ✅ diperbaiki dari 'data_mahasiwa'
        'data_matakuliah',
    ];

    protected $casts = [
        'data_mahasiswa' => 'array',
        'data_matakuliah' => 'array',
    ];
}
