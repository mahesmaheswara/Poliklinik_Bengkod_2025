<x-layouts.app title="Dashboard Pasien">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            
            {{-- Ini adalah konten dari file Anda sebelumnya, disesuaikan untuk AdminLTE --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- 
                          Menambahkan inline style untuk mencoba meniru tampilan gradien Anda.
                          Menghapus class Tailwind karena tidak dimuat di sini.
                        --}}
                        <div class="card-body text-center p-5" style="background: linear-gradient(to right, #0ea5e9, #3b82f6); color: white; border-radius: 0.375rem;">
                            
                            {{-- Mengambil nama pengguna yang login secara dinamis --}}
                            <h1 class="text-4xl md:text-5xl font-bold mb-4">💙 Selamat Datang, {{ Auth::user()->nama }}!</h1>
                            <p class="text-lg mb-4 opacity-90">Semoga harimu sehat dan bahagia 💫</p>
    
                            {{-- Tombol logout disesuaikan dengan style Bootstrap (bawaan AdminLTE) --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="btn btn-light shadow-lg font-weight-bold">
                                    🚪 Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Akhir dari konten Anda --}}

        </div>
    </section>
    </x-layouts.app>