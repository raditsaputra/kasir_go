<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'penjualan_id';
    
    protected $fillable = [
        'kode_transaksi',
        'tanggal_penjualan',
        'Peran',
        'total_harga',
        'uang_bayar',
        'uang_kembali',
        'PelangganID'
    ];
    
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id', 'penjualan_id');
    }

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'penjualan_id', 'penjualan_id');
    }

}   