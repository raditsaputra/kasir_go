<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('produks', function (Blueprint $table) {
        $table->bigIncrements('produk_id');
        $table->string('nama_produk');
        $table->decimal('harga', 10, 2);
        $table->integer('stok');
        $table->string('gambar')->nullable();
        $table->enum('status', ['tersedia', 'habis'])->default('tersedia');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produks');
    }
}
