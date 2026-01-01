<?php

namespace App\Http\Controllers;

use App\Models\Obat; // Asumsi (Tidak ada 'use' di gambar, tapi ini diperlukan)
use Illuminate\Http\Request; // Asumsi (Tidak ada 'use' di gambar, tapi ini diperlukan)

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        return view('admin.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:100',
            'harga' => 'required|integer',
            'stok' => 'required|integer|min:0', // Validasi Stok
        ]);

        Obat::create($validated); // Simpan semua termasuk stok

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $obat = Obat::findOrFail(id: $id);
        // return view('admin.obat.edit', compact('obat')); // Opsi 1 di gambar
        return view('admin.obat.edit')->with([ // Opsi 2 di gambar
            'obat' => $obat
        ]);
        // compact('obat') // Komentar di gambar
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:100',
            'harga' => 'required|integer',
            'stok' => 'required|integer|min:0', // Validasi Stok
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update($validated); // Update semua termasuk stok

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();
        return redirect()->route('obat.index')
            ->with('message', 'Data Obat berhasil di Hapus')
            ->with('type', 'success');
    }

    public function cetak()
    {
        $obats = \App\Models\Obat::all();
        return view('admin.obat.cetak', compact('obats'));
    }
}