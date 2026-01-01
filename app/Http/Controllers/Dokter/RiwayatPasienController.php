<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periksa;
use App\Models\DaftarPoli;
use Illuminate\Support\Facades\Auth;

class RiwayatPasienController extends Controller
{
    public function index()
    {
        // Ambil data periksa yang dokternya adalah user yang sedang login
        // Relasi: Periksa -> DaftarPoli -> JadwalPeriksa -> Dokter (User)
        $riwayatPasien = Periksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa'])
            ->whereHas('daftarPoli.jadwalPeriksa', function($q) {
                $q->where('id_dokter', Auth::id());
            })
            ->orderBy('tgl_periksa', 'desc')
            ->get();

        // Perhatikan nama variabelnya: 'riwayatPasien' (Sesuai View yang disimpan)
        return view('dokter.riwayat-pasien.index', compact('riwayatPasien'));
    }

    public function show($id)
    {
        // Detail pemeriksaan lengkap dengan obat
        $periksa = Periksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa.dokter.poli', 'detailPeriksa.obat'])
            ->findOrFail($id);

        return view('dokter.riwayat-pasien.show', compact('periksa'));
    }
}