{{-- Resources/views/admin/obat/edit.blade.php --}}
@extends('components.layouts.app')

{{-- Judul Halaman --}}
@section('header')
    Edit Data Obat
@endsection

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8"> {{-- Form 8 kolom agar tidak terlalu lebar --}}
            
            <div class="card border-0 shadow-sm">
                
                {{-- Card Header --}}
                <div class="card-header bg-white border-0 py-4">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-edit text-primary mr-2"></i> Formulir Edit Obat
                    </h3>
                </div>

                {{-- Form: Arahkan ke route 'update' dengan method PUT --}}
                <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- Card Body --}}
                    <div class="card-body">
                        <div class="row">
                            {{-- Nama Obat --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama_obat" class="form-label">Nama Obat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" 
                                           id="nama_obat" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                                    @error('nama_obat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Kemasan --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="kemasan" class="form-label">Kemasan <span class="text-danger">*</span></label>
                                    {{-- PERBAIKAN: type="kemasan" tidak valid, diubah ke "text" --}}
                                    <input type="text" class="form-control @error('kemasan') is-invalid @enderror"
                                           id="kemasan" name="kemasan" value="{{ old('kemasan', $obat->kemasan) }}" required
                                           placeholder="Contoh: 10 strip @ 10 tablet">
                                    @error('kemasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Harga --}}
                        <div class="form-group mb-3">
                            <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                            {{-- Tambahan: Input group agar ada tulisan "Rp" --}}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="harga" id="harga"
                                       class="form-control @error('harga') is-invalid @enderror" 
                                       value="{{ old('harga', $obat->harga) }}" required min="0" step="1">
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div> {{-- /.card-body --}}
                    
                    {{-- Card Footer (Tombol) --}}
                    <div class="card-footer bg-white border-0 py-3 text-right">
                        <a href="{{ route('obat.index') }}" class="btn btn-outline-secondary rounded-pill mr-2">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill shadow-sm">
                            <i class="fas fa-save mr-2"></i> Update Data
                        </button>
                    </div>

                </form> {{-- /form --}}
                
            </div> {{-- /.card --}}
        </div>
    </div>
</div>
@endsection