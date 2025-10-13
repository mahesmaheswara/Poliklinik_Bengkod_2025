<x-layouts.app title="Admin Dashboard">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">

    <div class="ml-4 mt-10 fade-in-up text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            👑 Halo, Selamat Datang <span class="text-yellow-300">Admin</span>!
        </h1>

        <p class="text-lg opacity-90 mb-6">
            Kelola data sistem dengan bijak dan efisien ⚙️
        </p>

        <form method="POST" action="/logout">
            @csrf
            <button type="submit"
                class="btn-logout px-6 py-3 bg-white text-indigo-700 font-semibold rounded-full shadow-md hover:bg-indigo-50 hover:scale-105 transition-all duration-300">
                🚪 Logout
            </button>
        </form>
    </div>

    {{-- Pesan kesalahan jika ada --}}
    @if ($errors->any())
        <div class="mt-8 mx-4 p-4 bg-red-500/20 border border-red-400 text-white rounded-lg">
            <h2 class="font-bold mb-2">Terjadi Kesalahan:</h2>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</x-layouts.app>
