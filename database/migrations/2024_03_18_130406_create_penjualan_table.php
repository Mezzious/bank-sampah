<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('id_jual')->length(5);
            $table->date('tanggal_jual');
            $table->string('jenis_sampah');
            $table->string('gambar');
            $table->integer('berat')->length(4);
            $table->string('harga');
            $table->string('total');
            $table->string('id_user', 9)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan');
    }
}
