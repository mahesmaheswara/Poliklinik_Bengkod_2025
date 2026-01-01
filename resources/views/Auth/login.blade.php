<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Poliklinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB',
                        secondary: '#1E40AF',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <div class="min-h-screen flex">
        <div class="hidden lg:flex w-1/2 bg-blue-600 i justify-center items-center relative overflow-hidden">
            <div class="absolute inset-0 bg-primary opacity-90 z-10"></div>
            <img src="https://img.freepik.com/free-photo/medical-banner-with-doctor-working-laptop_23-2149611193.jpg" 
                 alt="Doctor" 
                 class="absolute inset-0 w-full h-full object-cover">
            
            <div class="relative z-20 text-white px-12 text-center">
                <h2 class="text-4xl font-bold mb-4">Selamat Datang Kembali</h2>
                <p class="text-blue-100 text-lg">Akses dashboard kesehatan Anda dengan mudah dan aman.</p>
            </div>
            
            <div class="absolute -bottom-32 -left-40 w-80 h-80 border-4 border-white/20 rounded-full z-10"></div>
            <div class="absolute -top-40 -right-0 w-96 h-96 border-4 border-white/20 rounded-full z-10"></div>
        </div>

        <div class="w-full lg:w-1/2 flex justify-center items-center bg-white p-8 sm:p-12 lg:p-24">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center lg:text-left">
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-primary flex items-center justify-center lg:justify-start gap-2 mb-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Poliklinik
                    </a>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Masuk ke Akun</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-medium text-primary hover:text-secondary transition">Daftar Pasien Baru</a>
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-4 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium text-gray-700 block">Email / No. Rekam Medis</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition outline-none" 
                               placeholder="nama@email.com"
                               value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="password" class="text-sm font-medium text-gray-700 block">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">Lupa password?</a>
                            @endif
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition outline-none" 
                               placeholder="••••••••">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">Ingat saya</label>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition transform hover:-translate-y-0.5">
                        Masuk Sekarang
                    </button>
                    
                    <div class="text-center mt-6">
                        <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-gray-900 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>