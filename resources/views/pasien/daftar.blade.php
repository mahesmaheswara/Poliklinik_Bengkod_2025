@extends('components.layouts.app')

@section('header')
    Pendaftaran Poli
@endsection

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8">

            {{-- 1. KARTU PROFIL PASIEN --}}
            <div class="card border-0 shadow-sm mb-4 bg-light">
                <div class="card-body p-4 d-flex align-items-center">
                    <i class="fas fa-user-check fa-2x text-primary mr-3"></i>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0">Mendaftar sebagai: {{ Auth::user()->nama }}</h5>
                        <p class="text-muted mb-0">No. Rekam Medis: <strong>{{ Auth::user()->no_rm ?? 'N/A' }}</strong></p>
                    </div>
                </div>
            </div>

            {{-- 2. KARTU WIZARD FORM --}}
            <form action="{{ route('pasien.daftar.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="id_pasien" value="{{ Auth::user()->id }}">
                <input type="hidden" name="id_poli" id="input-id-poli">
                <input type="hidden" name="id_jadwal" id="input-id-jadwal">

                <div class="card border-0 shadow-sm">
                    
                    {{-- HEADER PROSES WIZARD --}}
                    <div class="card-header bg-white border-0 py-4">
                        <div class="d-flex justify-content-around text-center">
                            <div class="step-item active" id="step-indicator-1">
                                <div class="step-icon">1</div>
                                <div>Pilih Poli</div>
                            </div>
                            <div class="step-item" id="step-indicator-2">
                                <div class="step-icon">2</div>
                                <div>Pilih Jadwal</div>
                            </div>
                            <div class="step-item" id="step-indicator-3">
                                <div class="step-icon">3</div>
                                <div>Isi Keluhan</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">

                        {{-- Tampilkan Error Validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h5 class="alert-heading font-weight-bold">Oops! Ada yang salah:</h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- LANGKAH 1: PILIH POLI --}}
                        <div id="step-1-poli">
                            <h4 class="font-weight-bold text-dark text-center mb-4">Langkah 1: Pilih Poli Tujuan</h4>
                            <div class="row">
                                @forelse ($polis as $poli)
                                    <div class="col-md-6 mb-3">
                                        <button type="button" class="btn btn-outline-primary btn-block p-4 text-left poli-card" 
                                                data-id-poli="{{ $poli->id }}" 
                                                data-nama-poli="{{ $poli->nama_poli }}">
                                            <h5 class="font-weight-bold mb-1">{{ $poli->nama_poli }}</h5>
                                            <small>{{ $poli->keterangan }}</small>
                                        </button>
                                    </div>
                                @empty
                                    <div class="col-12 text-center text-muted">
                                        <p>Saat ini belum ada Poli yang tersedia.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- LANGKAH 2: PILIH JADWAL --}}
                        <div id="step-2-jadwal" style="display: none;">
                            <h4 class="font-weight-bold text-dark text-center mb-1">Langkah 2: Pilih Jadwal</h4>
                            <p class="text-center text-muted mb-4">Untuk <span class="badge badge-primary rounded-pill px-3 py-1" id="display-poli-nama"></span></p>
                            
                            <div id="jadwal-list" class="list-group">
                                {{-- Jadwal di-inject JS --}}
                            </div>
                            <p id="jadwal-kosong" class="text-center text-danger" style="display: none;">
                                Maaf, tidak ada jadwal dokter yang tersedia untuk poli ini.
                            </p>
                        </div>

                        {{-- LANGKAH 3: KELUHAN --}}
                        <div id="step-3-keluhan" style="display: none;">
                            <h4 class="font-weight-bold text-dark text-center mb-1">Langkah 3: Sampaikan Keluhan</h4>
                            <p class="text-center text-muted mb-4" id="display-jadwal-pilihan"></p>
                            
                            <div class="form-group mb-3">
                                <label for="keluhan" class="form-label">Tuliskan Keluhan Utama Anda <span class="text-danger">*</span></label>
                                <textarea name="keluhan" id="keluhan" rows="4" class="form-control @error('keluhan') is-invalid @enderror" 
                                          required placeholder="Contoh: Gigi saya sakit saat minum dingin...">{{ old('keluhan') }}</textarea>
                                @error('keluhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div> {{-- /.card-body --}}

                    {{-- Card Footer (Navigasi) --}}
                    <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary rounded-pill" id="btn-kembali" style="display: none;">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </button>
                        <button type="submit" class="btn btn-success rounded-pill shadow-sm" id="btn-submit" style="display: none; margin-left: auto;">
                            <i class="fas fa-check-circle mr-2"></i> Daftar Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #adb5bd;
        font-weight: 600;
        width: 100px;
    }
    .step-item .step-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #e9ecef;
        border: 2px solid #adb5bd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }
    .step-item.active {
        color: #2563EB;
    }
    .step-item.active .step-icon {
        background-color: #2563EB;
        color: white;
        border-color: #2563EB;
    }
    .poli-card, .jadwal-card {
        transition: all 0.2s ease-in-out;
    }
    .poli-card.active, .jadwal-card.active {
        background-color: #2563EB !important;
        color: white !important;
        border-color: #2563EB !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Pastikan kode berjalan setelah DOM siap
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- 1. DEFINISI VARIABEL (GLOBAL DALAM FUNGSI INI) ---
        const allJadwals = @json($jadwals ?? []);
        
        // Elemen Step
        const step1 = document.getElementById('step-1-poli');
        const step2 = document.getElementById('step-2-jadwal');
        const step3 = document.getElementById('step-3-keluhan');
        
        // Elemen Indikator
        const indicator1 = document.getElementById('step-indicator-1');
        const indicator2 = document.getElementById('step-indicator-2');
        const indicator3 = document.getElementById('step-indicator-3');
        
        // Elemen Tombol
        const btnKembali = document.getElementById('btn-kembali');
        const btnSubmit = document.getElementById('btn-submit');
        
        // Elemen Input & Display
        const inputPoli = document.getElementById('input-id-poli');
        const inputJadwal = document.getElementById('input-id-jadwal');
        const displayPoliNama = document.getElementById('display-poli-nama');
        const displayJadwalPilihan = document.getElementById('display-jadwal-pilihan');
        
        const jadwalList = document.getElementById('jadwal-list');
        const jadwalKosong = document.getElementById('jadwal-kosong');

        let currentStep = 1;

        // --- 2. FUNGSI NAVIGASI STEP (PERBAIKAN UTAMA DISINI) ---
        function goToStep(step) {
            // Sembunyikan semua step dulu
            step1.style.display = 'none';
            step2.style.display = 'none';
            step3.style.display = 'none';
            
            // Sembunyikan tombol dulu
            btnKembali.style.display = 'none';
            btnSubmit.style.display = 'none';
            
            // Reset indikator active
            indicator1.classList.remove('active');
            indicator2.classList.remove('active');
            indicator3.classList.remove('active');

            // Logika perpindahan
            if (step === 1) {
                step1.style.display = 'block';
                indicator1.classList.add('active');
                // Tidak ada tombol di step 1
            } else if (step === 2) {
                step2.style.display = 'block';
                indicator1.classList.add('active');
                indicator2.classList.add('active');
                btnKembali.style.display = 'block';
            } else if (step === 3) {
                step3.style.display = 'block';
                indicator1.classList.add('active');
                indicator2.classList.add('active');
                indicator3.classList.add('active');
                btnKembali.style.display = 'block';
                btnSubmit.style.display = 'block';
            }
            currentStep = step;
        }

        // --- 3. FUNGSI POPULATE JADWAL ---
        function populateJadwal(selectedPoliId) {
            jadwalList.innerHTML = '';
            jadwalKosong.style.display = 'none';

            // Filter data (Sesuai Logic Sukses Sebelumnya)
            const filteredJadwals = allJadwals.filter(jadwal => {
                const punyaDokter = jadwal.dokter != null;
                const punyaPoli = punyaDokter && jadwal.dokter.poli != null;
                // Ambil status dan ubah ke lowercase agar tidak case sensitive
                const statusAktif = jadwal.status && jadwal.status.toLowerCase() === 'aktif';

                // Syarat: Ada dokter, ada poli, poli ID cocok, dan status aktif
                return punyaDokter && punyaPoli && (jadwal.dokter.poli.id == selectedPoliId) && statusAktif;
            });

            // Jika kosong
            if (filteredJadwals.length === 0) {
                jadwalKosong.style.display = 'block';
                return;
            }

            // Render data
            filteredJadwals.forEach(jadwal => {
                const jamMulai = jadwal.jam_mulai.substring(0, 5);
                const jamSelesai = jadwal.jam_selesai.substring(0, 5);

                const html = `
                    <button type="button" class="list-group-item list-group-item-action jadwal-card" 
                            data-id-jadwal="${jadwal.id}" 
                            data-display-text="Dokter: ${jadwal.dokter.nama} (${jadwal.hari}, ${jamMulai}-${jamSelesai})">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1 font-weight-bold">Dokter: ${jadwal.dokter.nama}</h5>
                            <small class="text-success font-weight-bold">Tersedia</small>
                        </div>
                        <p class="mb-0"><strong>${jadwal.hari}</strong>, Pukul ${jamMulai} - ${jamSelesai} WIB</p>
                    </button>
                `;
                jadwalList.innerHTML += html;
            });

            // Pasang listener untuk kartu jadwal yang baru dibuat
            document.querySelectorAll('.jadwal-card').forEach(card => {
                card.addEventListener('click', function() {
                    const jadwalId = this.getAttribute('data-id-jadwal');
                    const displayText = this.getAttribute('data-display-text');
                    
                    inputJadwal.value = jadwalId;
                    displayJadwalPilihan.textContent = `Jadwal Pilihan: ${displayText}`;
                    
                    // Highlight selected
                    document.querySelectorAll('.jadwal-card').forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Pindah ke step 3
                    goToStep(3);
                });
            });
        }

        // --- 4. EVENT LISTENERS UTAMA ---
        
        // Listener Klik Kartu Poli
        document.querySelectorAll('.poli-card').forEach(card => {
            card.addEventListener('click', function() {
                const poliId = this.getAttribute('data-id-poli');
                const poliNama = this.getAttribute('data-nama-poli');

                inputPoli.value = poliId;
                displayPoliNama.textContent = poliNama;
                
                document.querySelectorAll('.poli-card').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                
                populateJadwal(poliId);
                goToStep(2); // Panggil fungsi pindah step
            });
        });

        // Listener Tombol Kembali
        btnKembali.addEventListener('click', function() {
            if (currentStep === 3) goToStep(2);
            else if (currentStep === 2) goToStep(1);
        });

    });
</script>
@endpush