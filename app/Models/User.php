<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Poli; // <-- WAJIB ADA: Import model Poli
use App\Models\JadwalPeriksa; // <-- WAJIB ADA: Import model JadwalPeriksa

class User extends Authenticatable
{
    // Hapus HasApiTokens untuk menghindari error
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'alamat',
        'no_ktp',
        'no_hp',
        'no_rm',
        'role',
        'id_poli',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==========================================================
    // INI ADALAH FUNGSI YANG HILANG (PENYEBAB JADWAL KOSONG)
    // ==========================================================
    /**
     * Relasi untuk Dokter ke Poli.
     */
    public function poli()
    {
        // Dokter 'belongsTo' (memiliki satu) Poli
        // Ini menghubungkan 'id_poli' di tabel 'users' ke 'id' di tabel 'poli'
        return $this->belongsTo(Poli::class, 'id_poli');
    }
    // ==========================================================

    /**
     * Relasi untuk Dokter ke Jadwal
     */
    public function jadwalPeriksas()
    {
        return $this->hasMany(JadwalPeriksa::class, 'id_dokter');
    }
}