<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            // Tambahkan kolom jenis_bencana di bawah kolom tujuan
            if (!Schema::hasColumn('laporans', 'jenis_bencana')) {
                $table->string('jenis_bencana', 100)->after('tujuan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn('jenis_bencana');
        });
    }
};
