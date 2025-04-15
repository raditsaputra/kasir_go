<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'DetailID';
    
    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'JumlahProduk',
        'Subtotal'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'penjualan_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($detail) {
            $produk = Produk::find($detail->produk_id);
            if ($produk) {
                if ($produk->stok < $detail->jumlah) {
                    throw new \Exception("Stok produk {$produk->nama_produk} tidak mencukupi.");
                }
                $produk->stok -= $detail->jumlah;
                $produk->save();
            }
        });

        static::deleted(function ($detail) {
            // Mengembalikan stok jika data dihapus
            $produk = Produk::find($detail->produk_id);
            if ($produk) {
                $produk->stok += $detail->jumlah;
                $produk->save();
            }
        });
    }
}



