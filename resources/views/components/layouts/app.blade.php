<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Poliklinik') }}</title>

    {{-- 1. FONTS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&family=Roboto+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    {{-- 2. STYLES --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/poliklinik-theme.css') }}?v=1.3">

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed poliklinik-theme">
    
    <div class="wrapper">

        {{-- PERBAIKAN 1: Path Include disesuaikan ke folder components --}}
        @include('components.partials.header') 
        @include('components.partials.sidebar')

        <div class="content-wrapper">
            
            {{-- PERBAIKAN 2: Menggunakan @hasSection & @yield untuk Header --}}
            @hasSection('header')
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">@yield('header')</h1>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <section class="content">
                <div class="container-fluid p-4">
                    
                    {{-- Alert Notifikasi Sukses --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Alert Notifikasi Error --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- 
                       PERBAIKAN 3 (PALING PENTING): 
                       Mengganti {{ $slot }} menjadi @yield('content') 
                       untuk menghilangkan error "Undefined variable $slot"
                    --}}
                    @yield('content')
                    
                </div>
            </section>
        </div>

        {{-- PERBAIKAN 4: Path Footer --}}
        @include('components.partials.footer')

    </div>
    {{-- ./wrapper --}}

    {{-- SCRIPTS DASAR --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    @stack('scripts')
</body>
</html>