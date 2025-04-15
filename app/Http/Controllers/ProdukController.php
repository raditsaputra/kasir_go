<?php

namespace App\Http\Controllers;

use App\produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $produks = Produk::all(); // Mengambil semua produk
        return view('produk.index', compact('produks')); // Menampilkan view dengan data produk
    }

    // Menampilkan form untuk membuat produk baru
    public function create()
    {
        return view('produk.create'); // Menampilkan form input produk
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
{
    $validated = $request->validate([
        'nama_produk' => 'required|max:255',
        'harga' => 'required|numeric',
        'stok' => 'required|integer',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $produk = new Produk();
    $produk->fill($validated);
    
    // Set status otomatis berdasarkan stok
    $produk->status = $request->stok > 0 ? 'tersedia' : 'habis';

    if ($request->hasFile('gambar')) {
        $path = $request->file('gambar')->store('produk_images', 'public');
        $produk->gambar = $path;
    }

    $produk->save();

    return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
}



    // Menampilkan form untuk mengedit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id); // Menemukan produk berdasarkan ID
        return view('produk.edit', compact('produk')); // Menampilkan form edit dengan data produk
    }

    // Menyimpan perubahan produk
    public function update(Request $request, $id)
{
    $produk = Produk::findOrFail($id);

    $validated = $request->validate([
        'nama_produk' => 'required|max:255',
        'harga' => 'required|numeric',
        'stok' => 'required|integer',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $produk->fill($validated);
    
    // Set status otomatis berdasarkan stok
    $produk->status = $request->stok > 0 ? 'tersedia' : 'habis';

    if ($request->hasFile('gambar')) {
        $path = $request->file('gambar')->store('produk_images', 'public');
        $produk->gambar = $path;
    }

    $produk->save();

    return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
}

    // Menghapus produk
    // Menghapus produk
public function destroy($id)
{
    try {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    } catch (\Illuminate\Database\QueryException $e) {
        // Check if it's a foreign key constraint error
        if ($e->getCode() == 23000) {
            return redirect()->route('produk.index')
                ->with('error', 'Produk tidak dapat dihapus karena masih terdapat dalam data penjualan.');
        }
        
        throw $e;
    }
}
    
    public function downloadPDF($id)
{
    $penjualan = Penjualan::with(['detailPenjualan.produk'])->findOrFail($id);
    
    $pdf = PDF::loadView('penjualan.receipt', compact('penjualan'));
    
    return $pdf->download('struk-penjualan-' . $penjualan->penjualan_id . '.pdf');
}
}
