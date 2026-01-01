@extends('components.layouts.app')

@section('header')
    Daftar Pemeriksaan Pasien
@endsection

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="card-title font-weight-bold text-dark mb-0">
                <i class="fas fa-stethoscope text-primary mr-2"></i> Pasien Menunggu Pemeriksaan
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-primary">
                        <tr>
                            <th>No Urut</th>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pasienMenunggu as $pasien)
                            <tr>
                                <td>
                                    <span class="badge badge-primary rounded-circle p-2" style="width: 30px; height: 30px;">
                                        {{ $pasien->no_antrian }}
                                    </span>
                                </td>
                                <td class="font-weight-bold">{{ $pasien->pasien->nama }}</td>
                                <td class="text-muted">{{ $pasien->keluhan }}</td>
                                <td>
                                    {{-- Tombol ini mengarah ke route CREATE yg pake ID --}}
                                    <a href="{{ route('periksa.create', $pasien->id) }}" class="btn btn-success btn-sm rounded-pill px-3">
                                        <i class="fas fa-user-md mr-1"></i> Periksa Sekarang
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-couch fa-3x mb-3 text-gray-300"></i>
                                    <p>Tidak ada pasien yang menunggu saat ini.</p>
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