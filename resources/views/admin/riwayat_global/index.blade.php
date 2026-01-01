@extends('components.layouts.app')

@section('header')
    Laporan Riwayat Pasien Global
@endsection

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="font-weight-bold mb-4">Rekapitulasi Pemeriksaan Seluruh Dokter</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No. Reg</th> {{-- Kolom ID Global Baru --}}
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter & Poli</th>
                            <th>Diagnosa</th>
                            <th>Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $r)
                        <tr>
                            <td><span class="badge badge-dark">{{ $r->no_registrasi }}</span></td>
                            <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="font-weight-bold">{{ $r->pasien->nama }}</div>
                                <small class="text-muted">RM: {{ $r->pasien->no_rm }}</small>
                            </td>
                            <td>
                                <div>{{ $r->jadwalPeriksa->dokter->nama }}</div>
                                <span class="badge badge-info">{{ $r->jadwalPeriksa->dokter->poli->nama_poli }}</span>
                            </td>
                            <td>
                                @if($r->periksa)
                                    "{{ $r->periksa->catatan }}" <br>
                                    @foreach($r->periksa->detailPeriksa as $d)
                                        <small class="text-success">• {{ $d->obat->nama_obat }}</small><br>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td class="font-weight-bold">
                                Rp {{ number_format($r->periksa->biaya_periksa ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">Belum ada data riwayat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection