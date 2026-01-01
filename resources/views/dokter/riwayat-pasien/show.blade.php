@extends('components.layouts.app')

@section('header')
    Detail Pemeriksaan
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <a href="{{ route('riwayat-pasien.index') }}" class="btn btn-outline-secondary mb-3 rounded-pill">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>

            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white py-3 rounded-top">
                    <h5 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-file-medical-alt mr-2"></i> Laporan Pemeriksaan
                    </h5>
                </div>
                <div class="card-body p-5">
                    
                    {{-- HEADER STRUK --}}
                    <div class="row mb-4 border-bottom pb-4">
                        <div class="col-md-6">
                            <h4 class="font-weight-bold text-dark">POLIKLINIK DIGITAL</h4>
                            <p class="text-muted mb-0">Laporan Hasil Pemeriksaan Medis</p>
                        </div>
                        <div class="col-md-6 text-md-right mt-3 mt-md-0">
                            <h5 class="text-muted">Tanggal Periksa</h5>
                            <h5 class="font-weight-bold text-dark">
                                {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d F Y, H:i') }} WIB
                            </h5>
                        </div>
                    </div>

                    {{-- INFO PASIEN & DOKTER --}}
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small font-weight-bold mb-2">Data Pasien</h6>
                            <div class="p-3 bg-light rounded">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td width="100" class="text-muted">Nama</td>
                                        <td class="font-weight-bold">{{ $periksa->daftarPoli->pasien->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">No. RM</td>
                                        <td class="font-weight-bold">{{ $periksa->daftarPoli->pasien->no_rm ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Keluhan</td>
                                        <td>"{{ $periksa->daftarPoli->keluhan }}"</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <h6 class="text-uppercase text-muted small font-weight-bold mb-2">Dokter Pemeriksa</h6>
                            <div class="p-3 bg-light rounded">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td width="100" class="text-muted">Nama</td>
                                        <td class="font-weight-bold">{{ $periksa->daftarPoli->jadwalPeriksa->dokter->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Poli</td>
                                        <td class="font-weight-bold">{{ $periksa->daftarPoli->jadwalPeriksa->dokter->poli->nama_poli }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- HASIL DIAGNOSA --}}
                    <div class="mb-5">
                        <h6 class="text-uppercase text-primary small font-weight-bold mb-2">Catatan / Diagnosa Dokter</h6>
                        <div class="p-4 rounded border border-primary bg-white">
                            <p class="mb-0 text-dark" style="font-size: 1.1rem;">
                                {{ $periksa->catatan }}
                            </p>
                        </div>
                    </div>

                    {{-- RESEP OBAT & BIAYA --}}
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small font-weight-bold mb-3">Rincian Biaya & Obat</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Nama Obat / Layanan</th>
                                        <th>Kemasan</th>
                                        <th class="text-right">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- List Obat --}}
                                    @foreach($periksa->detailPeriksas as $detail)
                                        <tr>
                                            <td>{{ $detail->obat->nama_obat }}</td>
                                            <td>{{ $detail->obat->kemasan }}</td>
                                            <td class="text-right">Rp {{ number_format($detail->obat->harga, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    
                                    {{-- Biaya Jasa --}}
                                    <tr>
                                        <td colspan="2" class="text-dark font-weight-medium">Biaya Jasa Pemeriksaan</td>
                                        <td class="text-right font-weight-medium">Rp 150.000</td>
                                    </tr>
                                    
                                    {{-- Total --}}
                                    <tr class="bg-primary text-white">
                                        <td colspan="2" class="font-weight-bold text-uppercase text-right">Total Tagihan</td>
                                        <td class="text-right font-weight-bold" style="font-size: 1.2rem;">
                                            Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection