{{-- File: resources/views/admin/obat/index.blade.php --}}
<x-layouts.app title="Data Obat">
    <div class="container-fluid px-4 mt-4">
        {{-- DIUBAH: Seluruh konten dibungkus 'card' --}}
        <div class="card custom-card">
            <div class="card-header">
                <h3 class="card-title" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Data Obat</h3>
                <div class="card-tools">
                    <a href="{{ route('obat.create') }}" class="btn btn-success btn-sm"> {{-- DIUBAH: Ganti style tombol --}}
                        <i class="fas fa-plus"></i> Tambah Obat
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
                                <th>Nama Obat</th>
                                <th>Kemasan</th>
                                <th>Harga</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($obats as $obat)
                                <tr>
                                    {{-- DIUBAH: Tambah data-label --}}
                                    <td data-label="#">{{ $loop->iteration }}</td>
                                    <td data-label="Nama Obat">{{ $obat->nama_obat }}</td>
                                    <td data-label="Kemasan">{{ $obat->kemasan }}</td>
                                    <td data-label="Harga">Rp {{ number_format($obat->harga, 0, ',', '.') }}</td> {{-- Format harga --}}
                                    <td data-label="Aksi">
                                        <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus Data Obat ini ?')"> {{-- Tambah type submit --}}
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5"> {{-- DIUBAH: Colspan jadi 5 --}}
                                        Belum ada Data Obat
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