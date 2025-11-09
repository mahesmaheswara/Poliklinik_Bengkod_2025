{{-- resources/views/auth/login.blade.php --}}
<x-layouts.guest title="Login">
    {{-- Kita tidak lagi menggunakan .login-box, tapi .auth-wrapper --}}
    <div class="auth-wrapper">

        <div class="auth-logo">
            <b>Poli</b>klinik
        </div>

        <div class="auth-card">
            <h3 class="auth-title">Login ke Akun Anda</h3>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                {{-- Tampilkan error di sini --}}
                @if ($errors->any())
                    <div class="auth-alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Form Email --}}
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="nama@email.com" required>
                </div>

                {{-- Form Password --}}
                <div class="form-group mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                </div>

                {{-- Tombol Login (Full-width) --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>

            <p class="auth-link">
                Belum punya akun? <a href="{{ route('register') }}">Register</a>
            </p>
        </div>
    </div>
</x-layouts.guest>