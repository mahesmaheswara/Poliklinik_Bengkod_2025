<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// --- IMPORT MODELS ---
use App\Models\JadwalPeriksa;
use App\Models\DaftarPoli;
use App\Models\Poli;

class JadwalPeriksaController extends Controller
{
    // =================================================================
    // 1. FITUR DASHBOARD (CARD JADWAL & ANTREAN)
    // =================================================================
    public function dashboard()
    {
        $idDokter = Auth::id();
        
        // --- LOGIC PENERJEMAH HARI (Solusi Masalah Thursday/Kamis) ---
        // Kita tidak mengandalkan settingan server, kita translate manual biar PASTI BENAR.
        $hariInggris = date('l'); 
        $mapHari = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu'
        ];
        $hariIni = $mapHari[$hariInggris]; // Hasilnya pasti bahasa Indonesia (misal: "Kamis")

        // 1. Ambil Jadwal Dokter HARI INI
        $jadwal = JadwalPeriksa::where('id_dokter', $idDokter)
                    ->where('hari', $hariIni)
                    ->first();

        // 2. Ambil Antrean (Hanya jika jadwal hari ini ada)
        $antrian = [];
        if ($jadwal) {
            $antrian = DaftarPoli::with('pasien')
                        ->where('id_jadwal', $jadwal->id) // Konek relasi via ID Jadwal
                        ->where('status_periksa', 'menunggu')
                        ->orderBy('no_antrian')
                        ->get();
        }

        // Kirim $jadwal dan $antrian ke View biar muncul di layar
        return view('dokter.dashboard', compact('jadwal', 'antrian'));
    }

    // =================================================================
    // 2. FITUR CRUD JADWAL (BAWAAN LAMA)
    // =================================================================
    public function index()
    {
        // Menampilkan daftar semua jadwal milik dokter yg login
        $jadwalPeriksas = JadwalPeriksa::where('id_dokter', Auth::id())->get();
        return view('dokter.jadwal-periksa.index', compact('jadwalPeriksas'));
    }

    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        // Cek Double Jadwal (Validasi Tambahan)
        $exists = JadwalPeriksa::where('id_dokter', Auth::id())
                    ->where('hari', $request->hari)
                    ->first();
        
        if ($exists) {
            return back()->withErrors(['hari' => 'Jadwal hari ' . $request->hari . ' sudah ada!']);
        }

        JadwalPeriksa::create([
            'id_dokter' => Auth::id(),
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'aktif' // Default aktif
        ]);

        return redirect()->route('jadwal-periksa.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);
        return view('dokter.jadwal-periksa.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'status' => 'required' // Dokter bisa set aktif/tidak aktif
        ]);

        $jadwal = JadwalPeriksa::findOrFail($id);
        $jadwal->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status
        ]);

        return redirect()->route('jadwal-periksa.index')->with('success', 'Jadwal berhasil diupdate');
    }

    public function destroy($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('jadwal-periksa.index')->with('success', 'Jadwal berhasil dihapus');
    }
}