{{-- File: resources/views/admin/pasien/create.blade.php --}}
@extends('components.layouts.app')

{{-- Judul Halaman --}}
@section('header')
    Edit Data Pasien
@endsection

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8"> {{-- Form 8 kolom agar tidak terlalu lebar --}}
            
            <div class="card border-0 shadow-sm">
                
                {{-- Card Header --}}
                <div class="card-header bg-white border-0 py-4">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-user-edit text-primary mr-2"></i> Formulir Edit Pasien
                    </h3>
                </div>

                {{-- Form: Arahkan ke route 'update' dengan method PUT --}}
                <form action="{{ route('pasien.update', $pasien->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- Card Body --}}
                    <div class="card-body">
                        <div class="row">
                            {{-- Nama Pasien --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama" class="form-label">Nama Pasien <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" value="{{ old('nama', $pasien->nama) }}" required>
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $pasien->email) }}" required>
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
                                           id="no_ktp" name="no_ktp" value="{{ old('no_ktp', $pasien->no_ktp) }}" required>
                                    @error('no_ktp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- No HP --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="no_hp" class="form-label">No Hp <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('no_hp') is-invalid @enderror"
                                           id="no_hp" name="no_hp" value="{{ old('no_hp', $pasien->no_hp) }}" required>
                                    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="form-group mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea required name="alamat" id="alamat" rows="3"
                                      class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $pasien->alamat) }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Password (Dibuat Opsional) --}}
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password Baru (Opsional)</label>
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div> {{-- /.card-body --}}
                    
                    {{-- Card Footer (Tombol) --}}
                    <div class="card-footer bg-white border-0 py-3 text-right">
                        <a href="{{ route('pasien.index') }}" class="btn btn-outline-secondary rounded-pill mr-2">
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