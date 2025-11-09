<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Pasien\PoliController as PasienPoliController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan rute web untuk aplikasi Anda.
|
*/

// ========================================================================
// MARK 1: RUTE PUBLIK & AUTENTIKASI (GUEST)
// ========================================================================
// Rute-rute ini dapat diakses oleh siapa saja (tamu).
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk menampilkan halaman login & register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Rute untuk memproses data login & register
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rute logout (membutuhkan user untuk login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ========================================================================
// MARK 2: RUTE ROLE ADMIN
// ========================================================================
// Rute-rute ini hanya bisa diakses oleh user dengan role 'admin'
// dan memiliki awalan URL '/admin' (contoh: /admin/dashboard)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Rute CRUD untuk Admin
    // Catatan: Nama resource (polis, dokter, pasien, obat) 
    // menggunakan bentuk TUNGGAL (singular) agar sesuai
    // dengan pemanggilan 'route()' di sidebar Anda.
    Route::resource('polis', PoliController::class);
    Route::resource('dokter', DokterController::class); // Menggunakan nama 'dokter'
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);

});


// ========================================================================
// MARK 3: RUTE ROLE DOKTER
// ========================================================================
// Rute-rute ini hanya bisa diakses oleh user dengan role 'dokter'
// dan memiliki awalan URL '/dokter'
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    
    // Rute dashboard yang memanggil controller untuk mengambil data
    Route::get('/dashboard', [JadwalPeriksaController::class, 'dashboard'])
         ->name('dokter.dashboard');

    // Rute CRUD untuk Jadwal Periksa
    Route::resource('jadwal-periksa', JadwalPeriksaController::class);

    // Anda bisa menambahkan rute 'periksa-pasien' dan 'riwayat-pasien' di sini nanti
    // Route::resource('periksa-pasien', PeriksaPasienController::class);
    // Route::resource('riwayat-pasien', RiwayatPasienController::class);

});


// ========================================================================
// MARK 4: RUTE ROLE PASIEN
// ========================================================================
// Rute-rute ini hanya bisa diakses oleh user dengan role 'pasien'
// dan memiliki awalan URL '/pasien'
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    // Rute untuk mendaftar poli
    Route::get('/daftar', [PasienPoliController::class, 'get'])->name('pasien.daftar');
    Route::post('/daftar', [PasienPoliController::class, 'submit'])->name('pasien.daftar.submit');

});