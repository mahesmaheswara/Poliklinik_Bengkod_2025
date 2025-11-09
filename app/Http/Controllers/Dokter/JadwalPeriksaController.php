<?php

// MARK: 1. NAMESPACE & IMPORT
// ========================================================================
// Mendefinisikan namespace untuk Controller Dokter
// dan mengimpor semua Class yang dibutuhkan.
namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\DaftarPoli; // DIPERLUKAN: Untuk mengambil data antrian
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // DIPERLUKAN: Untuk filter jadwal berdasarkan hari ini

class JadwalPeriksaController extends Controller
{
    // MARK: 2. METHOD DASHBOARD DOKTER
    // ========================================================================
    // Method ini dipanggil oleh route 'dokter.dashboard'.
    // Fungsinya untuk mengambil data yang relevan untuk dashboard dokter.
    public function dashboard()
    {
        // 1. Ambil data dokter yang sedang login
        $dokter = Auth::user();
        
        // 2. Ambil hari ini dalam bahasa Indonesia (e.g., "Senin", "Selasa")
        $hariIni = Carbon::now()->translatedFormat('l');

        // 3. Ambil jadwal praktek dokter HARI INI
        $jadwalHariIni = JadwalPeriksa::where('id_dokter', $dokter->id)
                                    ->where('hari', $hariIni)
                                    ->get();

        // 4. Ambil ID dari jadwal hari ini
        $jadwalIds = $jadwalHariIni->pluck('id');

        // 5. Ambil antrian pasien yang mendaftar HARI INI
        //    dan yang mendaftar ke JADWAL HARI INI
        $antrianPasien = DaftarPoli::whereIn('id_jadwal', $jadwalIds)
                                 ->whereDate('created_at', Carbon::today()) // Filter hanya pendaftaran hari ini
                                 ->with('pasien') // Eager load data pasien
                                 ->orderBy('no_antrian', 'asc')
                                 ->get();
        
        // 6. Kirim data ke view
        return view('dokter.dashboard', compact('jadwalHariIni', 'antrianPasien'));
    }

    // MARK: 3. METHOD INDEX (CRUD JADWAL)
    // ========================================================================
    // Menampilkan halaman tabel 'Jadwal Periksa'.
    public function index(){
        // 1. Ambil user dari auth
        $dokter = Auth::user();
        // 2. ambil id_dokter ambil hanya hari
        $jadwalPeriksas = JadwalPeriksa::where('id_dokter', $dokter->id)->orderBy('hari')->get();
        // 3. return
        return view('dokter.jadwal-periksa.index', compact('jadwalPeriksas'));
    }

    // MARK: 4. METHOD CREATE (CRUD JADWAL)
    // ========================================================================
    // Menampilkan halaman form 'Tambah Jadwal Periksa'.
    public function create(){
        return view('dokter.jadwal-periksa.create');
    }

    // MARK: 5. METHOD STORE (CRUD JADWAL)
    // ========================================================================
    // Menyimpan data jadwal periksa baru ke database.
    public function store(Request $request){
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ]);

        JadwalPeriksa::create([
            'id_dokter' => Auth::id(),
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai
        ]);

        return redirect()->route('jadwal-periksa.index')
            ->with('message', 'Data Berhasil di Simpan')
            ->with('type', 'success');
    }

    // MARK: 6. METHOD EDIT (CRUD JADWAL)
    // ========================================================================
    // Menampilkan halaman form 'Edit Jadwal Periksa'.
    public function edit($id){
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);
        return view('dokter.jadwal-periksa.edit',compact('jadwalPeriksa'));
    }

    // MARK: 7. METHOD UPDATE (CRUD JADWAL)
    // ========================================================================
    // Memperbarui data jadwal periksa yang ada di database.
    public function update(Request $request, string $id){
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ]);

        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);
        $jadwalPeriksa->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai
        ]);

        return redirect()->route('jadwal-periksa.index')
            ->with('message','Berhasil Melakukan Update Data')
            ->with('type','success');
    }

    // MARK: 8. METHOD DESTROY (CRUD JADWAL)
    // ========================================================================
    // Menghapus data jadwal periksa dari database.
    public function destroy(string $id){
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);
        $jadwalPeriksa->delete();

        return redirect()->route('jadwal-periksa.index')
            ->with('message','Berhasil Melakukan Hapus Data')
            ->with('type','success');
    }
}
// PERBAIKAN: Menghapus satu kurung kurawal '}' ekstra yang ada di file asli Anda.