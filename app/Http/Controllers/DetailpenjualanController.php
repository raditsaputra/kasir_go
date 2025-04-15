<?php

namespace App\Http\Controllers;

use App\DetailPenjualan;
use Illuminate\Http\Request;

class DetailPenjualanController extends Controller
{
    public function index()
    {
        $detailPenjualan = DetailPenjualan::all();
        return view('detail_penjualan.index', compact('detailPenjualan'));
    }

    public function create()
    {
        return view('detail_penjualan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|exists:penjualan,id',
            'produk_id' => 'required|exists:produk,id',
            'JumlahProduk' => 'required|integer',
            'Subtotal' => 'required|integer',
        ]);

        DetailPenjualan::create($request->all());

        return redirect()->route('detail_penjualan.index')->with('success', 'Detail Penjualan berhasil ditambahkan.');
    }

    public function show(DetailPenjualan $detailPenjualan)
    {
        return view('detail_penjualan.show', compact('detailPenjualan'));
    }

    public function edit(DetailPenjualan $detailPenjualan)
    {
        return view('detail_penjualan.edit', compact('detailPenjualan'));
    }

    public function update(Request $request, DetailPenjualan $detailPenjualan)
    {
        $request->validate([
            'penjualan_id' => 'required|exists:penjualan,id',
            'produk_id' => 'required|exists:produk,id',
            'JumlahProduk' => 'required|integer',
            'Subtotal' => 'required|integer',
        ]);

        $detailPenjualan->update($request->all());

        return redirect()->route('detail_penjualan.index')->with('success', 'Detail Penjualan berhasil diperbarui.');
    }

    public function destroy(DetailPenjualan $detailPenjualan)
    {
        $detailPenjualan->delete();
        return redirect()->route('detail_penjualan.index')->with('success', 'Detail Penjualan berhasil dihapus.');
    }

    private function createDetailPenjualan($penjualan, $produkIDs, $jumlahs)
    {
        foreach ($produkIDs as $key => $produkID) {
            $produk = Produk::findOrFail($produkID);

            // Pastikan stok cukup sebelum mengurangi
            if ($produk->stok < $jumlahs[$key]) {
                throw new \Exception("Stok untuk {$produk->nama_produk} tidak mencukupi.");
            }

            DetailPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $produkID,
                'jumlah' => $jumlahs[$key],
                'subtotal' => $produk->harga * $jumlahs[$key]
            ]);

            // Kurangi stok produk
            $produk->decrement('stok', $jumlahs[$key]);
        }
    }

}
