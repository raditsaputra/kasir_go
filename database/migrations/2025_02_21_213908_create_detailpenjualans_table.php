<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailpenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->bigIncrements('DetailID');
            $table->unsignedBigInteger('penjualan_id');  // Ubah ke unsignedBigInteger
            $table->unsignedBigInteger('produk_id');     // Ubah ke unsignedBigInteger
            $table->integer('JumlahProduk');
            $table->integer('Subtotal');
            $table->timestamps();
            
            // Tambahkan foreign key
            $table->foreign('produk_id')->references('produk_id')->on('produks');
            $table->foreign('penjualan_id')->references('penjualan_id')->on('penjualan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailpenjualans');
    }
}
