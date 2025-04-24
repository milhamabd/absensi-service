<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AbsensiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_mahasiswa' => $this->faker->numberBetween(1, 10), // ganti sesuai jumlah data mahasiswa di DB kamu
            'id_matakuliah' => $this->faker->numberBetween(1, 7), // ganti sesuai jumlah data matakuliah
            'status' => $this->faker->randomElement(['hadir', 'izin', 'sakit', 'alpha']),
            'data_mahasiswa' => json_encode([
                'name' => $this->faker->name(),
                'nim' => $this->faker->unique()->randomNumber(8),
            ]),
            'data_matakuliah' => json_encode([
                'nama_matkul' => $this->faker->randomElement(['Pemrograman Dasar', 'Struktur Data', 'Basis Data', 'Jaringan Komputer', 'Sistem Operasi', 'Kecerdasan Buatan', 'Pemrograman Web']),
                'dosen' => $this->faker->name,
            ]),
        ];
    }
}
