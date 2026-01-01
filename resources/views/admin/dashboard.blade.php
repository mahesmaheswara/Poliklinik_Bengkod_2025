@extends('components.layouts.app')

@section('header')
    Dashboard Admin
@endsection

@section('content')
<div class="container-fluid">
    
    {{-- 1. WELCOME BANNER (Banner Selamat Datang) --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-white border-0 shadow-sm" style="border-left: 5px solid #4B9CD3 !important;">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h2 class="font-weight-bold text-dark mb-1" style="font-family: 'Poppins', sans-serif;">
                            Halo, Admin! 👋
                        </h2>
                        <p class="text-muted mb-0">
                            Selamat datang kembali di panel kontrol. Berikut adalah ringkasan aktivitas hari ini.
                        </p>
                    </div>
                    <div class="d-none d-md-block">
                        {{-- Hiasan Tanggal di kanan --}}
                        <div class="text-right">
                            <h5 class="font-weight-bold text-primary mb-0">{{ date('d') }}</h5>
                            <span class="text-uppercase text-muted small">{{ date('F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. STATS CARDS (Kartu Statistik Real-time) --}}
    <div class="row">
        {{-- Kartu 1: Total Dokter --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white text-dark custom-stat-card p-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-primary">{{ $totalDokter ?? 0 }}</h3>
                    <p class="text-muted font-weight-medium">Total Dokter</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-md text-primary opacity-25"></i>
                </div>
            </div>
        </div>

        {{-- Kartu 2: Total Pasien --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white text-dark custom-stat-card p-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-success">{{ $totalPasien ?? 0 }}</h3>
                    <p class="text-muted font-weight-medium">Pasien Terdaftar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users text-success opacity-25"></i>
                </div>
            </div>
        </div>

        {{-- Kartu 3: Total Poli --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white text-dark custom-stat-card p-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-warning">{{ $totalPoli ?? 0 }}</h3>
                    <p class="text-muted font-weight-medium">Layanan Poli</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hospital text-warning opacity-25"></i>
                </div>
            </div>
        </div>

        {{-- Kartu 4: Total Obat --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-white text-dark custom-stat-card p-3">
                <div class="inner">
                    <h3 class="font-weight-bold text-danger">{{ $totalObat ?? 0 }}</h3>
                    <p class="text-muted font-weight-medium">Stok Obat</p>
                </div>
                <div class="icon">
                    <i class="fas fa-pills text-danger opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. GRAFIK & AKTIVITAS (Charts) --}}
    <div class="row mt-3">
        
        {{-- Grafik Kiri: Statistik Kunjungan (Line Chart) --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h3 class="card-title font-weight-bold text-dark">
                        <i class="fas fa-chart-line text-primary mr-2"></i> Statistik Kunjungan
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="weekly-visits-chart" height="250"></canvas>
                </div>
            </div>
        </div>

        {{-- Grafik Kanan: Poli Terpopuler (Doughnut Chart) --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h3 class="card-title font-weight-bold text-dark">
                        <i class="fas fa-chart-pie text-success mr-2"></i> Poli Terpopuler
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="popular-poli-chart" height="250"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

{{-- Script Khusus Halaman Ini (Versi Real Data Database) --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // =================================================================
        // 1. TANGKAP DATA DARI CONTROLLER (Blade ke JavaScript)
        // =================================================================
        // Kita pakai json_encode biar aman dari error syntax
        const labelKunjungan = {!! json_encode($chartKunjunganLabels ?? []) !!};
        const dataKunjungan  = {!! json_encode($chartKunjunganData ?? []) !!};
        
        const labelPoli = {!! json_encode($chartPoliLabels ?? []) !!};
        const dataPoli  = {!! json_encode($chartPoliData ?? []) !!};

        // Cek di Console Browser (F12) untuk memastikan data masuk
        console.log('Data Kunjungan:', labelKunjungan, dataKunjungan);
        console.log('Data Poli:', labelPoli, dataPoli);

        // =================================================================
        // 2. RENDER GRAFIK KUNJUNGAN (Line Chart)
        // =================================================================
        const ctxVisit = document.getElementById('weekly-visits-chart').getContext('2d');
        new Chart(ctxVisit, {
            type: 'line',
            data: {
                // Jika data kosong, pakai label default biar grafik gak error
                labels: labelKunjungan.length ? labelKunjungan : ['Belum ada Data'],
                datasets: [{
                    label: 'Jumlah Pasien',
                    // Gunakan data dari database, bukan angka 12, 19, 25 lagi!
                    data: dataKunjungan.length ? dataKunjungan : [0], 
                    borderColor: '#4B9CD3',
                    backgroundColor: 'rgba(75, 156, 211, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { stepSize: 1 } // Biar sumbu Y bilangan bulat (orang)
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // =================================================================
        // 3. RENDER GRAFIK POLI (Doughnut Chart)
        // =================================================================
        const ctxPoli = document.getElementById('popular-poli-chart').getContext('2d');
        // Warna-warni grafik
        const colors = ['#4B9CD3', '#8FD19E', '#FFB74D', '#E57373', '#9575CD'];

        new Chart(ctxPoli, {
            type: 'doughnut',
            data: {
                labels: labelPoli.length ? labelPoli : ['Belum ada Data'],
                datasets: [{
                    data: dataPoli.length ? dataPoli : [1], // Dummy 1 biar muncul abu-abu kalau kosong
                    backgroundColor: dataPoli.length ? colors : ['#e0e0e0'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                }
            }
        });
    });
</script>
@endpush