<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DaftarPoli;

class RiwayatGlobalController extends Controller
{
    /**
     * Menampilkan seluruh riwayat pemeriksaan dari semua dokter.
     */
    public function index()
    {
        // Gunakan Eager Loading (with) untuk mencegah N+1 Query Problem
        // Urutkan dari yang paling baru (latest)
        $riwayat = DaftarPoli::with([
                'pasien', 
                'jadwalPeriksa.dokter.poli', 
                'periksa.detailPeriksa.obat'
            ])
            ->where('status_periksa', 'selesai') // Filter HANYA yang sudah diperiksa
            ->latest() // Order by created_at DESC
            ->get();

        return view('admin.riwayat_global.index', compact('riwayat'));
    }
}