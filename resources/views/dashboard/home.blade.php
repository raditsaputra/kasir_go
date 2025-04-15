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
                     <h4>Rp 8,540,000</h4>
                     <p>Total Penjualan</p>
                 </div>
             </div>
             
             <div class="stats-card">
                 <div class="stats-icon">
                     <i class="fas fa-chart-line"></i>
                 </div>
                 <div class="stats-info">
                     <h4>124</h4>
                     <p>Total Transaksi</p>
                 </div>
             </div>
             
             <div class="stats-card">
                 <div class="stats-icon">
                     <i class="fas fa-users"></i>
                 </div>
                 <div class="stats-info">
                     <h4>45</h4>
                     <p>Pelanggan Baru</p>
                 </div>
             </div>
             
             <div class="stats-card">
                 <div class="stats-icon">
                     <i class="fas fa-box"></i>
                 </div>
                 <div class="stats-info">
                     <h4>156</h4>
                     <p>Produk Terjual</p>
                 </div>
             </div>
         </div>

         <!-- Recent Sales Card -->
         <div class="card">
             <div class="card-header d-flex justify-content-between align-items-center">
                 <span>Penjualan Terbaru</span>
                 <button class="btn-gold btn-sm">Lihat Semua</button>
             </div>
             <div class="card-body">
                 <div class="overflow-x-auto">
                     <table class="table-modern">
                         <thead>
                             <tr>
                                 <th>ID Transaksi</th>
                                 <th>Pelanggan</th>
                                 <th>Tanggal</th>
                                 <th>Status</th>
                                 <th>Total</th>
                                 <th>Aksi</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td>#INV-001</td>
                                 <td>Budi Santoso</td>
                                 <td>08 Apr 2025</td>
                                 <td><span class="badge-gold">Selesai</span></td>
                                 <td class="font-semibold">Rp 2,450,000</td>
                                 <td>
                                     <button class="btn btn-sm text-blue-500"><i class="fas fa-eye"></i></button>
                                     <button class="btn btn-sm text-green-500"><i class="fas fa-edit"></i></button>
                                 </td>
                             </tr>
                             <tr>
                                 <td>#INV-002</td>
                                 <td>Dewi Cahyani</td>
                                 <td>07 Apr 2025</td>
                                 <td><span class="badge-dark-blue">Proses</span></td>
                                 <td class="font-semibold">Rp 1,850,000</td>
                                 <td>
                                     <button class="btn btn-sm text-blue-500"><i class="fas fa-eye"></i></button>
                                     <button class="btn btn-sm text-green-500"><i class="fas fa-edit"></i></button>
                                 </td>
                             </tr>
                             <tr>
                                 <td>#INV-003</td>
                                 <td>Ahmad Fadli</td>
                                 <td>06 Apr 2025</td>
                                 <td><span class="badge-gold">Selesai</span></td>
                                 <td class="font-semibold">Rp 3,220,000</td>
                                 <td>
                                     <button class="btn btn-sm text-blue-500"><i class="fas fa-eye"></i></button>
                                     <button class="btn btn-sm text-green-500"><i class="fas fa-edit"></i></button>
                                 </td>
                             </tr>
                             <tr>
                                 <td>#INV-004</td>
                                 <td>Siti Aminah</td>
                                 <td>05 Apr 2025</td>
                                 <td><span class="badge-gold">Selesai</span></td>
                                 <td class="font-semibold">Rp 1,020,000</td>
                                 <td>
                                     <button class="btn btn-sm text-blue-500"><i class="fas fa-eye"></i></button>
                                     <button class="btn btn-sm text-green-500"><i class="fas fa-edit"></i></button>
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>

         <!-- Two-column layout -->
         <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
             <!-- Popular Products -->
             <div class="card">
                 <div class="card-header">
                     Produk Populer
                 </div>
                 <div class="card-body">
                     <div class="space-y-4">
                         <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                             <div class="w-12 h-12 rounded bg-gray-200 mr-4"></div>
                             <div class="flex-1">
                                 <h5 class="font-semibold">Sepatu Running Pro</h5>
                                 <div class="flex justify-between">
                                     <span class="text-sm text-gray-500">32 terjual</span>
                                     <span class="font-semibold gold-accent">Rp 1,250,000</span>
                                 </div>
                             </div>
                         </div>
                         
                         <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                             <div class="w-12 h-12 rounded bg-gray-200 mr-4"></div>
                             <div class="flex-1">
                                 <h5 class="font-semibold">Tas Ransel Premium</h5>
                                 <div class="flex justify-between">
                                     <span class="text-sm text-gray-500">28 terjual</span>
                                     <span class="font-semibold gold-accent">Rp 780,000</span>
                                 </div>
                             </div>
                         </div>
                         
                         <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                             <div class="w-12 h-12 rounded bg-gray-200 mr-4"></div>
                             <div class="flex-1">
                                 <h5 class="font-semibold">Headphone Bluetooth Elite</h5>
                                 <div class="flex justify-between">
                                     <span class="text-sm text-gray-500">24 terjual</span>
                                     <span class="font-semibold gold-accent">Rp 950,000</span>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             
             <!-- Recent Customers -->
             <div class="card">
                 <div class="card-header">
                     Pelanggan Terbaru
                 </div>
                 <div class="card-body">
                     <div class="space-y-4">
                         <div class="flex items-center">
                             <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4 text-blue-600 font-bold">
                                 RS
                             </div>
                             <div class="flex-1">
                                 <h5 class="font-semibold">Ratna Sari</h5>
                                 <p class="text-sm text-gray-500">ratna@example.com</p>
                             </div>
                             <span class="text-xs text-gray-500">5 menit yang lalu</span>
                         </div>
                         
                         <div class="flex items-center">
                             <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4 text-green-600 font-bold">
                                 DP
                             </div>
                             <div class="flex-1">
                                 <h5 class="font-semibold">Dimas Pratama</h5>
                                 <p class="text-sm text-gray-500">dimas@example.com</p>
                             </div>
                             <span class="text-xs text-gray-500">2 jam yang lalu</span>
                         </div>
                         
                         <div class="flex items-center">
                             <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-4 text-purple-600 font-bold">
                                 NK
                             </div>
                             <div class="flex-1">
                                 <h5 class="font-semibold">Nina Kartika</h5>
                                 <p class="text-sm text-gray-500">nina@example.com</p>
                             </div>
                             <span class="text-xs text-gray-500">1 hari yang lalu</span>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection