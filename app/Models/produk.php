<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Ucapkan selamat tinggal pada 'class produk' -> ubah jadi 'class Produk' (Standar Laravel)
class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    
    protected $fillable = [
        'user_id',
        'foto',
        'nama',
        'harga_beli',
        'harga_jual',
        'stok'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Ubah nama method jadi camelCase (i kecil) agar sesuai dengan controller
    public function itemPenjualan()
    {
        return $this->hasMany(ItemPenjualan::class, 'produk_id');
    }
}