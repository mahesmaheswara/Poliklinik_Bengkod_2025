@extends('components.layouts.app')

@section('header')
    Data Master Dokter
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Card Utama --}}
            <div class="card border-0 shadow-sm">
                
                {{-- CARD HEADER: Judul & Group Tombol --}}
                <div class="card-header bg-white border-0 py-4 d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-user-md text-primary mr-2"></i> Daftar Dokter
                    </h3>
                    
                    {{-- Group Tombol Aksi --}}
                    <div>
                        {{-- 1. Tombol Cetak PDF --}}
                        <a href="{{ route('dokter.cetak') }}" target="_blank" class="btn btn-secondary shadow-sm rounded-pill mr-2">
                            <i class="fas fa-print mr-2"></i> Cetak PDF
                        </a>

                        {{-- 2. Tombol Tambah Dokter --}}
                        <a href="{{ route('dokter.create') }}" class="btn btn-primary shadow-sm rounded-pill">
                            <i class="fas fa-plus mr-2"></i> Tambah Dokter
                        </a>
                    </div>
                </div>
                
                {{-- CARD BODY: Tabel --}}
                <div class="card-body">
                    <div class="table-responsive table-responsive-stack">
                        <table class="table table-hover align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Dokter</th>
                                    <th>Poli</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                    <th class="text-center" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dokters as $index => $dokter)
                                    <tr>
                                        <td data-label="No">{{ $loop->iteration }}</td>
                                        
                                        <td data-label="Nama Dokter">
                                            <span class="font-weight-bold text-dark">{{ $dokter->nama }}</span>
                                            <br>
                                            <small class="text-muted">{{ $dokter->email }}</small>
                                        </td>
                                        
                                        <td data-label="Poli">
                                            <span class="badge badge-primary px-3 py-2 rounded-pill">
                                                {{ $dokter->poli->nama_poli ?? 'N/A' }}
                                            </span>
                                        </td>
                                        
                                        <td data-label="No. HP">{{ $dokter->no_hp }}</td>
                                        
                                        <td data-label="Alamat" class="text-muted small">
                                            {{ Str::limit($dokter->alamat, 40) }}
                                        </td>
                                        
                                        <td data-label="Aksi" class="text-center">
                                            <form action="{{ route('dokter.destroy', $dokter->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                
                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('dokter.edit', $dokter->id) }}" class="btn btn-sm btn-warning rounded-circle shadow-sm mr-1" title="Edit">
                                                    <i class="fas fa-pen text-white"></i>
                                                </a>
                                                
                                                {{-- Tombol Hapus --}}
                                                <button type="submit" class="btn btn-sm btn-danger rounded-circle shadow-sm" 
                                                        title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus dokter {{ $dokter->nama }}?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-user-md fa-3x mb-3 text-gray-300"></i>
                                            <p>Belum ada data dokter.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> {{-- End Card Body --}}
                
            </div>
        </div>
    </div>
</div>
@endsection