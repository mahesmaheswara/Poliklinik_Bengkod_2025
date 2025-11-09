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
        $request->validate([
            'nama_obat' => 'required|string',
            'kemasan' => 'required|string', // Di gambar tertulis 'required string'
            'harga' => 'required|integer',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga
        ]);

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat Berhasil dibuat')
            ->with('type', 'success');
    }

    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id);
        // return view('admin.obat.edit', compact('obat')); // Opsi 1 di gambar
        return view('admin.obat.edit')->with([ // Opsi 2 di gambar
            'obat' => $obat
        ]);
        // compact('obat') // Komentar di gambar
    }

    public function update(Request $request, string $id) // Asumsi (Request $request tidak ada di gambar)
    {
        $request->validate([
            'nama_obat' => 'required|string',
            'kemasan' => 'nullable|string',
            'harga' => 'required|integer',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga
        ]);

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat berhasil di edit')
            ->with('type', 'success');
    }

    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();
        return redirect()->route('obat.index')
            ->with('message', 'Data Obat berhasil di Hapus')
            ->with('type', 'success');
    }
}