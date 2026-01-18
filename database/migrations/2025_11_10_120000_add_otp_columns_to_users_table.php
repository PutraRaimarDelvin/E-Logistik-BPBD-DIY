<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            
            // 1. Buat 'email_otp' dulu.
            //    Kita letakkan setelah 'remember_token' (kolom default Laravel)
          //  $table->string('email_otp')->nullable()->after('remember_token');
            
            // 2. Buat 'email_otp_expires_at', letakkan SETELAH 'email_otp'
          //  $table->timestamp('email_otp_expires_at')->nullable()->after('email_otp');

            // 3. Buat 'last_otp_sent_at', letakkan SETELAH 'email_otp_expires_at'
            //    Sekarang 'email_otp_expires_at' DIJAMIN ada dan perintah ini valid
           // $table->timestamp('last_otp_sent_at')->nullable()->after('email_otp_expires_at');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus semua kolom ini jika migrasi di-rollback
            // Urutan penghapusan tidak penting
            $table->dropColumn([
                'email_otp',
                'email_otp_expires_at',
                'last_otp_sent_at'
            ]);
        });
    }
};