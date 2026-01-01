<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0 shadow-sm">
    
    {{-- 1. NAVBAR KIRI (Toggle Sidebar & Judul) --}}
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars text-primary"></i> {{-- Ikon Hamburger Biru --}}
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <span class="nav-link font-weight-bold text-dark">
                Sistem Informasi Poliklinik
            </span>
        </li>
    </ul>

    {{-- 2. NAVBAR KANAN --}}
    <ul class="navbar-nav ml-auto">

        {{-- Tanggal Hari Ini (Fitur Berguna untuk Dokter/Admin) --}}
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link text-secondary font-weight-medium">
                <i class="far fa-calendar-alt mr-1 text-primary"></i>
                {{ date('d F Y') }}
            </a>
        </li>

        {{-- Tombol Fullscreen --}}
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt text-secondary"></i>
            </a>
        </li>

        {{-- Dropdown Profil User (Baru) --}}
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <div class="d-flex align-items-center">
                    {{-- Tampilkan Nama User (Pendek) --}}
                    <span class="d-none d-md-inline mr-2 text-dark font-weight-medium">
                        {{ Auth::user()->nama ?? Auth::user()->name }}
                    </span>
                    {{-- Ikon User Bulat --}}
                    <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center text-white" 
                         style="width: 30px; height: 30px; font-size: 0.8rem;">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </a>
            
            {{-- Isi Dropdown --}}
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right border-0 shadow-lg rounded-lg mt-2">
                <span class="dropdown-item dropdown-header bg-light font-weight-bold">
                    {{ strtoupper(Auth::user()->role) }}
                </span>
                
                <div class="dropdown-divider"></div>
                
                {{-- Info Akun --}}
                <a href="#" class="dropdown-item">
                    <i class="fas fa-id-card mr-2 text-primary"></i> Lihat Profil
                </a>

                <div class="dropdown-divider"></div>

                {{-- Tombol Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar Aplikasi
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>