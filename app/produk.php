<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';
    protected $primaryKey = 'produk_id';
    
    protected $fillable = [
        'nama_produk',
        'harga',
        'stok',
        'gambar',
        'status'
    ];

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'produk_id');
    }

    protected static function booted()
    {
        // Event "saving" dipicu setiap kali model akan disimpan ke database
        static::saving(function ($produk) {
            // Atur status otomatis berdasarkan stok
            $produk->status = $produk->stok > 0 ? 'tersedia' : 'habis';
        });
    }

}
