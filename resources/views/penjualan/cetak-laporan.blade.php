<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan {{ $bulanLabel }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 5px;
        }
        table th {
            background-color: #f0f0f0;
        }
        .summary {
            margin-top: 20px;
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN PENJUALAN</div>
        <div class="subtitle">Periode: {{ $bulanLabel }}</div>
    </div>
    
    <div class="info">
        <table border="0">
            <tr>
                <td width="40%">Tanggal Cetak</td>
                <td>: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</td>
            </tr>
            <tr>
                <td>Total Transaksi</td>
                <td>: {{ $jumlahTransaksi }}</td>
            </tr>
            <tr>
                <td>Total Penjualan</td>
                <td>: Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Transaksi</th>
                <th>Peran</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penjualan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_penjualan)->format('d-m-Y') }}</td>
                <td>{{ $item->kode_transaksi }}</td>
                <td>{{ $item->Peran }}</td>
                <td style="text-align: right;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data penjualan pada bulan ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="summary">
        <p><strong>Total Penjualan: Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</strong></p>
    </div>
    
    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</p>
    </div>
</body>
</html>