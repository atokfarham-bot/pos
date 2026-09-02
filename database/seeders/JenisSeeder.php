<?php

namespace Database\Seeders;

use App\Models\Jenis;
use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $daftarJenis = [
        ['nama_jenis' => 'Makanan'], // 👈 Ganti sesuai nama kolom di migrasi
        ['nama_jenis' => 'Minuman'],
        ['nama_jenis' => 'Cemilan'],
        ['nama_jenis' => 'Sembako'],
        ['nama_jenis' => 'Atk'],
    ];

    foreach ($daftarJenis as $jenis) {
        \App\Models\Jenis::create($jenis);
    }
}

}
