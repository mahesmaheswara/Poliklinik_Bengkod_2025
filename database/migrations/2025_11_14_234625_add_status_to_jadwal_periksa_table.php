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
        Schema::table('jadwal_periksa', function (Blueprint $table) {
            // TAMBAHKAN BARIS INI
            // Kita buat defaultnya 'non-aktif' agar data lama aman
            $table->string('status', 10)->default('non-aktif')->after('jam_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_periksa', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
