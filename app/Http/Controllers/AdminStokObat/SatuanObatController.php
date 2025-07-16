<?php

namespace App\Http\Controllers\AdminStokObat;

use App\Models\SatuanObat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SatuanObatController extends Controller
{
   public function index()
    {
        $satuans = SatuanObat::latest()->paginate(10); // <-- paginate di sini
        return view('AdminStokObat.satuan-obat.index', compact('satuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:100'
        ]);

        SatuanObat::create([
            'nama_satuan' => $request->nama_satuan
        ]);

        return redirect()->route('satuan-obat.index')->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $satuan = SatuanObat::findOrFail($id);
        return view('AdminStokObat.satuan-obat.edit', compact('satuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:100'
        ]);

        $satuan = SatuanObat::findOrFail($id);
        $satuan->update(['nama_satuan' => $request->nama_satuan]);

        return redirect()->route('satuan-obat.index')->with('success', 'Satuan berhasil diubah.');
    }

    public function destroy($id)
    {
        $satuan = SatuanObat::findOrFail($id);
        $satuan->delete();

        return redirect()->route('satuan-obat.index')->with('success', 'Satuan berhasil dihapus.');
    }
}