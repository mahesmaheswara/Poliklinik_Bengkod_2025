<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Tambahan: Pastikan User di-import
use App\Models\DaftarPoli; // Tambahan: Pastikan DaftarPoli di-import

class JadwalPeriksa extends Model
{
    protected $table = 'jadwal_periksa';

    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status' // <-- INI ADALAH PERBAIKANNYA
                 // Tanpa ini, status 'aktif'/'non-aktif' akan diabaikan
    ];

    public function dokter(){
        return $this->belongsTo(User::class, 'id_dokter');
    }

    public function daftarPolis(){
        return $this->hasMany(DaftarPoli::class, 'id_jadwal');
    }
}