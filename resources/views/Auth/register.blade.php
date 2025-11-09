{{-- resources/views/auth/register.blade.php --}}
<x-layouts.guest title="Register">
    <div class="auth-wrapper">

        <div class="auth-logo">
            <b>Poli</b>klinik
        </div>

        <div class="auth-card">
            <h3 class="auth-title">Buat Akun Baru</h3>

            <form action="{{ route('register') }}" method="POST">
                @csrf

                {{-- Tampilkan error validasi di sini --}}
                @if ($errors->any())
                    <div class="auth-alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form Nama Lengkap --}}
                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>
                
                {{-- Form Alamat --}}
                <div class="form-group mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat') }}" required>
                </div>

                {{-- Split KTP & No. HP --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="no_ktp" class="form-label">No. KTP</label>
                            <input type="text" name="no_ktp" id="no_ktp" class="form-control" value="{{ old('no_ktp') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="no_hp" class="form-label">No. HP</label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
                        </div>
                    </div>
                </div>

                {{-- Form Email --}}
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                
                {{-- Form Password --}}
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                
                {{-- Form Konfirmasi Password --}}
                <div class="form-group mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                {{-- Tombol Register (Full-width) --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
            </form>

            <p class="auth-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </p>
        </div>
    </div>
</x-layouts.guest>