{{-- File: resources/views/admin/pasien/index.blade.php --}}
<x-layouts.app title="Data Pasien">
    <div class="container-fluid px-4 mt-4">
        {{-- DIUBAH: Seluruh konten dibungkus 'card' --}}
        <div class="card custom-card">
            <div class="card-header">
                <h3 class="card-title" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Data Pasien</h3>
                <div class="card-tools">
                    <a href="{{ route('pasien.create') }}" class="btn btn-success btn-sm"> {{-- DIUBAH: Ganti style tombol --}}
                        <i class="fas fa-plus"></i> Tambah Pasien
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
                                <th>Nama Pasien</th>
                                <th>Email</th>
                                <th>No. KTP</th>
                                <th>NO. HP</th>
                                <th>Alamat</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pasiens as $pasien)
                                <tr>
                                    {{-- DIUBAH: Tambah data-label --}}
                                    <td data-label="#">{{ $loop->iteration }}</td>
                                    <td data-label="Nama Pasien">{{ $pasien->nama }}</td>
                                    <td data-label="Email">{{ $pasien->email }}</td>
                                    <td data-label="No. KTP">{{ $pasien->no_ktp }}</td>
                                    <td data-label="NO. HP">{{ $pasien->no_hp }}</td>
                                    <td data-label="Alamat">{{ $pasien->alamat }}</td>
                                    <td data-label="Aksi">
                                        <a href="{{ route('pasien.edit', $pasien->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('pasien.destroy', $pasien->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pasien ini ?')"> {{-- Tambah type submit --}}
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="7"> {{-- DIUBAH: Colspan jadi 7 --}}
                                        Belum ada Pasien
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