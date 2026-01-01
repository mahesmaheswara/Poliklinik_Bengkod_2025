@extends('components.layouts.app')

@section('header')
    Riwayat Pasien
@endsection

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="card-title font-weight-bold text-dark">
                <i class="fas fa-history text-primary mr-2"></i> Daftar Riwayat Pemeriksaan
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th>Tanggal Periksa</th>
                            <th>Biaya Total</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPasien as $riwayat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $riwayat->daftarPoli->pasien->nama ?? '-' }}</td>
                                <td>{{ Str::limit($riwayat->daftarPoli->keluhan, 30) }}</td>
                                <td>{{ \Carbon\Carbon::parse($riwayat->tgl_periksa)->format('d M Y, H:i') }}</td>
                                <td class="font-weight-bold text-success">
                                    Rp {{ number_format($riwayat->biaya_periksa, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('riwayat-pasien.show', $riwayat->id) }}" 
                                       class="btn btn-sm btn-info text-white rounded-pill px-3 shadow-sm">
                                        <i class="fas fa-eye mr-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-gray-300"></i>
                                    <p>Belum ada riwayat pemeriksaan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection