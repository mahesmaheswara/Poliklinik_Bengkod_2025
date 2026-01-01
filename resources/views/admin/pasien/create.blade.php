{{-- File: resources/views/admin/pasien/create.blade.php --}}
@extends('components.layouts.app')

{{-- Judul Halaman --}}
@section('header')
    Tambah Pasien Baru
@endsection

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8"> {{-- Form 8 kolom agar tidak terlalu lebar --}}
            
            <div class="card border-0 shadow-sm">
                
                {{-- Card Header --}}
                <div class="card-header bg-white border-0 py-4">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-user-plus text-primary mr-2"></i> Formulir Pasien Baru
                    </h3>
                </div>

                {{-- Form: Arahkan ke route 'store' --}}
                <form action="{{ route('pasien.store') }}" method="POST">
                    @csrf
                    
                    {{-- Card Body --}}
                    <div class="card-body">
                        <div class="row">
                            {{-- Nama Pasien --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama" class="form-label">Nama Pasien <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" value="{{ old('nama') }}" required>
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- No KTP --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="no_ktp" class="form-label">No KTP <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('no_ktp') is-invalid @enderror"
                                           id="no_ktp" name="no_ktp" value="{{ old('no_ktp') }}" required>
                                    @error('no_ktp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- No HP --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="no_hp" class="form-label">No Hp <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('no_hp') is-invalid @enderror"
                                           id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                                    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="form-group mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea required name="alamat" id="alamat" rows="3"
                                      class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Password --}}
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror" required>
                            <small class="form-text text-muted">Minimal 8 karakter.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div> {{-- /.card-body --}}
                    
                    {{-- Card Footer (Tombol) --}}
                    <div class="card-footer bg-white border-0 py-3 text-right">
                        <a href="{{ route('pasien.index') }}" class="btn btn-outline-secondary rounded-pill mr-2">
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