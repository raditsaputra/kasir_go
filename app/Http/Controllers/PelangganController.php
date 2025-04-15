<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pelanggan; // Import model pelanggan

class PelangganController extends Controller
{
    // Menampilkan semua data pelanggan
    public function index()
    {
        $pelanggans = pelanggan::all();
        return view('pelanggan.index', compact('pelanggans'));
    }

    // Menampilkan form untuk menambahkan pelanggan baru
    public function create()
    {
        return view('pelanggan.create');
    }

    // Menyimpan data pelanggan baru ke database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'required|string',
            'NomerTelpon' => 'required|string|max:15',
        ]);

        pelanggan::create($validatedData);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    // Menampilkan detail pelanggan berdasarkan ID
    public function show($id)
    {
        $pelanggan = pelanggan::findOrFail($id);
        return view('pelanggan.show', compact('pelanggan'));
    }

    // Menampilkan form untuk mengedit pelanggan
    public function edit($id)
    {
        $pelanggan = pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    // Memperbarui data pelanggan berdasarkan ID
    public function update(Request $request, $id)
{
    // Validate the request
    $validated = $request->validate([
        'NamaPelanggan' => 'required|string|max:255',
        'Alamat' => 'nullable|string',
        'NomerTelpon' => 'nullable|string|max:20',
    ]);
    
    // Find the pelanggan
    $pelanggan = Pelanggan::findOrFail($id);
    
    // Update the pelanggan
    $pelanggan->update($validated);
    
    // Check if the request is AJAX
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil diperbarui',
            'data' => $pelanggan
        ]);
    }
    
    // Redirect with success message
    return redirect()->route('pelanggan.index')
        ->with('success', 'Data pelanggan berhasil diperbarui');
}

    // Menghapus pelanggan berdasarkan ID
    public function destroy($id)
    {
        $pelanggan = pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function search(Request $request)
{
    $term = $request->input('term');
    
    $pelanggan = Pelanggan::where('nama', 'like', "%{$term}%")
                    ->orWhere('no_telp', 'like', "%{$term}%")
                    ->get();
    
    return response()->json($pelanggan);
}
}