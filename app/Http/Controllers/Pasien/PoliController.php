<?php

// MARK: 1. NAMESPACE & IMPORT
// ========================================================================
namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use App\Models\User; // DIPERLUKAN: Untuk mengambil data Pasien
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoliController extends Controller
{
    // MARK: 2. METHOD GET
    // ========================================================================
    // Menampilkan halaman form 'Daftar Poli'
    public function get()
    {
        // Ambil data pasien yang sedang login
        $user = Auth::user();
        
        // Ambil semua data poli untuk dropdown
        $polis = Poli::all();
        
        // Ambil semua jadwal, beserta relasi dokter dan poli dokter
        $jadwal = JadwalPeriksa::with('dokter', 'dokter.poli')->get();

        return view('pasien.daftar', [
            'user' => $user,
            'polis' => $polis,
            'jadwals' => $jadwal,
        ]);
    }

    // MARK: 3. METHOD SUBMIT
    // ========================================================================
    // Memproses data pendaftaran poli dari pasien
    public function submit(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'nullable|string',
            'id_pasien' => 'required|exists:users,id',
        ]);

        // Cek apakah pasien sudah mendaftar di jadwal yang sama
        $sudahDaftar = DaftarPoli::where('id_pasien', $request->id_pasien)
                                 ->where('id_jadwal', $request->id_jadwal)
                                 ->exists();

        if ($sudahDaftar) {
            return redirect()->back()
                ->with('message', 'Anda sudah terdaftar di jadwal ini. Silakan pilih jadwal lain.')
                ->with('type', 'danger'); // Kirim alert 'danger' (merah)
        }

        // Hitung nomor antrian
        // Ambil jumlah pendaftar di jadwal tersebut HARI INI
        $jumlahSudahDaftar = DaftarPoli::where('id_jadwal', $request->id_jadwal)
                                     ->whereDate('created_at', now()->today()) // Hanya hitung pendaftar hari ini
                                     ->count();
        
        // Buat data pendaftaran baru
        DaftarPoli::create([
            // PERBAIKAN BUG: Menghapus 's' dari 'id_pasiens' dan 'id_jadwals'
            'id_pasien' => $request->id_pasien,
            'id_jadwal' => $request->id_jadwal,
            'keluhan' => $request->keluhan,
            'no_antrian' => $jumlahSudahDaftar + 1,
        ]);

        return redirect()->back()->with('message', 'Berhasil Mendaftar ke Poli. Nomor antrian Anda adalah ' . ($jumlahSudahDaftar + 1))->with('type', 'success');
    }
}