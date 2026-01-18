<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Data Pelapor
            $table->string('nama');
            $table->string('nik', 16)->nullable();      // max 16 digit
            $table->string('jabatan')->nullable();     // bisa strip
            $table->string('instansi')->nullable();    // bisa strip
            $table->string('no_hp');

            // Tujuan & Jenis Bencana
            $table->string('tujuan');
            $table->string('jenis_bencana');

            // Lokasi Posko
            $table->string('nama_posko');
            $table->string('tingkat_posko');
            $table->string('rt', 10);
            $table->string('rw', 10);
            $table->string('desa');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan');

            // Lampiran
            $table->string('foto')->nullable();        // hanya gambar
            $table->string('surat')->nullable();       // hanya pdf

            // Validasi Admin
            $table->enum('status_validasi', ['Menunggu', 'Disetujui', 'Ditolak'])
                  ->default('Menunggu');
            $table->text('catatan_admin')->nullable();
            $table->unsignedBigInteger('validated_by')->nullable();
            $table->foreign('validated_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
