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
        Schema::create('daftar_poli', function (Blueprint $table) {
            $table->id();
            
            // --- KOLOM BARU (PENTING) ---
            // 1. Untuk ID Booking Global (Contoh: REG-20251212-001)
            $table->string('no_registrasi')->nullable()->unique(); 
            
            // 2. Relasi Foreign Key
            $table->foreignId('id_pasien')->constrained('users')->cascadeOnDelete();
            $table->foreignId('id_jadwal')->constrained('jadwal_periksa')->cascadeOnDelete();
            
            $table->text('keluhan');
            $table->integer('no_antrian');
            
            // 3. Status Periksa (Biar bisa difilter mana yang sudah selesai)
            $table->enum('status_periksa', ['menunggu', 'selesai'])->default('menunggu');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_poli');
    }
};