{{-- File: resources/views/dokter/jadwal-periksa/index.blade.php --}}
<x-layouts.app title="Jadwal Periksa">
    <div class="container-fluid px-4 mt-4">
        {{-- DIUBAH: Seluruh konten dibungkus 'card' --}}
        <div class="card custom-card">
            <div class="card-header">
                <h3 class="card-title" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Jadwal Periksa Anda</h3>
                <div class="card-tools">
                    <a href="{{ route('jadwal-periksa.create') }}" class="btn btn-success btn-sm"> {{-- DIUBAH: Ganti style tombol --}}
                        <i class="fas fa-plus"></i> Tambah Jadwal
                    </a>
                </div>
            </div>
            <div class="card-body">

                {{-- Alert flash message --}}
                @if (session('message'))
                    <div class="alert alert-{{ session('type', 'success') }} alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    {{-- DIUBAH: Tambah class 'table-responsive-stack' --}}
                    <table class="table table-bordered table-hover table-responsive-stack">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th> {{-- Tambah kolom nomor --}}
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwalPeriksas as $jadwalPeriksa)
                                <tr>
                                    {{-- DIUBAH: Tambah data-label --}}
                                    <td data-label="#">{{ $loop->iteration }}</td>
                                    <td data-label="Hari">{{ $jadwalPeriksa->hari }}</td>
                                    <td data-label="Jam Mulai">{{ \Carbon\Carbon::parse($jadwalPeriksa->jam_mulai)->format('H:i') }}</td>
                                    <td data-label="Jam Selesai">{{ \Carbon\Carbon::parse($jadwalPeriksa->jam_selesai)->format('H:i') }}</td>
                                    <td data-label="Aksi">
                                        <a href="{{ route('jadwal-periksa.edit', $jadwalPeriksa->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('jadwal-periksa.destroy', $jadwalPeriksa->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus Data Jadwal Periksa ini ?')"> {{-- Tambah type submit --}}
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5"> {{-- DIUBAH: Colspan jadi 5 --}}
                                        Belum ada Jadwal Periksa
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div> {{-- /.card-body --}}
        </div> {{-- /.card --}}
    </div>

    {{-- Script untuk auto-close alert (didorong ke layout utama) --}}
    @push('scripts')
    <script>
        setTimeout(() => {
            const alertNode = document.querySelector('.alert');
            if (alertNode) {
                // Gunakan instance Bootstrap jika ada
                if (typeof bootstrap !== 'undefined') {
                    const alertInstance = bootstrap.Alert.getInstance(alertNode);
                    if (alertInstance) {
                        alertInstance.close();
                    }
                } else {
                    // Fallback jika Bootstrap JS tidak ada
                    alertNode.style.display = 'none';
                }
            }
        }, 3000); // 3 detik
    </script>
    @endpush
</x-layouts.app>