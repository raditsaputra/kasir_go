<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Penjualan {{ $penjualan->kode_transaksi }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .receipt {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 14px;
            margin-bottom: 5px;
        }
        .info {
            margin-bottom: 15px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th, table td {
            padding: 5px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .item-price, .item-total {
            text-align: right;
        }
        .totals {
            margin-top: 10px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .grand-total {
            font-weight: bold;
            font-size: 14px;
            margin-top: 5px;
            border-top: 1px double #000;
            padding-top: 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div class="title">Gold Sales</div>
            <div class="subtitle">Struk Penjualan</div>
            <div>Jl. Merdeka No. 45, Jakarta</div>
            <div>Telp: 0812-3456-7890</div>
        </div>
        
        <div class="info">
            <div class="info-row">
                <span>No. Transaksi:</span>
                <span>{{ $penjualan->kode_transaksi }}</span>
            </div>
            <div class="info-row">
                <span>Tanggal:</span>
                <span>{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span>Kasir:</span>
                <span>Admin</span>
            </div>
            <div class="info-row">
                <span>Tipe Pelanggan:</span>
                <span>{{ $penjualan->Peran }}</span>
            </div>
            @if($penjualan->PelangganID)
            <div class="info-row">
                <span>ID Pelanggan:</span>
                <span>{{ $penjualan->PelangganID }}</span>
            </div>
            @endif
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th class="item-price">Harga</th>
                    <th class="item-total">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->detailPenjualan as $detail)
                <tr>
                    <td>{{ optional($detail->produk)->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                    <td>{{ $detail->JumlahProduk }}</td>
                    <td class="item-price">Rp {{ number_format(optional($detail->produk)->harga ?? 0, 0, ',', '.') }}</td>
                    <td class="item-total">Rp {{ number_format($detail->Subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="totals">
            <div class="total-row">
                <span>Total:</span>
                <span>Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Tunai:</span>
                <span>Rp {{ number_format($penjualan->uang_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Kembali:</span>
                <span>Rp {{ number_format($penjualan->uang_kembali, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div class="footer">
            <p>Terima kasih telah berbelanja di Toko Gold Sales</p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
        </div>
    </div>
</body>
</html>