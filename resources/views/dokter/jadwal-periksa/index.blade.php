{{-- File: resources/views/dokter/jadwal-periksa/index.blade.php --}}
@extends('components.layouts.app')

@section('header')
    Kelola Jadwal Periksa
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Card "Wadah" Utama --}}
            <div class="card border-0 shadow-sm">
                
                {{-- Card Header: Judul dan Tombol Tambah --}}
                <div class="card-header bg-white border-0 py-4 d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-calendar-alt text-primary mr-2"></i> Jadwal Periksa Saya
                    </h3>
                    <a href="{{ route('jadwal-periksa.create') }}" class="btn btn-primary shadow-sm rounded-pill">
                        <i class="fas fa-plus mr-2"></i> Tambah Jadwal Baru
                    </a>
                </div>

                {{-- Card Body: Tabel Data --}}
                <div class="card-body">
                    
                    {{-- Alert Lokal SUDAH DIHAPUS, Global Alert di app.blade.php akan menanganinya --}}

                    <div class="table-responsive table-responsive-stack">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Jam Praktek</th>
                                    <th>Status</th> {{-- Kolom Baru Pembeda --}}
                                    <th class="text-center" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop data $jadwalPeriksas dari Controller --}}
                                @forelse ($jadwalPeriksas as $jadwalPeriksa)
                                    <tr>
                                        <td data-label="No">{{ $loop->iteration }}</td>
                                        <td data-label="Hari" class="font-weight-medium text-dark">{{ $jadwalPeriksa->hari }}</td>
                                        <td data-label="Jam Praktek" style="font-family: 'Roboto Mono', monospace;">
                                            {{ \Carbon\Carbon::parse($jadwalPeriksa->jam_mulai)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($jadwalPeriksa->jam_selesai)->format('H:i') }}
                                        </td>
                                        
                                        {{-- Menampilkan Status Aktif/Non-Aktif --}}
                                        <td data-label="Status">
                                            @if($jadwalPeriksa->status == 'aktif')
                                                <span class="badge badge-success rounded-pill">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary rounded-pill">Non-Aktif</span>
                                            @endif
                                        </td>
                                        
                                        <td data-label="Aksi" class="text-center">
                                            <form action="{{ route('jadwal-periksa.destroy', $jadwalPeriksa->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                
                                                <a href="{{ route('jadwal-periksa.edit', $jadwalPeriksa->id) }}" class="btn btn-sm btn-warning rounded-circle" data-toggle="tooltip" title="Edit Jadwal">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                
                                                <button type="submit" class="btn btn-sm btn-danger rounded-circle" 
                                                        data-toggle="tooltip" title="Hapus Jadwal"
                                                        onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Tampilan jika data kosong --}}
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            <i class="fas fa-folder-open fa-3x mb-3 text-gray-300"></i>
                                            <p>Anda belum menambahkan jadwal periksa.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> {{-- /.card-body --}}
                
                {{-- 
                   BAGIAN PAGINATION DIHAPUS 
                   untuk mencegah error 'hasPages' jika Controller Anda menggunakan ->get()
                --}}
                
            </div> {{-- /.card --}}
        </div>
    </div>
</div>

{{-- Script auto-close alert SUDAH DIHAPUS karena tidak perlu lagi --}}
@endsection