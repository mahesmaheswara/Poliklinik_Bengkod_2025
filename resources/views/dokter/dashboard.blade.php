@extends('components.layouts.app')

@section('header')
    Dashboard Dokter
@endsection

@section('content')
<div class="container-fluid">
    
    {{-- 1. WELCOME BANNER --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-white border-0 shadow-sm" style="border-left: 5px solid #4B9CD3 !important;">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="mr-3 text-primary">
                        <i class="fas fa-user-md fa-3x"></i>
                    </div>
                    <div>
                        <h4 class="font-weight-bold text-dark mb-1" style="font-family: 'Poppins', sans-serif;">
                            Selamat Datang, dr. {{ Auth::user()->nama }}!
                        </h4>
                        <p class="text-muted mb-0">
                            Semoga hari Anda menyenangkan. Berikut adalah ringkasan antrean pasien hari ini.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- 
           ==========================================================
           KOLOM KIRI: DAFTAR ANTRIAN PASIEN
           ==========================================================
        --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="min-height: 400px;">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold text-dark">
                        <i class="fas fa-list-ol text-primary mr-2"></i> Antrean Hari Ini
                    </h3>
                    <span class="badge bg-primary px-3 py-2 rounded-pill">
                        {{ date('d M Y') }}
                    </span>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-primary">
                                <tr>
                                    <th class="border-0 pl-4 rounded-left">No</th>
                                    <th class="border-0">Nama Pasien</th>
                                    <th class="border-0">Keluhan</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0 rounded-right text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- PERBAIKAN 1: Gunakan variabel $antrian (sesuai controller) --}}
                                @forelse ($antrian as $item)
                                    <tr>
                                        <td class="pl-4">
                                            <div class="d-flex align-items-center justify-content-center bg-light rounded-circle text-primary font-weight-bold" 
                                                 style="width: 35px; height: 35px;">
                                                {{ $item->no_antrian }}
                                            </div>
                                        </td>
                                        <td class="font-weight-medium">{{ $item->pasien->nama ?? '-' }}</td>
                                        <td class="text-muted small">{{ Str::limit($item->keluhan, 40) }}</td>
                                        <td>
                                            @if($item->status_periksa == 'menunggu')
                                                <span class="badge badge-warning px-2 py-1">Menunggu</span>
                                            @elseif($item->status_periksa == 'diperiksa')
                                                <span class="badge badge-info px-2 py-1">Sedang Diperiksa</span>
                                            @else
                                                <span class="badge badge-success px-2 py-1">Selesai</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($item->status_periksa != 'selesai')
                                                {{-- Tombol Periksa --}}
                                                <a href="{{ route('periksa.index', $item->id) }}" 
                                                   class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    <i class="fas fa-stethoscope mr-1"></i> Periksa
                                                </a>
                                            @else
                                                <span class="text-success font-weight-bold">
                                                    <i class="fas fa-check-circle mr-1"></i> Selesai
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fas fa-clipboard-list fa-3x mb-3 text-gray-300"></i>
                                            <p>Belum ada pasien dalam antrean saat ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- 
           ==========================================================
           KOLOM KANAN: JADWAL PRAKTEK DOKTER
           ==========================================================
        --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white border-0 pt-4 px-4 rounded-top">
                    <h3 class="card-title font-weight-bold">
                        <i class="far fa-clock mr-2"></i> Jadwal Anda
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-4">
                        Berikut adalah jadwal praktek aktif Anda untuk hari ini. Pastikan hadir tepat waktu.
                    </p>

                    {{-- PERBAIKAN 2: Gunakan IF $jadwal (bukan Foreach loop) --}}
                    @if ($jadwal)
                        <div class="d-flex align-items-center p-3 mb-3 bg-light rounded border border-light">
                            <div class="bg-white p-3 rounded shadow-sm text-center mr-3" style="min-width: 70px;">
                                <h5 class="font-weight-bold text-dark mb-0">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H') }}</h5>
                                <small class="text-muted text-uppercase">JAM</small>
                            </div>
                            <div>
                                <h6 class="font-weight-bold text-primary mb-1">
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                </h6>
                                <span class="badge bg-success text-white">Sedang Aktif</span>
                                <div class="small text-muted mt-1">{{ $jadwal->hari }}</div>
                            </div>
                        </div>
                    @else
                        {{-- Jika Tidak Ada Jadwal --}}
                        <div class="text-center py-4 bg-light rounded dashed-border">
                            <i class="far fa-calendar-times fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Anda tidak memiliki jadwal praktek hari ini.</p>
                        </div>
                    @endif

                    <hr>
                    <a href="{{ route('jadwal-periksa.index') }}" class="btn btn-block btn-primary shadow-sm">
                        <i class="fas fa-cog mr-2"></i> Kelola Jadwal Lengkap
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection