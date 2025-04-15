<?php

namespace App\Http\Controllers;

use App\Penjualan;
use App\DetailPenjualan;
use App\Produk;
use App\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function index(Request $request)
{
    // Ambil keyword dari input search
    $search = $request->input('search');

    // Query penjualan dengan relasi
    $penjualan = Penjualan::with(['detailPenjualan.produk', 'pelanggan'])
        ->when($search, function ($query, $search) {
            return $query->where('kode_transaksi', 'like', '%' . $search . '%');
        })
        ->latest()
        ->get();

    $produk = Produk::all();
    $pelanggan = Pelanggan::select('PelangganID', 'NamaPelanggan', 'NomerTelpon')->get();

    return view('penjualan.index', compact('penjualan', 'produk', 'pelanggan', 'search'));
}

    
    public function create()
    {
        $produk = Produk::all();
        
        // Include NoTelp field in the query
        $pelanggan = Pelanggan::select('PelangganID', 'NamaPelanggan', 'NomerTelpon')->get();
        
        return view('penjualan.create', compact('produk', 'pelanggan'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'tanggal_penjualan' => 'required|date',
                'Peran' => 'required|in:Pelanggan,Member',
                'produk' => 'required|array|min:1',
                'produk.*' => 'required|exists:produks,produk_id',
                'jumlah_produk' => 'required|array|min:1',
                'jumlah_produk.*' => 'required|integer|min:1',
                'total_harga_numeric' => 'required|numeric|min:0',
                'uang_bayar' => 'required|numeric|min:0',
                'uang_kembali_numeric' => 'required|numeric|min:0',
                'PelangganID' => 'nullable|required_if:Peran,Member|integer'
            ]);

            DB::beginTransaction();

            // Generate transaction code
            $tanggal = Carbon::now()->format('Ymd');
            $latestPenjualan = Penjualan::whereDate('created_at', Carbon::today())->latest()->first();
            
            if ($latestPenjualan) {
                $lastCode = $latestPenjualan->kode_transaksi;
                $lastNumber = intval(substr($lastCode, -4));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            
            $kodeTransaksi = 'TRX-' . $tanggal . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            // Simpan data penjualan
            $penjualan = Penjualan::create([
                'kode_transaksi' => $kodeTransaksi,
                'tanggal_penjualan' => $request->tanggal_penjualan,
                'Peran' => $request->Peran,
                'total_harga' => $request->total_harga_numeric,
                'uang_bayar' => $request->uang_bayar,
                'uang_kembali' => $request->uang_kembali_numeric,
                'PelangganID' => $request->filled('PelangganID') ? $request->PelangganID : null
            ]);

            // Simpan detail penjualan
            foreach ($request->produk as $index => $produk_id) {
                $jumlah = $request->jumlah_produk[$index];

                // Pastikan stok cukup sebelum menyimpan
                $produk = Produk::findOrFail($produk_id);
                if ($produk->stok < $jumlah) {
                    throw new \Exception("Stok produk {$produk->nama_produk} tidak mencukupi.");
                }

                // Hitung subtotal untuk produk ini
                $subtotal = $produk->harga * $jumlah;

                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'produk_id' => $produk_id,
                    'JumlahProduk' => $jumlah,
                    'Subtotal' => $subtotal
                ]);

                // Update stock
                $produk->stok -= $jumlah;
                $produk->save();
            }

            DB::commit();

            // Redirect with flash message
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil disimpan.');

        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['detailPenjualan.produk'])->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    public function edit($id)
{
    $penjualan = Penjualan::with(['detailPenjualan.produk', 'pelanggan'])->findOrFail($id);
    $produk = Produk::all();
    $pelanggan = Pelanggan::select('PelangganID', 'NamaPelanggan', 'NomerTelpon')->get();
    
    return view('penjualan.edit', compact('penjualan', 'produk', 'pelanggan'));
}

