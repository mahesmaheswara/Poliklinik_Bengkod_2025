{{-- views/admin/polis/create.blade.php --}}
@extends('components.layouts.app')

{{-- Judul Halaman --}}
@section('header')
    Tambah Poli Baru
@endsection

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8"> {{-- Form 8 kolom agar tidak terlalu lebar --}}
            
            <div class="card border-0 shadow-sm">
                
                {{-- Card Header --}}
                <div class="card-header bg-white border-0 py-4">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-plus-circle text-primary mr-2"></i> Formulir Poli Baru
                    </h3>
                </div>

                {{-- Form: Arahkan ke route 'store' --}}
                <form action="{{ route('polis.store') }}" method="POST">
                    @csrf
                    
                    {{-- Card Body --}}
                    <div class="card-body">
                        
                        {{-- Nama Poli (Dibuat full-width) --}}
                        <div class="form-group mb-3">
                            <label for="nama_poli" class="form-label">Nama Poli <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_poli') is-invalid @enderror" 
                                   id="nama_poli" name="nama_poli" value="{{ old('nama_poli') }}" required>
                            @error('nama_poli') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Keterangan (Dibuat full-width) --}}
                        <div class="form-group mb-3">
                            <label for="keterangan" class="form-label">Keterangan <span class="text-danger">*</span></label>
                            <textarea required name="keterangan" id="keterangan" rows="4"
                                      class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                            @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                    </div> {{-- /.card-body --}}
                    
                    {{-- Card Footer (Tombol) --}}
                    <div class="card-footer bg-white border-0 py-3 text-right">
                        {{-- PERBAIKAN BUG: Mengarah ke polis.index, bukan dokter.index --}}
                        <a href="{{ route('polis.index') }}" class="btn btn-outline-secondary rounded-pill mr-2">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill shadow-sm">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                    </div>

                </form> {{-- /form --}}
                
            </div> {{-- /.card --}}
        </div>
    </div>
</div>
@endsection