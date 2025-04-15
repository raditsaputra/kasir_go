<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->bigIncrements('penjualan_id');
            $table->string('kode_transaksi');
            $table->datetime('tanggal_penjualan');
            $table->string('Peran', 255);
            $table->integer('total_harga');
            $table->integer('uang_bayar');
            $table->integer('uang_kembali')->nullable();
            $table->integer('PelangganID')->nullable();;
            $table->timestamps();
        });
    }

    /**a
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}
