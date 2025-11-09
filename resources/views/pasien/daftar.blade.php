{{-- File: resources/views/pasien/daftar.blade.php --}}
<x-layouts.app title="Daftar Poli">
    <div class="container-fluid px-4 mt-4">
        <div class="row">
            {{-- 
              DIUBAH: Mengubah class kolom agar lebih responsif.
              - col-lg-6 (Lebar 50% di layar besar)
              - offset-lg-3 (Ditengahkan di layar besar)
              - col-md-8 offset-md-2 (Lebih lebar di tablet)
              - (Otomatis full-width di HP)
            --}}
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                
                {{-- Alert flash message --}}
                @if (session('message'))
                    <div class="alert alert-{{ session('type', 'success') }} alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- DIUBAH: Membungkus form dengan 'card' --}}
                <div class="card custom-card">
                    <div class="card-header">
                         <h3 class="card-title" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Formulir Pendaftaran Poli</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Terjadi Kesalahan!</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pasien.daftar.submit') }}" method="POST">
                            @csrf
                            {{-- Mengirim id pasien secara tersembunyi --}}
                            <input type="hidden" name="id_pasien" value="{{ $user->id }}">

                            <div class="mb-3">
                                <label for="no_rm" class="form-label">Nomor Rekam Medis</label>
                                <input type="text" class="form-control" id="no_rm" name="no_rm"
                                    value="{{ $user->no_rm }}" readonly disabled> {{-- Dibuat readonly dan disabled --}}
                            </div>

                            <div class="mb-3">
                                <label for="selectPoli" class="form-label">Pilih Poli</label>
                                <select name="id_poli" id="selectPoli" class="form-control @error('id_poli') is-invalid @enderror">
                                    <option value="">-- Pilih Poli --</option>
                                    @foreach ($polis as $poli)
                                        <option value="{{ $poli->id }}">{{ $poli->nama_poli }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_poli')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="selectJadwal" class="form-label">Pilih Jadwal Periksa</label>
                                <select name="id_jadwal" id="selectJadwal" class="form-control @error('id_jadwal') is-invalid @enderror" required>
                                    <option value="">-- Pilih Poli terlebih dahulu --</option>
                                    @foreach ($jadwals as $jadwal)
                                        {{-- Menyimpan data poli di atribut data-* untuk JS --}}
                                        <option value="{{ $jadwal->id }}"
                                            data-id-poli="{{ $jadwal->dokter->poli->id ?? '' }}">
                                            {{-- Tampilkan Hari, Jam, dan Nama Dokter --}}
                                            {{ $jadwal->hari }} | 
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selai)->format('H:i') }} | 
                                            Dokter: {{ $jadwal->dokter->nama ?? '--' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_jadwal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keluhan" class="form-label">Keluhan</label>
                                <textarea name="keluhan" id="keluhan" rows="3" class="form-control @error('keluhan') is-invalid @enderror" required>{{ old('keluhan') }}</textarea>
                                @error('keluhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" name="submit" class="btn btn-success w-100"> {{-- DIUBAH: Tombol Daftar (Aksen Hijau) --}}
                                <i class="fas fa-check-circle"></i> Daftar Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

{{-- Script JS untuk filter dropdown (didorong ke layout utama) --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectPoli = document.getElementById('selectPoli');
        const selectJadwal = document.getElementById('selectJadwal');
        const defaultJadwalOption = '<option value="">-- Pilih Jadwal --</option>';
        const loadingJadwalOption = '<option value="">Memuat jadwal...</option>';

        // Simpan semua opsi jadwal asli
        const allJadwalOptions = Array.from(selectJadwal.options);

        function filterJadwal() {
            const poliId = selectPoli.value;
            
            // Kosongkan selectJadwal dan tambahkan opsi default
            selectJadwal.innerHTML = defaultJadwalOption;

            if (poliId) {
                // Filter opsi yang sesuai
                const filteredOptions = allJadwalOptions.filter(option => {
                    return option.dataset.idPoli === poliId;
                });

                // Tambahkan opsi yang sudah difilter ke selectJadwal
                filteredOptions.forEach(option => {
                    selectJadwal.appendChild(option.cloneNode(true));
                });
            } else {
                 // Jika tidak ada poli dipilih, tampilkan pesan default
                 selectJadwal.innerHTML = '<option value="">-- Pilih Poli terlebih dahulu --</option>';
            }
        }

        // Saat poli dipilih, filter jadwal
        selectPoli.addEventListener('change', filterJadwal);

        // Saat jadwal dipilih, isi poli otomatis jika belum
        selectJadwal.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            if (selected.value) {
                const poliId = selected.dataset.idPoli;
                if (!selectPoli.value && poliId) {
                    selectPoli.value = poliId;
                }
            }
        });

        // Inisialisasi filter saat halaman dimuat (jika poli sudah dipilih)
        filterJadwal();
    });
</script>
@endpush