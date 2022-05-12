<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriHargaJualProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_harga_jual_produks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('produk_id')->references('id')->on('produks')->onDelete('cascade');
            $table->string('kategori_harga_jual_id')->references('id')->on('kategori_harga_juals')->onDelete('cascade');

            $table->integer('harga_jual')->default(0)->nullable();
            $table->integer('diskon')->default(0)->nullable();

            //SETTING THE PRIMARY KEYS
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
        Schema::dropIfExists('kategori_harga_jual_produks');
    }
}
