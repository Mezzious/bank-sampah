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
        Schema::create('purchases', function (Blueprint $table) {
            $table->string('id', 6)->primary();
            $table->string('user_id', 6)->index();
            $table->date('tanggal_beli');
            $table->string('jenis_sampah', 20);
            $table->string('berat', 3);
            $table->string('harga', 6);
            $table->string('total', 9);
            $table->string('gambar_ttd', 50);
            $table->string('gambar_sampah', 50);
            $table->string('status_konfirmasi', 50)->default('belum dikonfirmasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
