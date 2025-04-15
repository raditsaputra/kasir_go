@extends('layout.app')

@section('content')
<div class="main-content ">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Laporan Penjualan</h4>
                </div>
                <div class="card-body">
                    <!-- Filter Bulan -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form action="{{ route('penjualan.laporan') }}" method="GET" class="form-inline">
                                <div class="input-group">
                                    <label class="mr-2">Filter Bulan:</label>
                                    <input type="month" name="bulan" class="form-control" value="{{ $bulan }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('penjualan.cetak-laporan', ['bulan' => $bulan]) }}" class="btn btn-success">
                                <i class="fa fa-print"></i> Cetak Laporan
                            </a>
                        </div>
                    </div>

                    <!-- Informasi Laporan -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <strong>Laporan Penjualan: {{ $bulanLabel }}</strong>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <p>Total Transaksi: {{ $jumlahTransaksi }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Total Penjualan: Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Laporan -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
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
                                    <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data penjualan pada bulan ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection