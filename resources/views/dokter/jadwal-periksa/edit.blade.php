{{--resources/views/dokter/jadwal-periksa/edit.blade.php--}}
@extends('components.layouts.app')

{{-- Judul Halaman --}}
@section('header')
    Edit Jadwal Periksa
@endsection

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8">
            
            <div class="card border-0 shadow-sm">
                
                {{-- Card Header --}}
                <div class="card-header bg-white border-0 py-4">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-calendar-edit text-primary mr-2"></i> Formulir Edit Jadwal
                    </h3>
                </div>

                {{-- Form: Arahkan ke route 'update' dengan method PUT --}}
                <form action="{{ route('jadwal-periksa.update', $jadwalPeriksa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- Card Body --}}
                    <div class="card-body">
                        
                        {{-- Hari --}}
                        <div class="form-group mb-3">
                            <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
                            {{-- PERBAIKAN: 'form-select' (BS5) diubah ke 'form-control' (BS4) agar style-nya benar --}}
                            <select name="hari" id="hari" class="form-control @error('hari') is-invalid @enderror" required>
                                <option value="" disabled>Pilih Hari</option>
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}" 
                                        {{ (old('hari', $jadwalPeriksa->hari) == $day) ? 'selected' : '' }}>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hari') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            {{-- Jam Mulai --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="jam_mulai" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_mulai" id="jam_mulai"
                                           class="form-control @error('jam_mulai') is-invalid @enderror"
                                           value="{{ old('jam_mulai', $jadwalPeriksa->jam_mulai) }}" required>
                                    @error('jam_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            
                            {{-- Jam Selesai --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="jam_selesai" class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="jam_selesai" id="jam_selesai"
                                           class="form-control @error('jam_selesai') is-invalid @enderror"
                                           value="{{ old('jam_selesai', $jadwalPeriksa->jam_selesai) }}" required>
                                    @error('jam_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- FITUR BARU: Tombol Slot Cepat --}}
                        <div class="form-group mb-4">
                            <label class="form-label d-block text-muted">Atau, pilih slot cepat:</label>
                            <button type="button" class="btn btn-outline-primary rounded-pill" id="btn-pagi">
                                <i class="fas fa-sun mr-1"></i> Pagi (08:00 - 12:00)
                            </button>
                            <button type="button" class="btn btn-outline-primary rounded-pill" id="btn-sore">
                                <i class="fas fa-moon mr-1"></i> Sore (16:00 - 20:00)
                            </button>
                        </div>
                        
                        {{-- FITUR BARU: Status Aktif/Non-Aktif --}}
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status Jadwal <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="aktif" {{ (old('status', $jadwalPeriksa->status ?? 'aktif') == 'aktif') ? 'selected' : '' }}>
                                    Aktif (Menerima Pasien)
                                </option>
                                <option value="non-aktif" {{ (old('status', $jadwalPeriksa->status) == 'non-aktif') ? 'selected' : '' }}>
                                    Non-Aktif (Cuti / Libur)
                                </option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                    </div> {{-- /.card-body --}}
                    
                    {{-- Card Footer (Tombol) --}}
                    <div class="card-footer bg-white border-0 py-3 text-right">
                        <a href="{{ route('jadwal-periksa.index') }}" class="btn btn-outline-secondary rounded-pill mr-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill shadow-sm">
                            <i class="fas fa-save mr-2"></i> Update Jadwal
                        </button>
                    </div>

                </form> {{-- /form --}}
                
            </div> {{-- /.card --}}
        </div>
    </div>
</div>
@endsection

{{-- Script untuk tombol slot cepat --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fungsi untuk mengisi jam
        function setJam(mulai, selesai) {
            document.getElementById('jam_mulai').value = mulai;
            document.getElementById('jam_selesai').value = selesai;
        }

        // Event listener untuk tombol
        document.getElementById('btn-pagi').addEventListener('click', function () {
            setJam('08:00', '12:00');
        });

        document.getElementById('btn-sore').addEventListener('click', function () {
            setJam('16:00', '20:00');
        });
    });
</script>
@endpush