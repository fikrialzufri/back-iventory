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
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('slug');
            $table->string('thumdnail')->nullable();
            $table->integer('stok_awal')->default(0)->nullable();
            $table->integer('harga_beli')->default(0)->nullable();
            $table->string('kategori_id')->references('id')->on('kategoris');
            $table->string('jenis_id')->references('id')->on('jenis');
            $table->string('merek_id')->references('id')->on('mereks');
            $table->string('ukuran_id')->references('id')->on('ukurans');
            $table->string('warna_id')->references('id')->on('warnas');
            $table->string('satuan_id')->references('id')->on('satuans');
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
