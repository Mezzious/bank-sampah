<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusKonfirmasiToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saleses', function (Blueprint $table) {
            $table->string('status_konfirmasi')->default('belum dikonfirmasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saleses', function (Blueprint $table) {
            $table->dropColumn('status_konfirmasi');
        });
    }
}
