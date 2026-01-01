<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// ========================================================================
// 1. IMPORT MODELS & CONTROLLERS
// ========================================================================

// Models
use App\Models\User;
use App\Models\Poli;
use App\Models\Obat;
use App\Models\DaftarPoli;

// Controllers Global/Admin
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RiwayatGlobalController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;

// Controllers Dokter
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaController;
use App\Http\Controllers\Dokter\RiwayatPasienController;
// Note: DashboardController dihapus karena bikin error data kosong

// Controllers Pasien
use App\Http\Controllers\Pasien\PoliController as PasienPoliController; // Wizard Lama
use App\Http\Controllers\Pasien\DaftarPoliController; // Ajax Baru


/*
|--------------------------------------------------------------------------
| Web Routes (FINAL FIXED STRUCTURE)
|--------------------------------------------------------------------------
*/

// ========================================================================
// MARK 1: GUEST / PUBLIC ROUTES
// ========================================================================

Route::get('/', function () {
    return view('welcome', ['polis' => Poli::all()]);
})->name('welcome');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ========================================================================
// MARK 2: ROLE ADMIN
// ========================================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // A. DASHBOARD ADMIN (Logic Chart & Statistik)
    Route::get('/dashboard', function () {
        // 1. Total Counter
        $totalDokter = User::where('role', 'dokter')->count();
        $totalPasien = User::where('role', 'pasien')->count();
        $totalPoli = Poli::count();
        $totalObat = Obat::count();

        // 2. Grafik Kunjungan (7 Hari)
        $dataKunjungan = DaftarPoli::where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'asc')->get();
        $groupedKunjungan = $dataKunjungan->groupBy(fn($item) => $item->created_at->format('Y-m-d'));

        // 3. Grafik Poli Populer
        $dataPoli = DaftarPoli::with('jadwalPeriksa.dokter.poli')->get();
        $groupedPoli = $dataPoli->groupBy(fn($item) => $item->jadwalPeriksa->dokter->poli->nama_poli ?? 'Lainnya');

        return view('admin.dashboard', [
            'totalDokter' => $totalDokter, 'totalPasien' => $totalPasien,
            'totalPoli' => $totalPoli, 'totalObat' => $totalObat,
            'chartKunjunganLabels' => $groupedKunjungan->keys(),
            'chartKunjunganData' => $groupedKunjungan->map->count()->values(),
            'chartPoliLabels' => $groupedPoli->keys(),
            'chartPoliData' => $groupedPoli->map->count()->values(),
        ]);
    })->name('admin.dashboard');

    // B. CETAK LAPORAN
    Route::get('/dokter/cetak', [DokterController::class, 'cetak'])->name('dokter.cetak');
    Route::get('/pasien/cetak', [PasienController::class, 'cetak'])->name('pasien.cetak');
    Route::get('/polis/cetak', [PoliController::class, 'cetak'])->name('polis.cetak');
    Route::get('/obat/cetak', [ObatController::class, 'cetak'])->name('obat.cetak');

    // C. CRUD MASTER DATA
    Route::resource('polis', PoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);

    // D. RIWAYAT GLOBAL
    Route::get('/riwayat-global', [RiwayatGlobalController::class, 'index'])->name('admin.riwayat_global');
});


// ========================================================================
// MARK 3: ROLE PASIEN
// ========================================================================
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    
    // A. Dashboard Pasien
    Route::get('/dashboard', function () {
        $riwayatKunjungan = DaftarPoli::with(['jadwalPeriksa.dokter.poli'])
            ->where('id_pasien', Auth::id())
            ->orderBy('created_at', 'desc')->get();
        return view('pasien.dashboard', compact('riwayatKunjungan'));
    })->name('pasien.dashboard');

    // B. Daftar Poli (Versi Baru - Ajax)
    Route::get('/daftar-poli', [DaftarPoliController::class, 'index'])->name('pasien.daftar_poli');
    Route::post('/daftar-poli', [DaftarPoliController::class, 'store'])->name('pasien.daftar_poli.store');
    Route::get('/get-jadwal', [DaftarPoliController::class, 'getJadwal'])->name('get.jadwal');

    // C. Daftar Poli (Versi Lama - Wizard) - TETAP DIPERTAHANKAN
    Route::get('/daftar', [PasienPoliController::class, 'get'])->name('pasien.daftar');
    Route::post('/daftar', [PasienPoliController::class, 'submit'])->name('pasien.daftar.submit');
});


// ========================================================================
// MARK 4: ROLE DOKTER
// ========================================================================
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    
    // 1. Dashboard Dokter 
    // FIXED: Kembali menggunakan JadwalPeriksaController agar variable $jadwal terkirim
    Route::get('/dashboard', [JadwalPeriksaController::class, 'dashboard'])->name('dokter.dashboard');

    // 2. Kelola Jadwal Periksa
    Route::resource('jadwal-periksa', JadwalPeriksaController::class);

    // 3. Fitur Memeriksa Pasien
    // A. Halaman List Antrean (Buat Sidebar)
    Route::get('/periksa', [PeriksaController::class, 'index'])->name('periksa.index'); 
    
    // B. Halaman Form Periksa (Saat klik tombol "Periksa")
    Route::get('/periksa/{id_pasien}', [PeriksaController::class, 'create'])->name('periksa.create');
    
    // C. Proses Simpan
    Route::post('/periksa/{id_daftar_poli}', [PeriksaController::class, 'store'])->name('periksa.store');

    // 4. Riwayat Pasien
    Route::get('/riwayat-pasien', [RiwayatPasienController::class, 'index'])->name('riwayat-pasien.index');
    Route::get('/riwayat-pasien/{id}', [RiwayatPasienController::class, 'show'])->name('riwayat-pasien.show');
});