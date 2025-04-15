<?php

namespace App\Http\Controllers;

use App\produk; // pastikan ini di atas
use App\pelanggan; // pastikan ini di atas
use App\penjualan; // pastikan ini di atas
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totalPenjualan = Penjualan::sum('total_harga');
    $jumlahTransaksi = Penjualan::count();
    $jumlahPelanggan = Pelanggan::count();
    $jumlahProduk = Produk::count();
    $pelangganTerbaru = Pelanggan::latest()->take(5)->get();
    $pelanggans = Pelanggan::all();    
    $penjualanTerbaru = Penjualan::with('pelanggan')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

    return view('home', compact(
        'totalPenjualan',
        'jumlahTransaksi',
        'jumlahPelanggan',
        'jumlahProduk',
        'penjualanTerbaru',
        'pelangganTerbaru',
        'pelanggans'
    ));
        
        // Mengambil 5 transaksi terbaru
        $transaksiTerbaru = penjualan::with('detailPenjualan.produk')
                            ->orderBy('tanggal_penjualan', 'desc')
                            ->take(5)
                            ->get();

        return view('home', compact('jumlahProduk', 'jumlahPenjualan', 'jumlahPelanggan', 'transaksiTerbaru'));
    }
}