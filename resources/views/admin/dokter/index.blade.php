{{-- File: resources/views/admin/dokter/index.blade.php --}}
<x-layouts.app title="Data Dokter">
    <div class="container-fluid px-4 mt-4">
        {{-- DIUBAH: Seluruh konten dibungkus 'card' agar konsisten --}}
        <div class="card custom-card">
            <div class="card-header">
                <h3 class="card-title" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Data Dokter</h3>
                {{-- Tombol 'Tambah' dipindah ke kanan atas card --}}
                <div class="card-tools">
                    <a href="{{ route('dokter.create') }}" class="btn btn-success btn-sm"> 
                        <i class="fas fa-plus"></i> Tambah Dokter
                    </a>
                </div>
            </div>
            <div class="card-body">

                {{-- Alert flash message --}}
                @if (session('message'))
                    <div class="alert alert-{{ session('type', 'success') }} alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        {{-- Tombol close standar Bootstrap 5 --}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- DIUBAH: div table-responsive tetap ada untuk scroll horizontal jika data terlalu lebar di desktop --}}
                <div class="table-responsive">
                    {{-- DIUBAH: Tambah class 'table-responsive-stack' --}}
                    <table class="table table-bordered table-hover table-responsive-stack">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Dokter</th>
                                <th>Email</th>
                                <th>No. KTP</th>
                                <th>No. HP</th>
                                <th>Alamat</th>
                                <th>Poli</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dokters as $dokter)
                                <tr>
                                    {{-- DIUBAH: Tambah data-label --}}
                                    <td data-label="#">{{ $loop->iteration }}</td>
                                    <td data-label="Nama Dokter">{{ $dokter->nama }}</td>
                                    <td data-label="Email">{{ $dokter->email }}</td>
                                    <td data-label="No. KTP">{{ $dokter->no_ktp }}</td>
                                    <td data-label="No. HP">{{ $dokter->no_hp }}</td>
                                    <td data-label="Alamat">{{ $dokter->alamat }}</td>
                                    <td data-label="Poli">
                                        <span class="badge bg-info">
                                            {{ $dokter->poli->nama_poli ?? 'Belum Dipilih' }}
                                        </span>
                                    </td>
                                    <td data-label="Aksi">
                                        {{-- DIUBAH: Ganti nama route ke 'dokters.edit' --}}
                                        <a href="{{ route('dokter.edit', $dokter->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        {{-- DIUBAH: Ganti nama route ke 'dokters.destroy' --}}
                                        <form action="{{ route('dokter.destroy', $dokter->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus dokter ini ?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="8">
                                        Belum ada Dokter
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