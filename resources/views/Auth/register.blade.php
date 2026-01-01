<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pasien Baru - Poliklinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB', // Blue 600
                        secondary: '#1E40AF', // Blue 800
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <div class="min-h-screen flex flex-row-reverse">
        
        <div class="hidden lg:flex w-1/2 bg-blue-50 justify-center items-center relative sticky top-0 h-screen overflow-hidden">
            <div class="absolute inset-0 bg-secondary opacity-90 z-10"></div>
            <img src="https://img.freepik.com/free-photo/young-handsome-physician-medical-robe-with-stethoscope_1303-17818.jpg" 
                 alt="Medical Background" 
                 class="absolute inset-0 w-full h-full object-cover">
            
            <div class="relative z-20 text-white px-12 text-center">
                <h2 class="text-4xl font-bold mb-4">Bergabung Bersama Kami</h2>
                <p class="text-blue-100 text-lg">Nikmati kemudahan akses layanan kesehatan prioritas untuk Anda dan keluarga.</p>
            </div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-white/10 rounded-tl-full z-10"></div>
        </div>

        <div class="w-full lg:w-1/2 bg-white overflow-y-auto h-screen">
            <div class="flex justify-center items-center min-h-full p-8 sm:p-12 lg:p-16">
                <div class="w-full max-w-md space-y-6">
                    
                    <div class="text-center lg:text-left">
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-primary flex items-center justify-center lg:justify-start gap-2 mb-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Poliklinik
                        </a>
                        <h2 class="mt-4 text-3xl font-extrabold text-gray-900">Buat Akun Baru</h2>
                        <p class="mt-2 text-sm text-gray-600">
                            Lengkapi data diri Anda di bawah ini.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input:</h3>
                                    <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
                        @csrf

                        <div>
                            <label for="nama" class="text-sm font-medium text-gray-700 block mb-1">Nama Lengkap</label>
                            <input id="nama" name="nama" type="text" required autofocus
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition outline-none"
                                   placeholder="Sesuai KTP" value="{{ old('nama') }}">
                        </div>

                        <div>
                            <label for="alamat" class="text-sm font-medium text-gray-700 block mb-1">Alamat</label>
                            <input id="alamat" name="alamat" type="text" required
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition outline-none"
                                   placeholder="Alamat lengkap domisili" value="{{ old('alamat') }}">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="no_ktp" class="text-sm font-medium text-gray-700 block mb-1">No. KTP</label>
                                <input id="no_ktp" name="no_ktp" type="number" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition outline-none"
                                       placeholder="NIK 16 digit" value="{{ old('no_ktp') }}">
                            </div>
                            <div>
                                <label for="no_hp" class="text-sm font-medium text-gray-700 block mb-1">No. HP</label>
                                <input id="no_hp" name="no_hp" type="number" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition outline-none"
                                       placeholder="08xx-xxxx-xxxx" value="{{ old('no_hp') }}">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="text-sm font-medium text-gray-700 block mb-1">Alamat Email</label>
                            <input id="email" name="email" type="email" required
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition outline-none"
                                   placeholder="nama@email.com" value="{{ old('email') }}">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="text-sm font-medium text-gray-700 block mb-1">Password</label>
                                <input id="password" name="password" type="password" required autocomplete="new-password"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition outline-none"
                                       placeholder="Min. 8 karakter">
                            </div>
                            <div>
                                <label for="password_confirmation" class="text-sm font-medium text-gray-700 block mb-1">Ulangi Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition outline-none"
                                       placeholder="Konfirmasi">
                            </div>
                        </div>

                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition transform hover:-translate-y-0.5 mt-6">
                            Daftar Sekarang
                        </button>

                        <div class="text-center mt-4">
                            <p class="text-sm text-gray-600">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-secondary transition underline">
                                    Login di sini
                                </a>
                            </p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>