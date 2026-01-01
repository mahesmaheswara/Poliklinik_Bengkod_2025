<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use App\Models\DaftarPoli;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use Illuminate\Support\Facades\Auth;

class PeriksaController extends Controller
{
    // 1. INDEX: KARENA TIDAK ADA FILE INDEX, KITA LEMPAR BALIK KE DASHBOARD
    public function index()
    {
        $idDokter = Auth::id();
        
        // 1. Tentukan Hari Ini (Manual Mapping)
        $hariInggris = date('l'); 
        $mapHari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $hariIni = $mapHari[$hariInggris];

        // 2. Cari Jadwal Dokter Hari Ini
        $jadwal = JadwalPeriksa::where('id_dokter', $idDokter)
                    ->where('hari', $hariIni)
                    ->first();

        // 3. Ambil Antrean
        $pasienMenunggu = [];
        if ($jadwal) {
            $pasienMenunggu = DaftarPoli::with('pasien')
                        ->where('id_jadwal', $jadwal->id)
                        ->where('status_periksa', 'menunggu')
                        ->orderBy('no_antrian')
                        ->get();
        }

        return view('dokter.periksa.index', compact('pasienMenunggu'));
    }

    // 2. HALAMAN FORM PERIKSA (Pastikan file create.blade.php ada)
    public function create($id)
    {
        $daftarPoli = DaftarPoli::with(['pasien', 'jadwalPeriksa'])->findOrFail($id);
        
        // Ambil obat untuk dropdown
        $obat = Obat::all();

        return view('dokter.periksa.create', compact('daftarPoli', 'obat'));
    }

    // 3. SIMPAN HASIL PEMERIKSAAN
    public function store(Request $request, $id)
    {
        $request->validate([
            'tgl_periksa' => 'required',
            'catatan' => 'required',
            'obat_json' => 'required' 
        ]);

        $daftarPoli = DaftarPoli::findOrFail($id);

        // A. Simpan Data Periksa
        $periksa = Periksa::create([
            'id_daftar_poli' => $id,
            'tgl_periksa' => $request->tgl_periksa,
            'catatan' => $request->catatan,
            'biaya_periksa' => 150000, // Biaya Jasa Default
        ]);

        // B. Simpan Detail Obat (Looping JSON)
        $listObatId = json_decode($request->obat_json);
        $totalBiayaObat = 0;

        if (is_array($listObatId)) {
            foreach ($listObatId as $idObat) {
                $obat = Obat::find($idObat);
                
                if($obat) {
                    DetailPeriksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat' => $idObat
                    ]);

                    $totalBiayaObat += $obat->harga;
                    
                    // Opsional: Kurangi Stok Real (Uncomment jika mau aktifkan)
                    // if($obat->stok > 0) $obat->decrement('stok'); 
                }
            }
        }

        // C. Update Total Biaya
        $periksa->update([
            'biaya_periksa' => 150000 + $totalBiayaObat
        ]);

        // D. Update Status Antrean jadi 'selesai'
        $daftarPoli->update(['status_periksa' => 'selesai']);

        // --- PERUBAHAN PENTING DISINI ---
        // Jangan ke route('dokter.periksa.index') karena view-nya gak ada.
        // Balik ke Dashboard aja.
        return redirect()->route('dokter.dashboard')
            ->with('success', 'Pemeriksaan Berhasil Disimpan!');
    }
}