{{-- Resources/views/admin/dokter/edit.blade.php --}}
@extends('components.layouts.app')

{{-- Judul Halaman --}}
@section('header')
    Edit Data Dokter
@endsection

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8"> {{-- Form 8 kolom agar tidak terlalu lebar --}}
            
            <div class="card border-0 shadow-sm">
                
                {{-- Card Header --}}
                <div class="card-header bg-white border-0 py-4">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-user-edit text-primary mr-2"></i> Formulir Edit Dokter
                    </h3>
                </div>

                {{-- Form: Arahkan ke route 'update' dengan method PUT --}}
                <form action="{{ route('dokter.update', $dokter->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- Card Body --}}
                    <div class="card-body">
                        <div class="row">
                            {{-- Nama Dokter --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama" class="form-label">Nama Dokter <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" value="{{ old('nama', $dokter->nama) }}" required>
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $dokter->email) }}" required>
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
                                           id="no_ktp" name="no_ktp" value="{{ old('no_ktp', $dokter->no_ktp) }}" required>
                                    @error('no_ktp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- No HP --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('no_hp') is-invalid @enderror"
                                           id="no_hp" name="no_hp" value="{{ old('no_hp', $dokter->no_hp) }}" required>
                                    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="form-group mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea required name="alamat" id="alamat" rows="3"
                                      class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $dokter->alamat) }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            {{-- Poli --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="id_poli" class="form-label">Poli <span class="text-danger">*</span></label>
                                    <select name="id_poli" id="id_poli" class="form-control @error('id_poli') is-invalid @enderror" required>
                                        <option value="" disabled>Pilih Poli</option>
                                        @foreach ($polis as $poli)
                                            <option value="{{ $poli->id }}" {{-- Cek data lama (old) ATAU data dari database ($dokter) --}}
                                                {{ (string) old('id_poli', $dokter->id_poli) === (string) $poli->id ? 'selected' : '' }}>
                                                {{ $poli->nama_poli }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_poli') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            
                            {{-- Password (FIELD BARU YANG HILANG) --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Password Baru (Opsional)</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                    </div> {{-- /.card-body --}}
                    
                    {{-- Card Footer (Tombol) --}}
                    <div class="card-footer bg-white border-0 py-3 text-right">
                        <a href="{{ route('dokter.index') }}" class="btn btn-outline-secondary rounded-pill mr-2">
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