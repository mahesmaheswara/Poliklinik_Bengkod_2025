{{-- Resources/views/admin/dashboard.blade.php --}}
<x-layouts.app title="Admin Dashboard">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        👑 Halo, Selamat Datang <span style="color: #4B9CD3;">Admin</span>!
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div><p class="m-0 text-muted">
                Kelola data sistem dengan bijak dan efisien ⚙️
            </p>
        </div></div>
    <section class="content">
        <div class="container-fluid">

            {{-- ========================================================== --}}
            {{-- BARIS KARTU STATISTIK (HTML BARU YANG MINIMALIS) --}}
            {{-- ========================================================== --}}
            <div class="row">
                {{-- Kartu Statistik Kustom 1 --}}
                <div class="col-lg-3 col-6">
                    <div class="card custom-stat-card">
                        <div class="card-body">
                            <div class="stat-info">
                                <h3 class="stat-number">150</h3>
                                <p class="stat-label">Pasien Hari Ini</p>
                            </div>
                            <div class="stat-icon" style="color: #4B9CD3;">
                                <i class="fas fa-user-injured"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kartu Statistik Kustom 2 --}}
                <div class="col-lg-3 col-6">
                    <div class="card custom-stat-card">
                        <div class="card-body">
                            <div class="stat-info">
                                <h3 class="stat-number">12</h3>
                                <p class="stat-label">Dokter Aktif</p>
                            </div>
                            <div class="stat-icon" style="color: #8FD19E;">
                                <i class="fas fa-user-md"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kartu Statistik Kustom 3 --}}
                <div class="col-lg-3 col-6">
                    <div class="card custom-stat-card">
                        <div class="card-body">
                            <div class="stat-info">
                                <h3 class="stat-number">5</h3>
                                <p class="stat-label">Stok Obat Menipis</p>
                            </div>
                            <div class="stat-icon" style="color: #FFB74D;">
                                <i class="fas fa-pills"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kartu Statistik Kustom 4 --}}
                <div class="col-lg-3 col-6">
                    <div class="card custom-stat-card">
                        <div class="card-body">
                            <div class="stat-info">
                                <h3 class="stat-number">80%</h3>
                                <p class="stat-label">Jadwal Poli Terisi</p>
                            </div>
                            <div class="stat-icon" style="color: #E57373;">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ========================================================== --}}
            {{-- BARIS GRAFIK (TETAP SAMA) --}}
            {{-- ========================================================== --}}
            <div class="row">
                <div class="col-lg-7">
                    <div class="card custom-card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Grafik Kunjungan Mingguan</h3>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <canvas id="weekly-visits-chart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card custom-card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Daftar Poli Terpopuler</h3>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                <canvas id="popular-poli-chart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Pesan error --}}
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <h5 class="alert-heading font-weight-bold">Terjadi Kesalahan:</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div></section>
    </x-layouts.app>

{{-- Mendorong script Chart.js ke layout utama --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data placeholder untuk grafik
    const weeklyData = {
        labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        datasets: [{
            label: 'Kunjungan Pasien',
            data: [65, 59, 80, 81, 56, 55, 40],
            fill: false,
            borderColor: '#8FD19E', // Warna aksen hijau
            tension: 0.1
        }]
    };
    const poliData = {
        labels: ['Poli Gigi', 'Poli Umum', 'Poli Anak', 'Poli Mata', 'Poli Jantung'],
        datasets: [{
            label: 'Jumlah Pasien',
            data: [12, 19, 3, 5, 2],
            backgroundColor: [
                '#4B9CD3', // Biru
                '#8FD19E', // Hijau
                '#FFB74D', // Oranye
                '#E57373', // Merah
                '#a29bfe'  // Ungu
            ],
            borderWidth: 1
        }]
    };
    // Inisialisasi Grafik
    document.addEventListener('DOMContentLoaded', (event) => {
        const ctxWeekly = document.getElementById('weekly-visits-chart');
        if(ctxWeekly) { new Chart(ctxWeekly, { type: 'line', data: weeklyData, options: { responsive: true, maintainAspectRatio: false } }); }
        const ctxPoli = document.getElementById('popular-poli-chart');
        if(ctxPoli) { new Chart(ctxPoli, { type: 'bar', data: poliData, options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } } }); }
    });
</script>
@endpush