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
        Schema::create('saleses', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal_jual');
            $table->string('jenis_sampah');
            $table->string('gambar');
            $table->integer('berat');
            $table->string('harga');
            $table->string('total');
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saleses');
    }
}
