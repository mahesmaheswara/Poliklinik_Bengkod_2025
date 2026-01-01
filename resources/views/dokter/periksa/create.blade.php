@extends('components.layouts.app')

@section('header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="font-weight-bold text-dark mb-0">Pemeriksaan Medis</h4>
            <small class="text-muted">Kelola diagnosa dan resep obat pasien</small>
        </div>
        <a href="{{ route('dokter.dashboard') }}" class="btn btn-light shadow-sm text-secondary rounded-pill font-weight-bold px-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="container-fluid pb-5">

    {{-- CUSTOM CSS UNTUK TAMPILAN SMOOTH --}}
    <style>
        /* Tipografi & Dasar */
        body { background-color: #f8f9fa; }
        .text-primary-soft { color: #4e73df; }
        .bg-soft { background-color: #f8f9fc; }
        
        /* Kartu Premium (Soft Shadow) */
        .card-premium {
            border: none;
            border-radius: 1rem;
            background: #fff;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.03), 
                        0 0.25rem 0.5rem rgba(0, 0, 0, 0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.05);
        }

        /* Form Controls yang Lebih Halus */
        .form-control, .custom-select {
            border-radius: 0.75rem;
            border: 1px solid #e3e6f0;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            background-color: #fcfcfc;
            transition: all 0.2s;
        }
        .form-control:focus, .custom-select:focus {
            background-color: #fff;
            border-color: #bac8f3;
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1); /* Glow biru halus */
        }
        textarea.form-control { resize: none; }

        /* Avatar Pasien */
        .avatar-box {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem;
            box-shadow: 0 4px 10px rgba(118, 75, 162, 0.3);
            margin: 0 auto;
        }

        /* Tabel yang Bersih */
        .table-clean th {
            border-top: none;
            border-bottom: 2px solid #f1f3f9;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #858796;
            padding: 1rem;
        }
        .table-clean td {
            vertical-align: middle;
            border-top: 1px solid #f8f9fc;
            padding: 1rem;
            color: #5a5c69;
        }
        .table-clean tr:last-child td { border-bottom: none; }

        /* Floating Footer Action */
        .floating-action {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(0,0,0,0.05);
        }
    </style>

    <form action="{{ route('periksa.store', $daftarPoli->id) }}" method="POST" id="form-periksa">
        @csrf
        
        <div class="row">
            {{-- KOLOM KIRI: PASIEN (Fixed Height) --}}
            <div class="col-lg-4 mb-4">
                <div class="card-premium h-100 p-4">
                    {{-- Header Pasien --}}
                    <div class="text-center mb-4">
                        <div class="avatar-box mb-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <h5 class="font-weight-bold text-dark mb-1">{{ $daftarPoli->pasien->nama }}</h5>
                        <p class="text-muted small mb-2">Pasien Umum</p>
                        <span class="badge badge-light text-primary px-3 py-2 rounded-pill border">
                            No. Antrian: <strong>{{ $daftarPoli->no_antrian }}</strong>
                        </span>
                    </div>

                    <div class="border-top pt-4">
                        {{-- Input Tanggal --}}
                        <div class="form-group mb-4">
                            <label class="text-secondary small font-weight-bold ml-1">TANGGAL & JAM PERIKSA</label>
                            <input type="datetime-local" name="tgl_periksa" class="form-control" 
                                   value="{{ now()->format('Y-m-d\TH:i') }}" required>
                        </div>

                        {{-- Input Catatan --}}
                        <div class="form-group mb-0">
                            <label class="text-secondary small font-weight-bold ml-1">CATATAN / DIAGNOSA</label>
                            <textarea name="catatan" class="form-control bg-soft" rows="6" 
                                      placeholder="Tuliskan hasil diagnosa, keluhan, dan saran medis disini..." required></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: RESEP (Interactive) --}}
            <div class="col-lg-8 mb-4">
                <div class="card-premium h-100">
                    <div class="p-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary-soft">
                                <i class="fas fa-prescription-bottle-alt mr-2"></i> Resep & Tagihan
                            </h6>
                            <div class="text-right">
                                <small class="text-muted d-block">Biaya Jasa Dokter</small>
                                <span class="font-weight-bold text-dark">Rp 150.000</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        {{-- Input Selector Obat --}}
                        <div class="card bg-soft border-0 rounded-lg mb-4">
                            <div class="card-body p-3">
                                <label class="small text-muted font-weight-bold mb-2 ml-1">TAMBAH OBAT KE RESEP</label>
                                <div class="input-group">
                                    <select id="select-obat" class="form-control custom-select shadow-none" style="height: 50px;">
                                        <option value="" disabled selected>-- Pilih Obat dari Daftar --</option>
                                        @foreach($obat as $o)
                                            @php
                                                // Logika Visual Warna
                                                $style = '';
                                                $label = 'Sisa: ' . $o->stok;
                                                
                                                if($o->stok == 0) {
                                                    $style = 'color: #e74a3b; font-weight: bold;';
                                                    $label = 'HABIS';
                                                } elseif($o->stok <= 5) {
                                                    $style = 'color: #f6c23e; font-weight: bold;';
                                                    $label = 'MENIPIS (Sisa: '.$o->stok.')';
                                                }
                                            @endphp
                                            <option value="{{ $o->id }}" 
                                                    data-nama="{{ $o->nama_obat }}" 
                                                    data-harga="{{ $o->harga }}"
                                                    data-stok="{{ $o->stok }}"
                                                    style="{{ $style }}">
                                                {{ $o->nama_obat }} - {{ $o->kemasan }} [{{ $label }}] - Rp {{ number_format($o->harga, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append ml-2">
                                        <button type="button" class="btn btn-primary rounded-lg px-4 shadow-sm" id="btn-tambah-obat" style="border-radius: 0.75rem;">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tabel Item --}}
                        <div class="table-responsive">
                            <table class="table table-clean w-100" id="tabel-resep">
                                <thead>
                                    <tr>
                                        <th width="50%">Nama Item</th>
                                        <th width="30%" class="text-right">Harga</th>
                                        <th width="20%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="row-kosong">
                                        <td colspan="3" class="text-center py-5">
                                            <img src="https://img.icons8.com/clouds/100/000000/medical-bag.png" alt="Empty" style="opacity: 0.5; width: 80px;">
                                            <p class="text-muted small mt-2">Belum ada obat yang diresepkan.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    {{-- Summary Total --}}
                    <div class="p-4 bg-soft mt-auto border-top" style="border-radius: 0 0 1rem 1rem;">
                        <div class="d-flex justify-content-between align-items-end">
                            <div>
                                <small class="text-muted font-weight-bold">TOTAL TAGIHAN</small>
                                <h2 class="font-weight-bold text-dark mb-0" id="grand-total">Rp 150.000</h2>
                            </div>
                            <div class="text-right text-muted small">
                                <span id="total-harga-obat">Obat: Rp 0</span> <br>
                                <span>Jasa: Rp 150.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Floating Submit Bar --}}
        <div class="fixed-bottom floating-action py-3">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    <i class="fas fa-check-circle text-success mr-1"></i> Data aman & tervalidasi
                </div>
                <div>
                    <input type="hidden" name="obat_json" id="obat_json">
                    <button type="submit" class="btn btn-success rounded-pill px-5 py-2 font-weight-bold shadow-lg" style="letter-spacing: 0.5px;">
                        SIMPAN PEMERIKSAAN <i class="fas fa-save ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Variabel & Element
    let keranjangObat = []; 
    let stokTracker = {};   
    const biayaJasa = 150000;

    const selectObat = document.getElementById('select-obat');
    const btnTambah = document.getElementById('btn-tambah-obat');
    const tabelBody = document.querySelector('#tabel-resep tbody');
    const rowKosong = document.getElementById('row-kosong');
    const inputJson = document.getElementById('obat_json');
    const displayGrandTotal = document.getElementById('grand-total');
    const displayObatTotal = document.getElementById('total-harga-obat');

    // --- LOGIKA TAMBAH (CAPSTONE) ---
    btnTambah.addEventListener('click', function() {
        const id = selectObat.value;
        
        if (!id) {
            Swal.fire({ icon: 'warning', title: 'Belum Ada Obat', text: 'Silakan pilih obat dari daftar dulu ya.', timer: 1500, showConfirmButton: false });
            return;
        }

        const option = selectObat.options[selectObat.selectedIndex];
        const nama = option.getAttribute('data-nama');
        const harga = parseInt(option.getAttribute('data-harga'));
        const stokAsli = parseInt(option.getAttribute('data-stok'));

        // Cek Sisa Virtual
        const sudahDiKeranjang = stokTracker[id] || 0;
        const sisaStok = stokAsli - sudahDiKeranjang;

        // Validasi Keras: Stok Habis
        if (sisaStok <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Stok Habis!',
                text: `Obat ${nama} sudah tidak tersedia.`,
                confirmButtonColor: '#e74a3b',
            });
            return; 
        }

        // Validasi Lunak: Menipis (Popup Tengah)
        if (sisaStok <= 5) {
            Swal.fire({
                icon: 'info', // Pakai Info/Warning biar soft
                title: 'Stok Menipis',
                text: `Perhatian: Obat ${nama} tinggal tersisa ${sisaStok - 1} unit lagi.`,
                showConfirmButton: false,
                timer: 2000
            });
        }

        // Tambahkan
        keranjangObat.push(id);           
        stokTracker[id] = sudahDiKeranjang + 1; 

        renderTabel(); 
        
        // Reset Select biar clean
        selectObat.value = "";
    });

    // --- RENDER TABEL ---
    function renderTabel() {
        tabelBody.innerHTML = ''; 

        if (keranjangObat.length === 0) {
            tabelBody.appendChild(rowKosong);
            updateTotal(0);
            return;
        }

        let totalObat = 0;

        keranjangObat.forEach((idObat, index) => {
            let option = document.querySelector(`option[value="${idObat}"]`);
            let nama = option.getAttribute('data-nama');
            let harga = parseInt(option.getAttribute('data-harga'));

            totalObat += harga;

            let row = `
                <tr style="animation: fadeIn 0.3s;">
                    <td class="font-weight-bold text-dark">${nama}</td>
                    <td class="text-right text-secondary">Rp ${new Intl.NumberFormat('id-ID').format(harga)}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-light text-danger btn-sm rounded-circle shadow-sm btn-hapus" 
                                data-index="${index}" data-id="${idObat}" style="width: 32px; height: 32px; padding: 0;">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
            `;
            tabelBody.innerHTML += row;
        });

        updateTotal(totalObat);
        updateJson();
        
        document.querySelectorAll('.btn-hapus').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = this.getAttribute('data-index');
                const idHapus = this.getAttribute('data-id');
                keranjangObat.splice(idx, 1);
                if (stokTracker[idHapus]) { stokTracker[idHapus]--; }
                renderTabel();
            });
        });
    }

    function updateTotal(total) {
        displayObatTotal.innerText = 'Obat: Rp ' + new Intl.NumberFormat('id-ID').format(total);
        displayGrandTotal.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total + biayaJasa);
    }

    function updateJson() {
        inputJson.value = JSON.stringify(keranjangObat);
    }
});
</script>
@endpush