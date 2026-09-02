<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            JenisSeeder::class,
            ProdukSeeder::class,
            PenjualanSeeder::class,
        ]);

        // 💡 HAPUS ATAU BERI KOMENTAR PADA BARIS DI BAWAH INI AGAR TIDAK DUPLIKAT:
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
