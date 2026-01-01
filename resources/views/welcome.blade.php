<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Poliklinik') }} - Layanan Kesehatan Digital</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB', // Bisa diganti kode hex lain
                        secondary: '#1E40AF',
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased font-sans text-gray-700 bg-gray-50">

    <nav class="bg-white/90 backdrop-blur-md shadow-sm fixed w-full z-50 top-0 start-0 border-b border-gray-200 transition-all duration-300" id="navbar">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse group">
                <div class="bg-primary p-2 rounded-lg shadow-lg group-hover:scale-110 transition transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <span class="self-center text-2xl font-bold whitespace-nowrap text-primary tracking-tight">Poliklinik</span>
            </a>
            
            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" id="menu-toggle">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/></svg>
            </button>

            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <div class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white bg-primary hover:bg-secondary focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all shadow-lg">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary md:p-0 transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-white bg-primary hover:bg-secondary focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-6 py-2.5 text-center transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 mt-2 md:mt-0">Daftar Pasien</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
        <div class="hidden md:hidden bg-white border-t px-4 py-4 space-y-3 shadow-lg" id="mobile-menu-content">
             <a href="#home" class="block text-gray-700 hover:text-primary font-medium">Beranda</a>
             <a href="#poli" class="block text-gray-700 hover:text-primary font-medium">Layanan</a>
             <a href="#alur" class="block text-gray-700 hover:text-primary font-medium">Alur Daftar</a>
        </div>
    </nav>

    <section id="home" class="bg-gradient-to-b from-blue-50 to-white min-h-screen flex items-center pt-24 md:pt-0 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-200 mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 left-0 -ml-20 -mt-20 w-72 h-72 rounded-full bg-purple-200 mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 relative z-10">
            <div class="mr-auto place-self-center lg:col-span-7 text-center lg:text-left" data-aos="fade-up" data-aos-duration="1000">
                <span class="bg-blue-100 text-primary text-xs font-bold px-3 py-1 rounded-full mb-4 inline-block">Sistem Poliklinik Digital</span>
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl text-gray-900">
                    Solusi Sehat Tanpa <br><span class="text-primary">Menunggu Lama.</span>
                </h1>
                <p class="max-w-2xl mb-8 font-light text-gray-600 lg:mb-8 md:text-lg lg:text-xl">
                    Nikmati kemudahan akses layanan kesehatan. Daftar antrean dari rumah dan pantau jadwal dokter secara real-time.
                </p>
                <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center lg:justify-start sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3.5 text-base font-medium text-center text-white rounded-lg bg-primary hover:bg-secondary focus:ring-4 focus:ring-blue-300 transition transform hover:scale-105 shadow-lg">
                        Ambil Antrean
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex justify-center" data-aos="fade-left" data-aos-duration="1200">
                <img src="https://img.freepik.com/free-vector/health-professional-team-concept-illustration_114360-1618.jpg" alt="Medical Team" class="w-full max-w-md animate-float drop-shadow-2xl">
            </div>
        </div>
    </section>

    <section class="bg-white border-y border-gray-100 shadow-sm relative z-20">
        <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-10 lg:px-6">
            <dl class="grid max-w-screen-md gap-8 mx-auto text-gray-900 sm:grid-cols-3">
                <div class="flex flex-col items-center justify-center p-4" data-aos="zoom-in" data-aos-delay="0">
                    <dt class="mb-2 text-4xl font-extrabold text-primary">15+</dt>
                    <dd class="font-medium text-gray-500">Dokter Ahli</dd>
                </div>
                <div class="flex flex-col items-center justify-center p-4" data-aos="zoom-in" data-aos-delay="100">
                    <dt class="mb-2 text-4xl font-extrabold text-primary">24 Jam</dt>
                    <dd class="font-medium text-gray-500">Layanan IGD</dd>
                </div>
                <div class="flex flex-col items-center justify-center p-4" data-aos="zoom-in" data-aos-delay="200">
                    <dt class="mb-2 text-4xl font-extrabold text-primary">5k+</dt>
                    <dd class="font-medium text-gray-500">Pasien Puas</dd>
                </div>
            </dl>
        </div>
    </section>

    <section id="poli" class="bg-gray-50 py-20">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:px-6">
            <div class="max-w-screen-md mb-12 lg:mb-16 mx-auto text-center" data-aos="fade-up">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900">Layanan Unggulan</h2>
                <p class="text-gray-500 sm:text-xl">Pilih spesialisasi medis sesuai kebutuhan Anda.</p>
            </div>
            
            <div class="grid space-y-8 md:grid-cols-2 lg:grid-cols-3 md:gap-8 md:space-y-0">
                @if(isset($polis) && $polis->count() > 0)
                    @foreach($polis as $index => $poli)
                    <div class="group bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 transform hover:-translate-y-2" 
                         data-aos="fade-up" 
                         data-aos-delay="{{ ($index + 1) * 100 }}">
                        <div class="flex justify-center items-center w-16 h-16 bg-blue-50 rounded-2xl mb-6 group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                            <svg class="w-8 h-8 text-primary group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <h3 class="mb-3 text-2xl font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $poli->nama_poli }}</h3>
                        <p class="text-gray-500 mb-6 leading-relaxed">{{ $poli->keterangan ?? 'Layanan medis profesional.' }}</p>
                        <a href="{{ route('register') }}" class="inline-flex items-center text-primary font-semibold hover:underline">
                            Daftar Poli <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                    @endforeach
                @else
                    <div class="col-span-3 text-center p-10 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                        <p class="text-gray-400">Data Poli belum tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section id="alur" class="bg-white py-20 overflow-hidden">
        <div class="max-w-screen-xl px-4 mx-auto">
            <div class="text-center mb-16" data-aos="fade-down">
                <h2 class="text-3xl font-bold text-gray-900">3 Langkah Mudah Berobat</h2>
            </div>
            <div class="relative grid gap-8 row-gap-12 md:grid-cols-3">
                <div class="hidden md:block absolute top-12 left-0 w-full h-1 bg-blue-100 -z-10 transform translate-y-1/2"></div>

                <div class="text-center bg-white p-4" data-aos="fade-right" data-aos-delay="100">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-primary text-white text-2xl font-bold shadow-lg ring-8 ring-blue-50">1</div>
                    <h6 class="mb-2 text-xl font-bold">Daftar Akun</h6>
                    <p class="text-sm text-gray-600">Gunakan NIK KTP Anda untuk membuat akun pasien.</p>
                </div>
                <div class="text-center bg-white p-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-primary text-white text-2xl font-bold shadow-lg ring-8 ring-blue-50">2</div>
                    <h6 class="mb-2 text-xl font-bold">Pilih Jadwal</h6>
                    <p class="text-sm text-gray-600">Cek jadwal dokter dan pilih waktu kunjungan.</p>
                </div>
                <div class="text-center bg-white p-4" data-aos="fade-left" data-aos-delay="300">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-primary text-white text-2xl font-bold shadow-lg ring-8 ring-blue-50">3</div>
                    <h6 class="mb-2 text-xl font-bold">Datang ke Klinik</h6>
                    <p class="text-sm text-gray-600">Tunjukkan nomor antrean digital saat tiba.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 mb-12 items-center">
                <div data-aos="fade-right">
                    <h3 class="text-3xl font-bold mb-4">Siap untuk berobat?</h3>
                    <p class="text-gray-400">Jangan tunda kesehatan Anda.</p>
                </div>
                <div class="flex justify-start md:justify-end" data-aos="fade-left">
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 px-8 rounded-lg shadow-lg transform hover:scale-105 transition">Daftar Sekarang</a>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center md:text-left">
                <p class="text-sm text-gray-500">© {{ date('Y') }} Poliklinik. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 50, duration: 800 });

        // Mobile Menu Logic
        document.getElementById('menu-toggle').addEventListener('click', () => {
            document.getElementById('mobile-menu-content').classList.toggle('hidden');
        });

        // Navbar Effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-md');
                navbar.classList.replace('bg-white/90', 'bg-white/95');
            } else {
                navbar.classList.remove('shadow-md');
                navbar.classList.replace('bg-white/95', 'bg-white/90');
            }
        });
    </script>
</body>
</html>