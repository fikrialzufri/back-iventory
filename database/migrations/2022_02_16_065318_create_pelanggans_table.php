<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("nama", 30);
            $table->string("hp", 13);
            $table->string('thumdnail')->nullable();
            $table->string("email", 50)->nullable();
            $table->string('kategori_harga_juals')->references('id')->on('kategori_harga_juals')->onDelete('cascade');
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
        Schema::dropIfExists('pelanggans');
    }
}
