<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('laporan_items', function (Blueprint $table) {
        $table->string('kode_barang')->nullable()->after('nama_barang');
        $table->integer('harga')->nullable()->after('jumlah');
        $table->integer('total_harga')->nullable()->after('harga');
    });
}

public function down()
{
    Schema::table('laporan_items', function (Blueprint $table) {
        $table->dropColumn(['kode_barang', 'harga', 'total_harga']);
    });
}
};
