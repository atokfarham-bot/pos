<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Jenis; // 👈 1. Pastikan model Jenis di-import di sini

/**
 * @extends Factory<Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { 
        $hargaBeli = $this->faker->numberBetween(10_000, 500_000);
        
        return [
            'user_id' => User::where('role_id', 1)->inRandomOrder()->value('id'),
            
            // 💡 2. TAMBAHKAN BARIS INI untuk mengambil ID Jenis secara acak dari database
            'jenis_id' => Jenis::inRandomOrder()->value('id') ?? Jenis::factory(),
            
            'foto' => 'produk/' . $this->faker->uuid() . '.jpg',
            'nama' => $this->faker->words(3, true),
            'harga_Beli' => $hargaBeli,
            'harga_jual' => $hargaBeli + $this->faker->numberBetween(5_000,100_000),
            'stok' => $this->faker->numberBetween(1, 500),
        ];      
    }
}
