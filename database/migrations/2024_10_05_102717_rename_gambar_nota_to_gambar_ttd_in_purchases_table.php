<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameGambarNotaToGambarTtdInPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Mengubah nama kolom gambar_nota menjadi gambar_ttd di tabel purchases
        Schema::table('purchases', function (Blueprint $table) {
            $table->renameColumn('gambar_nota', 'gambar_ttd');
        });
        
        // Mengubah nama kolom gambar_nota menjadi gambar_ttd di tabel saleses
        Schema::table('saleses', function (Blueprint $table) {
            $table->renameColumn('gambar_nota', 'gambar_ttd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         // Mengembalikan perubahan di tabel purchases
        Schema::table('purchases', function (Blueprint $table) {
            $table->renameColumn('gambar_ttd', 'gambar_nota');
        });
    }
}
