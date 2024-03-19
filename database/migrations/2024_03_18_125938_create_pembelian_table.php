<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id('id_beli')->length(5);
            $table->date('tanggal_beli');
            $table->string('id_nasabah', 10)->unique();
            $table->string('jenis_sampah');
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
        Schema::dropIfExists('pembelian');
    }
}
