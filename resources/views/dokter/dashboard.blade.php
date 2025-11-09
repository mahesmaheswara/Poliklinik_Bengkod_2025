{{-- resources/views/dokter/dashboard.blade.php --}}
<x-layouts.app title="Dokter Dashboard">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Dashboard Dokter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            
            {{-- Kartu Selamat Datang (Ringkasan) --}}
            <div class="row">
                <div class="col-12">
                    <div class="card custom-card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h4 class="card-title" style="font-weight: 600;">👨‍⚕️ Selamat Datang, {{ Auth::user()->nama }}!</h4>
                            <p class="card-text text-muted">Fokus Anda hari ini adalah antrian pasien dan jadwal praktek Anda.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- ========================================================== --}}
                {{-- KOLOM KIRI: ANTRIAN PASIEN (Sesuai Desain) --}}
                {{-- ========================================================== --}}
                <div class="col-lg-8">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h3 class="card-title">Antrian Pasien Hari Ini</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No. Antrian</th>
                                            <th>Nama Pasien</th>
                                            <th>Keluhan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- 
                                          CATATAN: Ini membutuhkan variabel $antrianPasien 
                                          dari Controller Anda (DokterController@dashboard)
                                        --}}
                                        @forelse ($antrianPasien ?? [] as $antrian)
                                            <tr>
                                                <td><span class="badge bg-primary" style="font-size: 1rem;">{{ $antrian->no_antrian }}</span></td>
                                                <td>{{ $antrian->pasien->nama ?? 'Pasien Tidak Ditemukan' }}</td>
                                                <td>{{ Str::limit($antrian->keluhan, 30) }}</td>
                                                <td>
                                                    {{-- Status Sesuai Desain --}}
                                                    @if($antrian->status == 'menunggu')
                                                        <span class="badge" style="background-color: #FFB74D; color: #fff;">Menunggu</span>
                                                    @elseif($antrian->status == 'diperiksa')
                                                        <span class="badge" style="background-color: #4B9CD3; color: #fff;">Diperiksa</span>
                                                    @else
                                                        <span class="badge" style="background-color: #8FD19E; color: #2A5D8F;">Selesai</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- Link Periksa Pasien (Shortcut) --}}
                                                    {{-- Pastikan route 'periksa-pasien.index' sudah Anda aktifkan kembali --}}
                                                    {{-- 
                                                    <a href="{{ route('periksa-pasien.index', ['id_pasien' => $antrian->id_pasien]) }}" class="btn btn-success btn-sm">
                                                        <i class="fas fa-stethoscope"></i> Periksa
                                                    </a>
                                                    --}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted p-4">
                                                    Belum ada pasien dalam antrian hari ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========================================================== --}}
                {{-- KOLOM KANAN: JADWAL PRAKTEK (Sesuai Desain) --}}
                {{-- ========================================================== --}}
                <div class="col-lg-4">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h3 class="card-title">Jadwal Praktek Anda Hari Ini</h3>
                        </div>
                        <div class="card-body">
                            {{-- 
                              CATATAN: Ini membutuhkan variabel $jadwalHariIni 
                              dari Controller Anda (DokterController@dashboard)
                            --}}
                            @forelse ($jadwalHariIni ?? [] as $jadwal)
                                <div class="info-box shadow-sm mb-3">
                                    <span class="info-box-icon bg-info"><i class="fas fa-calendar-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text" style="font-weight: 600;">{{ $jadwal->hari }}</span>
                                        <span class="info-box-number" style="font-family: 'Roboto Mono', monospace;">
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-muted">Tidak ada jadwal praktek hari ini.</p>
                            @endforelse

                            <a href="{{ route('jadwal-periksa.index') }}" class="btn btn-outline-primary btn-block mt-3">
                                <i class="fas fa-edit"></i> Kelola Semua Jadwal
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    </x-layouts.app>