public function update(Request $request, $id)
{
    try {
        $request->validate([
            'tanggal_penjualan' => 'required|date',
            'Peran' => 'required|in:Pelanggan,Member',
            'produk' => 'required|array|min:1',
            'produk.*' => 'required|exists:produks,produk_id',
            'jumlah_produk' => 'required|array|min:1',
            'jumlah_produk.*' => 'required|integer|min:1',
            'total_harga_numeric' => 'required|numeric|min:0',
            'uang_bayar' => 'required|numeric|min:0',
            'uang_kembali_numeric' => 'required|numeric|min:0',
            'PelangganID' => 'nullable|required_if:Peran,Member|integer'
        ]);

        DB::beginTransaction();

        $penjualan = Penjualan::with('detailPenjualan.produk')->findOrFail($id);
        
        // Store old details to restore stock later
        $oldDetails = $penjualan->detailPenjualan->keyBy('produk_id');
        
        // Update penjualan
        $penjualan->update([
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'Peran' => $request->Peran,
            'total_harga' => $request->total_harga_numeric,
            'uang_bayar' => $request->uang_bayar,
            'uang_kembali' => $request->uang_kembali_numeric,
            'PelangganID' => $request->filled('PelangganID') ? $request->PelangganID : null
        ]);

        // First, restore the old quantities to stock
        foreach ($oldDetails as $detail) {
            $produk = Produk::findOrFail($detail->produk_id);
            $produk->stok += $detail->JumlahProduk;
            $produk->save();
        }
        
        // Delete existing detail penjualan
        $penjualan->detailPenjualan()->delete();

        // Create new detail penjualan and deduct stock
        foreach ($request->produk as $index => $produkId) {
            $produk = Produk::findOrFail($produkId);
            $jumlah = $request->jumlah_produk[$index];
            
            // Check if stock is sufficient
            if ($produk->stok < $jumlah) {
                throw new \Exception("Stok produk {$produk->nama_produk} tidak mencukupi.");
            }
            
            $subtotal = $produk->harga * $jumlah;

            DetailPenjualan::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'produk_id' => $produkId,
                'JumlahProduk' => $jumlah,
                'Subtotal' => $subtotal
            ]);
            
            // Reduce stock
            $produk->stok -= $jumlah;
            $produk->save();
        }

        DB::commit();

        return redirect()->route('penjualan.index')
                       ->with('success', 'Penjualan berhasil diupdate');

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollback();
        return redirect()->back()
                       ->withErrors($e->errors())
                       ->withInput();
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()
                       ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                       ->withInput();
    }
}

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $penjualan = Penjualan::findOrFail($id);
            $penjualan->detailPenjualan()->delete();
            $penjualan->delete();
            
            DB::commit();
            
            return redirect()->route('penjualan.index')
                           ->with('success', 'Penjualan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }

    public function generatePDF($id)
    {
        $penjualan = Penjualan::with(['detailPenjualan.produk'])->findOrFail($id);
        
        $pdf = PDF::loadView('penjualan.receipt', compact('penjualan'));
        
        // Stream the PDF to browser instead of downloading
        return $pdf->stream('struk-penjualan-' . $penjualan->penjualan_id . '.pdf');
    }

    public function downloadPDF($id)
    {
        $penjualan = Penjualan::with(['detailPenjualan.produk'])->findOrFail($id);
        
        $pdf = PDF::loadView('penjualan.receipt', compact('penjualan'));
        
        return $pdf->download('struk-penjualan-' . $penjualan->penjualan_id . '.pdf');
    }


    public function laporan(Request $request)
{
    // Set default bulan ke bulan sekarang jika tidak ada filter
    $bulan = $request->input('bulan') ?? Carbon::now()->format('Y-m');
    
    // Parsing tanggal dari input filter
    $tanggalAwal = Carbon::parse($bulan . '-01')->startOfMonth();
    $tanggalAkhir = Carbon::parse($bulan . '-01')->endOfMonth();
    
    // Query penjualan berdasarkan rentang tanggal
    $penjualan = Penjualan::with(['detailPenjualan.produk', 'pelanggan'])
        ->whereBetween('tanggal_penjualan', [$tanggalAwal, $tanggalAkhir])
        ->latest()
        ->get();
    
    // Hitung total penjualan dalam bulan tersebut
    $totalPenjualan = $penjualan->sum('total_harga');
    
    // Hitung jumlah transaksi
    $jumlahTransaksi = $penjualan->count();
    
    // Format bulan untuk ditampilkan di view
    $bulanLabel = Carbon::parse($bulan . '-01')->format('F Y');
    
    return view('penjualan.laporan', compact(
        'penjualan', 
        'bulan', 
        'bulanLabel', 
        'totalPenjualan', 
        'jumlahTransaksi'
    ));
}

public function cetakLaporan(Request $request)
{
    // Set default bulan ke bulan sekarang jika tidak ada filter
    $bulan = $request->input('bulan') ?? Carbon::now()->format('Y-m');
    
    // Parsing tanggal dari input filter
    $tanggalAwal = Carbon::parse($bulan . '-01')->startOfMonth();
    $tanggalAkhir = Carbon::parse($bulan . '-01')->endOfMonth();
    
    // Query penjualan berdasarkan rentang tanggal
    $penjualan = Penjualan::with(['detailPenjualan.produk', 'pelanggan'])
        ->whereBetween('tanggal_penjualan', [$tanggalAwal, $tanggalAkhir])
        ->latest()
        ->get();
    
    // Hitung total penjualan dalam bulan tersebut
    $totalPenjualan = $penjualan->sum('total_harga');
    
    // Hitung jumlah transaksi
    $jumlahTransaksi = $penjualan->count();
    
    // Format bulan untuk ditampilkan di view
    $bulanLabel = Carbon::parse($bulan . '-01')->format('F Y');
    
    $pdf = PDF::loadView('penjualan.cetak-laporan', compact(
        'penjualan', 
        'bulan', 
        'bulanLabel', 
        'totalPenjualan', 
        'jumlahTransaksi'
    ));
    
    // Download PDF
    return $pdf->download('laporan-penjualan-' . $bulan . '.pdf');
}
}

