<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di PoliklinikApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-400 text-white overflow-hidden">

    <div class="text-center fade-in-up">
        <h1 class="text-5xl font-extrabold mb-6">🏥 PoliklinikApp</h1>
        <p class="text-lg md:text-xl opacity-90 mb-10">
            Sistem Informasi Pelayanan Poliklinik — Cepat, Aman, dan Modern 💉
        </p>

        <div class="flex flex-col md:flex-row gap-4 justify-center">
            <a href="{{ route('login') }}"
               class="px-8 py-3 bg-white text-indigo-700 font-semibold rounded-full shadow-lg hover:bg-indigo-50 hover:scale-105 transition-all duration-300">
                🔐 Login
            </a>
            <a href="{{ route('register') }}"
               class="px-8 py-3 bg-transparent border border-white font-semibold rounded-full hover:bg-white hover:text-pink-600 transition-all duration-300">
                📝 Register
            </a>
        </div>
    </div>

    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="w-72 h-72 bg-white/10 rounded-full blur-3xl absolute -top-10 -left-10 animate-pulse"></div>
        <div class="w-96 h-96 bg-white/5 rounded-full blur-3xl absolute bottom-0 right-0 animate-[spin_10s_linear_infinite]"></div>
    </div>

</body>
</html>
