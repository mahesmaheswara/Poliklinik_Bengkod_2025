{{-- Resources/views/admin/dokter/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/dokter/dashboard.css') }}">
</head>
<body class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-emerald-600 via-green-500 to-teal-400 text-white overflow-hidden">

    <div class="text-center fade-in-up">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">👨‍⚕️ Selamat Datang, Dokter!</h1>
        <p class="text-lg mb-10 opacity-90">Terima kasih sudah merawat pasien dengan sepenuh hati 💚</p>

        <form method="POST" action="/logout" class="fade-in-up">
            @csrf
            <button type="submit"
                class="btn-logout px-8 py-3 bg-white text-green-700 font-semibold rounded-full shadow-lg hover:scale-105 hover:bg-green-50 transition-all duration-300">
                🚪 Logout
            </button>
        </form>
    </div>

    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="w-72 h-72 bg-white/10 rounded-full blur-3xl absolute -top-10 -left-10 animate-pulse"></div>
        <div class="w-96 h-96 bg-white/5 rounded-full blur-3xl absolute bottom-0 right-0 animate-[spin_10s_linear_infinite]"></div>
    </div>

</body>
</html>
