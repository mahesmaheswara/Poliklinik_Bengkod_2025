{{-- File: resources/views/admin/polis/index.blade.php --}}
@extends('components.layouts.app')

@section('header')
    Data Master Poli
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
                        <i class="fas fa-hospital text-primary mr-2"></i> Daftar Poli
                    </h3>
                    <a href="{{ route('polis.create') }}" class="btn btn-primary shadow-sm rounded-pill">
                        <i class="fas fa-plus mr-2"></i> Tambah Poli Baru
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
                                    <th>Nama Poli</th>
                                    <th>Keterangan</th>
                                    <th class="text-center" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop data $polis dari Controller --}}
                                @forelse ($polis as $poli)
                                    <tr>
                                        {{-- data-label="" penting untuk tampilan HP --}}
                                        <td data-label="No">{{ $loop->iteration }}</td>
                                        <td data-label="Nama Poli" class="font-weight-medium text-dark">{{ $poli->nama_poli }}</td>
                                        <td data-label="Keterangan" class="text-muted small">{{ Str::limit($poli->keterangan, 70) }}</td>
                                        <td data-label="Aksi" class="text-center">
                                            
                                            {{-- Form untuk Hapus --}}
                                            <form action="{{ route('polis.destroy', $poli->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                
                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('polis.edit', $poli->id) }}" class="btn btn-sm btn-warning rounded-circle" data-toggle="tooltip" title="Edit Data">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                
                                                {{-- Tombol Hapus --}}
                                                <button type="submit" class="btn btn-sm btn-danger rounded-circle" 
                                                        data-toggle="tooltip" title="Hapus Data"
                                                        onclick="return confirm('Yakin ingin menghapus poli {{ $poli->nama_poli }}?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    {{-- Tampilan jika data kosong --}}
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">
                                            <i class="fas fa-folder-open fa-3x mb-3 text-gray-300"></i>
                                            <p>Data poli masih kosong.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> {{-- /.card-body --}}
                
            </div> {{-- /.card --}}
        </div>
    </div>
</div>

{{-- Script auto-close alert SUDAH DIHAPUS karena tidak perlu lagi --}}
@endsection