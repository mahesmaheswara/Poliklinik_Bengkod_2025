{{-- File: resources/views/admin/polis/index.blade.php --}}
<x-layouts.app title="Data Poli">
    <div class="container-fluid px-4 mt-4">
        {{-- DIUBAH: Seluruh konten dibungkus 'card' --}}
        <div class="card custom-card">
            <div class="card-header">
                <h3 class="card-title" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Data Poli</h3>
                <div class="card-tools">
                    <a href="{{ route('polis.create') }}" class="btn btn-success btn-sm"> {{-- DIUBAH: Ganti style tombol --}}
                        <i class="fas fa-plus"></i> Tambah Poli
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
                                <th>Nama Poli</th>
                                <th>Keterangan</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($polis as $poli)
                                <tr>
                                    {{-- DIUBAH: Tambah data-label --}}
                                    <td data-label="#">{{ $loop->iteration }}</td>
                                    <td data-label="Nama Poli">{{ $poli->nama_poli }}</td>
                                    <td data-label="Keterangan">{{ $poli->keterangan }}</td>
                                    <td data-label="Aksi">
                                        <a href="{{ route('polis.edit', $poli->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('polis.destroy', $poli->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus Poli ini ?')"> {{-- Tambah type submit --}}
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="4"> {{-- DIUBAH: Colspan jadi 4 --}}
                                        Belum ada Poli
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