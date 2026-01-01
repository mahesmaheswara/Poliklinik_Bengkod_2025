@extends('components.layouts.app')

@section('header')
    Dashboard Pasien
@endsection

@section('content')
<div class="container-fluid">
    
    {{-- 1. WELCOME BANNER (Kartu Selamat Datang) --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-white border-0 shadow-sm" style="border-left: 5px solid #2563EB !important;">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="mr-3 text-primary">
                        <i class="fas fa-user-shield fa-3x"></i>
                    </div>
                    <div>
                        <h4 class="font-weight-bold text-dark mb-1" style="font-family: 'Poppins', sans-serif;">
                            Selamat Datang, {{ Auth::user()->nama ?? Auth::user()->name }}!
                        </h4>
                        <p class="text-muted mb-0">
                            Semoga lekas sembuh. Silakan daftar poli atau cek riwayat berobat Anda di bawah ini.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- 
           ==========================================================
           KOLOM KIRI: KARTU AKSI UTAMA (DAFTAR POLI)
           ==========================================================
        --}}
        <div class="col-lg-7 mb-4">
            {{-- 
                Kita gunakan lagi style gradien dari kode lamamu, 
                tapi hanya untuk kartu aksi ini agar terlihat spesial.
            --}}
            <div class="card border-0 shadow-lg text-center p-5" style="background: linear-gradient(135deg, #2563EB, #3B82F6);">
                <i class="fas fa-file-medical-alt fa-4x text-white opacity-75 mb-4"></i>
                <h2 class="font-weight-bold text-white mb-3" style="font-family: 'Poppins', sans-serif;">
                    Pendaftaran Poli Online
                </h2>
                <p class="text-white opacity-90 mb-4 px-3">
                    Daftar berobat, pilih dokter, dan dapatkan nomor antrean Anda secara online tanpa perlu menunggu lama di klinik.
                </p>
                <a href="{{ route('pasien.daftar') }}" class="btn btn-light btn-lg shadow-sm font-weight-bold py-3 px-5 rounded-pill" style="width: auto; margin: 0 auto;">
                    <i class="fas fa-arrow-right mr-2"></i> Mulai Daftar Sekarang
                </a>
            </div>
        </div>

        {{-- 
           ==========================================================
           KOLOM KANAN: RIWAYAT KUNJUNGAN
           ==========================================================
        --}}
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm" style="min-height: 100%;">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h3 class="card-title font-weight-bold text-dark">
                        <i class="fas fa-history text-primary mr-2"></i> Riwayat Kunjungan Anda
                    </h3>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group list-group-flush">
                        {{-- 
                           CATATAN: Ini membutuhkan variabel $riwayatKunjungan 
                           dari PasienController@dashboard
                        --}}
                        @forelse ($riwayatKunjungan ?? [] as $riwayat)
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-3 py-3">
                                <div classs="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success fa-lg mr-3"></i>
                                    <div>
                                        <h6 class_="{{-- ... --}}">Poli {{ $riwayat->poli->nama ?? 'N/A' }}</h6>
                                        <small class_="{{-- ... --}}">
                                            {{-- Cek dulu apakah 'tanggal' itu objek sebelum diformat --}}
                                            @if($riwayat->tanggal instanceof \Carbon\Carbon)
                                                {{ $riwayat->tanggal->format('d F Y') }}
                                            @else
                                                {{ $riwayat->tanggal }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill">Detail</a>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted py-5 border-0">
                                <i class="fas fa-folder-open fa-3x mb-3 text-gray-300"></i>
                                <p class="mb-0">Anda belum memiliki riwayat kunjungan.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection