<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trashes', function (Blueprint $table) {
            $table->string('id', 6)->primary();
            $table->string('user_id', 6)->index();
            $table->string('jenis_sampah', 20);
            $table->string('satuan', 3);
            $table->string('harga', 6);
            $table->string('gambar', 100);
            $table->text('deskripsi', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trashes');
    }
}
