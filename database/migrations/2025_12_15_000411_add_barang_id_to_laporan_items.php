<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('laporan_items', function (Blueprint $table) {

            // 1️⃣ TAMBAH KOLOM DULU
            if (!Schema::hasColumn('laporan_items', 'barang_id')) {
                $table->unsignedBigInteger('barang_id')->after('laporan_id');
            }
        });

        Schema::table('laporan_items', function (Blueprint $table) {

            // 2️⃣ BARU TAMBAH FOREIGN KEY
            $table->foreign('barang_id')
                  ->references('id')
                  ->on('barang')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_items', function (Blueprint $table) {
            $table->dropForeign(['barang_id']);
            $table->dropColumn('barang_id');
        });
    }
};
