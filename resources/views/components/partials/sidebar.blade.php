{{-- views/components/partials/sidebar.blade.php (SUDAH DIPERBAIKI) --}}
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    {{-- Menambahkan data-widget="pushmenu" agar logo bisa diklik untuk slide --}}
    <a href="#" class="brand-link" data-widget="pushmenu" role="button">
        <span class="brand-text font-weight-light ">Poliklinik</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://www.gravatar.com/avatar/2c7d9f6f281ecd3bd65ab915bca6dd57s=100"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                {{-- Menggunakan Auth::user() untuk menampilkan nama dan role --}}
                <a href="#" class="d-block">Halo! {{ Auth::user()->nama }} ({{ Auth::user()->role }})</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                {{-- 
                  LOGIKA DIPERBAIKI: 
                  Menggunakan role pengguna, bukan URL (request()->is) 
                --}}

                @if (Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard Admin
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- NAMA ROUTE DIPERBAIKI: dokter.index -> dokters.index --}}
                        <a href="{{ route('dokter.index') }}"
                            class="nav-link {{ request()->routeIs('dokter.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>Manajemen Dokter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('polis.index') }}"
                            class="nav-link {{ request()->routeIs('polis.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hospital"></i>
                            <p>
                                Manajemen Poli
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pasien.index') }}"
                            class="nav-link {{ request()->routeIs('pasien.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-injured"></i>
                            <p>
                                Manajemen Pasien
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('obat.index') }}"
                            class="nav-link {{ request()->routeIs('obat.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pills"></i>
                            <p>
                                Manajemen Obat
                            </p>
                        </a>
                    </li>

                @elseif (Auth::user()->role == 'pasien')
                    <li class="nav-item">
                        <a href="{{ route('pasien.dashboard') }}" class="nav-link {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>
                                Dashboard Pasien
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pasien.daftar') }}"
                            class="nav-link {{ request()->routeIs('pasien.daftar') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hospital-user"></i>
                            <p>
                                Poli
                            </p>
                        </a>
                    </li>

                @elseif (Auth::user()->role == 'dokter')
                    <li class="nav-item">
                        <a href="{{ route('dokter.dashboard') }}" class="nav-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>
                                Dashboard Dokter
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jadwal-periksa.index') }}"
                            class="nav-link {{ request()->routeIs('jadwal-periksa.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>
                                Jadwal Periksa
                            </p>
                        </a>
                    </li>
                    
                    {{-- DIKOMENTARI: Untuk memperbaiki error RouteNotFoundException --}}
                    {{-- 
                    <li class="nav-item">
                        <a href="{{ route('periksa-pasien.index') }}"
                            class="nav-link {{ request()->routeIs('periksa-pasien.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-stethoscope"></i>
                            <p>
                                Periksa Pasien
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('riwayat-pasien.index') }}"
                            class="nav-link {{ request()->routeIs('riwayat-pasien[].*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>
                                Riwayat Pasien
                            </p>
                        </a>
                    </li>
                    --}}
                @endif

                <li class="nav-item ">
                    {{-- Ganti form action ke route 'logout' yang sudah diberi nama --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="nav-link btn btn-danger text-left w-100"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Keluar</p>
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
    
</aside>
