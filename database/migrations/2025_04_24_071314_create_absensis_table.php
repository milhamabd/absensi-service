<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mahasiswa');
            $table->unsignedBigInteger('id_matakuliah');
            $table->string('status'); // hadir, sakit, izin, alpha
            $table->json('data_mahasiswa')->nullable(); // optional caching
            $table->json('data_matakuliah')->nullable(); // optional caching
            $table->timestamps();
        
            // Tambahkan index kalau ingin performa lebih baik
            $table->index('id_mahasiswa');
            $table->index('id_matakuliah');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};

