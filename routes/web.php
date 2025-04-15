<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');





//produk
Route::get('/produk', 'ProdukController@index')->name('produk.index');
Route::get('/produk/create', 'ProdukController@create')->name('produk.create');
Route::post('/produk', 'ProdukController@store')->name('produk.store');
Route::get('/produk/{id}', 'ProdukController@show')->name('produk.show');
Route::get('/produk/{produk}/edit', 'ProdukController@edit')->name('produk.edit');
Route::put('/produk/{produk}', 'ProdukController@update')->name('produk.update');
Route::delete('/produk/{produk}', 'ProdukController@destroy')->name('produk.destroy');


//penjualan
Route::get('/penjualan', 'PenjualanController@index')->name('penjualan.index');
Route::get('/penjualan/create', 'PenjualanController@create')->name('penjualan.create');
Route::post('/penjualan', 'PenjualanController@store')->name('penjualan.store');
Route::get('/penjualan/{id}', 'PenjualanController@show')->name('penjualan.show');
Route::get('/penjualan/{penjualan}/edit', 'PenjualanController@edit')->name('penjualan.edit');
Route::put('/penjualan/{penjualan}', 'PenjualanController@update')->name('penjualan.update');
Route::delete('/penjualan/{penjualan}', 'PenjualanController@destroy')->name('penjualan.destroy');

//login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//pelanggan 
Route::get('pelanggan', 'PelangganController@index')->name('pelanggan.index');
Route::get('pelanggan/create', 'PelangganController@create')->name('pelanggan.create');
Route::post('pelanggan', 'PelangganController@store')->name('pelanggan.store');
Route::get('pelanggan/{id}', 'PelangganController@show')->name('pelanggan.show');
Route::get('pelanggan/{id}/edit', 'PelangganController@edit')->name('pelanggan.edit');
Route::put('pelanggan/{id}', 'PelangganController@update')->name('pelanggan.update');
Route::delete('pelanggan/{id}', 'PelangganController@destroy')->name('pelanggan.destroy');


//detail
Route::get('detail_penjualan', 'DetailPenjualanController@index')->name('detail_penjualan.index');
Route::get('detail_penjualan/create', 'DetailPenjualanController@create')->name('detail_penjualan.create');
Route::post('detail_penjualan', 'DetailPenjualanController@store')->name('detail_penjualan.store');
Route::get('detail_penjualan/{DetailID}', 'DetailPenjualanController@show')->name('detail_penjualan.show');
Route::get('detail_penjualan/{DetailID}/edit', 'DetailPenjualanController@edit')->name('detail_penjualan.edit');
Route::put('detail_penjualan/{DetailID}', 'DetailPenjualanController@update')->name('detail_penjualan.update');
Route::delete('detail_penjualan/{DetailID}', 'DetailPenjualanController@destroy')->name('detail_penjualan.destroy');


Route::middleware(['auth'])->group(function () {
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
});

Route::get('penjualan/{id}/pdf', 'PenjualanController@generatePDF')->name('penjualan.pdf');
Route::get('penjualan/{id}/download-pdf', 'PenjualanController@downloadPDF')->name('penjualan.downloadPdf');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/laporan-penjualan', [PenjualanController::class, 'laporan'])->name('penjualan.laporan');
Route::get('/cetak-laporan-penjualan', [PenjualanController::class, 'cetakLaporan'])->name('penjualan.cetak-laporan');

Route::get('/pelanggan/search', 'PelangganController@search')->name('pelanggan.search');
