<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DaftarPoli;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $idDokter = Auth::id();

        // Ambil data antrean:
        // 1. Relasi ke pasien dibawa (with pasien)
        // 2. Filter jadwal hanya milik dokter yang login (whereHas jadwalPeriksa)
        // 3. Filter status hanya yang 'menunggu'
        $antrian = DaftarPoli::with('pasien')
            ->whereHas('jadwalPeriksa', function($q) use ($idDokter) {
                $q->where('id_dokter', $idDokter);
            })
            ->where('status_periksa', 'menunggu')
            ->orderBy('no_antrian', 'asc') // Urutkan dari no 1, 2, dst
            ->get();

        // LANGSUNG RETURN VIEW (Jangan pakai dd lagi)
        return view('dokter.dashboard', compact('antrian'));
    }
}