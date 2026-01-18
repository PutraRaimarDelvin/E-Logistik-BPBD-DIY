<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            if (!Schema::hasColumn('laporans', 'foto_path')) {
                $table->string('foto_path')->nullable();
            }

            if (!Schema::hasColumn('laporans', 'surat_path')) {
                $table->string('surat_path')->nullable();
            }
        });
    }
        public function down()
        {
            Schema::table('laporans', function (Blueprint $table) {
                if (Schema::hasColumn('laporans', 'foto_path')) {
                    $table->dropColumn('foto_path');
                }
                if (Schema::hasColumn('laporans', 'surat_path')) {
                    $table->dropColumn('surat_path');
                }
            });
        }   
        };
