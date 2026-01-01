@extends('components.layouts.app')

@section('header')
    Data Master Obat
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Card "Wadah" Utama --}}
            <div class="card border-0 shadow-sm">
                
                {{-- Card Header: Judul dan Tombol Action --}}
                <div class="card-header bg-white border-0 py-4 d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-pills text-primary mr-2"></i> Daftar Obat
                    </h3>
                    
                    {{-- Group Tombol (Cetak & Tambah) --}}
                    <div>
                        {{-- 1. Tombol Cetak PDF --}}
                        <a href="{{ route('obat.cetak') }}" target="_blank" class="btn btn-secondary shadow-sm rounded-pill mr-2">
                            <i class="fas fa-print mr-2"></i> Cetak PDF
                        </a>

                        {{-- 2. Tombol Tambah Obat --}}
                        <a href="{{ route('obat.create') }}" class="btn btn-primary shadow-sm rounded-pill">
                            <i class="fas fa-plus mr-2"></i> Tambah Obat
                        </a>
                    </div>
                </div>

                {{-- Card Body: Tabel Data --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Obat</th>
                                    <th>Kemasan</th>
                                    <th>Harga</th>
                                    <th>Stok</th> {{-- Kolom Header Stok --}}
                                    <th class="text-center" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($obats as $obat)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="font-weight-bold text-dark">{{ $obat->nama_obat }}</td>
                                        <td class="text-muted">{{ $obat->kemasan }}</td>
                                        <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                                        
                                        {{-- LOGIKA WARNA STOK --}}
                                        <td>
                                            @if($obat->stok <= 5)
                                                <span class="badge badge-danger p-2">
                                                    Habis/Menipis ({{ $obat->stok }})
                                                </span>
                                            @else
                                                <span class="badge badge-success p-2">
                                                    Aman ({{ $obat->stok }})
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                
                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-sm btn-warning rounded-circle shadow-sm mr-1" title="Edit">
                                                    <i class="fas fa-pen text-white"></i>
                                                </a>
                                                
                                                {{-- Tombol Hapus --}}
                                                <button type="submit" class="btn btn-sm btn-danger rounded-circle shadow-sm" 
                                                        title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus obat ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-box-open fa-3x mb-3"></i>
                                            <p>Belum ada data obat.</p>
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
@endsection