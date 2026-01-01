<aside class="main-sidebar sidebar-light-primary elevation-4 border-r-0">
    
    {{-- 1. BRAND LOGO --}}
    <a href="{{ url('/') }}" class="brand-link text-center pb-3 pt-3 border-bottom-0">
        <i class="fas fa-heartbeat text-primary fa-2x align-middle mr-2"></i>
        <span class="brand-text font-weight-bold text-primary" style="font-size: 1.3rem;">Poliklinik</span>
    </a>

    <div class="sidebar mt-2">
        
        {{-- 2. USER PANEL (MODERN) --}}
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center border-bottom-0">
            <div class="image">
                {{-- Avatar Inisial (Huruf Depan Nama) --}}
                <div class="img-circle elevation-1 d-flex justify-content-center align-items-center bg-primary text-white" 
                     style="width: 35px; height: 35px; font-weight: bold; font-size: 1.2rem;">
                    {{-- Ambil huruf pertama dari nama --}}
                    {{ substr(Auth::user()->nama ?? Auth::user()->name ?? 'U', 0, 1) }}
                </div>
            </div>
            <div class="info">
                <a href="#" class="d-block text-dark font-weight-medium" style="line-height: 1.2;">
                    {{ Auth::user()->nama ?? Auth::user()->name }} <br>
                    <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">
                        {{ Auth::user()->role }}
                    </small>
                </a>
            </div>
        </div>

        {{-- 3. MENU NAVIGASI --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                
                {{-- ======================================== --}}
                {{-- MENU ADMIN                               --}}
                {{-- ======================================== --}}
                @if (Auth::user()->role == 'admin')
                    <li class="nav-header text-uppercase text-muted font-weight-bold" style="font-size: 0.75rem;">Admin Utama</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-th-large"></i> {{-- Ikon Dashboard Modern --}}
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header text-uppercase text-muted font-weight-bold mt-2" style="font-size: 0.75rem;">Master Data</li>

                    <li class="nav-item">
                        <a href="{{ route('dokter.index') }}" class="nav-link {{ request()->routeIs('dokter.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>Dokter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pasien.index') }}" class="nav-link {{ request()->routeIs('pasien.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Pasien</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('polis.index') }}" class="nav-link {{ request()->routeIs('polis.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hospital"></i>
                            <p>Poli</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('obat.index') }}" class="nav-link {{ request()->routeIs('obat.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pills"></i>
                            <p>Obat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.riwayat_global') }}" class="nav-link {{ request()->routeIs('admin.riwayat_global') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-medical"></i>
                            <p>Riwayat Pasien</p>
                        </a>
                    </li>

                {{-- ======================================== --}}
                {{-- MENU PASIEN                              --}}
                {{-- ======================================== --}}
                @elseif (Auth::user()->role == 'pasien')
                    <li class="nav-header text-uppercase text-muted font-weight-bold" style="font-size: 0.75rem;">Menu Pasien</li>

                    <li class="nav-item">
                        <a href="{{ route('pasien.dashboard') }}" class="nav-link {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pasien.daftar') }}" class="nav-link {{ request()->routeIs('pasien.daftar') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-medical"></i>
                            <p>Daftar Poli</p>
                        </a>
                    </li>

                {{-- ======================================== --}}
                {{-- MENU DOKTER                              --}}
                {{-- ======================================== --}}
                {{-- MENU DOKTER --}}
                @elseif (Auth::user()->role == 'dokter')
                    <li class="nav-header text-uppercase text-muted font-weight-bold" style="font-size: 0.75rem;">Menu Dokter</li>

                    <li class="nav-item">
                        <a href="{{ route('dokter.dashboard') }}" class="nav-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-stethoscope"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jadwal-periksa.index') }}" class="nav-link {{ request()->routeIs('jadwal-periksa.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Jadwal Periksa</p>
                        </a>
                    </li>
                    
                    {{-- PERBAIKAN: Link Periksa Pasien --}}
                    <li class="nav-item">
                        {{-- BENAR: Arahkan ke route index periksa --}}
                        <a href="{{ route('periksa.index') }}" class="nav-link {{ request()->routeIs('periksa.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-injured"></i>
                            <p>Periksa Pasien</p>
                        </a>
                    </li>

                    {{-- PERBAIKAN: Link Riwayat Pasien (MODUL 14) --}}
                    <li class="nav-item">
                        <a href="{{ route('riwayat-pasien.index') }}" class="nav-link {{ request()->routeIs('riwayat-pasien.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Riwayat Pasien</p>
                        </a>
                    </li>
                @endif

                {{-- ======================================== --}}
                {{-- LOGOUT                                   --}}
                {{-- ======================================== --}}
                <li class="nav-header mt-4 border-top pt-2"></li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="nav-link text-danger"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p class="font-weight-bold">Logout</p>
                        </a>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>