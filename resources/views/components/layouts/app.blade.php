{{-- views/components/layout/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Dashboard' }}</title>

  {{-- BARU: Google Font (Sesuai Desain) --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@400;500;600;700&family=Roboto+Mono:wght@400;500&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  {{-- BARU: File CSS Kustom Kita (WAJIB ADA DI BAWAH) --}}
  <link rel="stylesheet" href="{{ asset('css/poliklinik-theme.css') }}">

  @stack('styles')
</head>
{{-- DIUBAH: Menambahkan class 'poliklinik-theme' untuk target CSS --}}
<body class="hold-transition sidebar-mini layout-fixed poliklinik-theme"> 
<div class="wrapper">

  {{-- Navbar --}}
  @include('components.partials.header')

  {{-- Sidebar --}}
  @include('components.partials.sidebar')

  {{-- Content --}}
  <div class="content-wrapper p-4">
    {{ $slot }}
  </div>

  {{-- Footer --}}
  @include('components.partials.footer')

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

@stack('scripts')
</body>
</html>