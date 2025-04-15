@extends('layout.app')
@section('content')


<div class="main-content">
     

     <!-- Content Area -->
     <div class="content-area">
         <div class="mb-6">
             <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
             <p class="text-gray-500">Selamat datang kembali, lihat ringkasan penjualan Anda!</p>
         </div>

         <!-- Stats Cards -->
         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
         <div class="stats-card">
        <div class="stats-icon">
            <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stats-info">
                <h4>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h4>
                <p>Total Penjualan</p>
            </div>
        </div>
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stats-info">
                <h4>{{ $jumlahTransaksi }}</h4>
                <p>Total Transaksi</p>
            </div>
        </div>
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-info">
                <h4>{{ $jumlahPelanggan }}</h4>
                <p>Pelanggan Baru</p>
            </div>
        </div>
        <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stats-info">
                    <h4>{{ $jumlahProduk }}</h4>
                    <p>Jumlah Produk</p>
                </div>
            </div>
         </div>

         <!-- Recent Sales Card -->
         <div class="card">
             <div class="card-header d-flex justify-content-between align-items-center">
                 <span>Penjualan Terbaru</span>
                 <a href="{{ route('penjualan.index') }}" class="btn-gold btn-sm">Lihat Semua</a>
             </div>
             <div class="card-body">
                 <div class="overflow-x-auto">
                     <table class="table-modern">
                         <thead>
                             <tr>
                                 <th>ID Transaksi</th>
                                 <th>Peran</th>
                                 <th>Tanggal</th>
                                 <th>Total</th>
                                 <th>Lihat</th>
                             </tr>
                         </thead>
                         <tbody>
                            @foreach($penjualanTerbaru as $penjualan)
                                <tr>
                                    <td>#{{ $penjualan->kode_transaksi }}</td>
                                    <td>{{ $penjualan->Peran }}</td>
                                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d M Y') }}</td>
                                    <td class="font-semibold">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('penjualan.index') }}" class="btn-gold btn-sm"><i class="fas fa-eye"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                     </table>
                 </div>
             </div>
         </div>

         <!-- Two-column layout -->
         <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
             <!-- Popular Products -->
             <!-- Recent Customers -->
             <div class="card">
    <div class="card-header bg-blue-900 text-white font-semibold rounded-t-md px-4 py-2">
        Pelanggan Terbaru
    </div>
    <div class="card-body bg-white rounded-b-md p-4">
        <div class="space-y-4">
            @forelse($pelangganTerbaru as $pelanggan)
                <div class="flex items-center">
                @php
                    $initials = collect(explode(' ', $pelanggan->NamaPelanggan))->map(function($w) {
                        return strtoupper(substr($w, 0, 1));
                    })->join('');

                    $colors = ['bg-blue-100 text-blue-600', 'bg-green-100 text-green-600', 'bg-purple-100 text-purple-600'];
                    $colorClass = $colors[$loop->index % count($colors)];
                @endphp


                    <div class="w-10 h-10 rounded-full {{ $colorClass }} flex items-center justify-center mr-4 font-bold">
                        {{ $initials }}
                    </div>

                    <div class="flex-1">
                        <h5 class="font-semibold">{{ $pelanggan->NamaPelanggan }}</h5>
                        <p class="text-sm text-gray-500">{{ $pelanggan->NomerTelpon ?? '-' }}</p>
                    </div>

                    <span class="text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($pelanggan->created_at)->diffForHumans() }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500">Belum ada pelanggan.</p>
            @endforelse
        </div>
    </div>
</div>


 @endsection