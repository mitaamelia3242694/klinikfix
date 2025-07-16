<?php

namespace App\Http\Controllers\AdminIT;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataJabatanController extends Controller
{
     public function index()
    {
        $jabatans = Jabatan::paginate(10);
        return view('AdminIT.data-jabatan.index', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
        ]);

        Jabatan::create($request->only('nama_jabatan'));
        return redirect()->route('data-jabatan.index')->with('success', ' Data Jabatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('AdminIT.data-jabatan.edit', compact('jabatan'));
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'nama_jabatan' => 'required|string|max:255',
    ]);

    $jabatan = Jabatan::findOrFail($id);
    $jabatan->update([
        'nama_jabatan' => $request->nama_jabatan
    ]);

    return redirect()->route('data-jabatan.index')->with('success', ' Data Jabatan berhasil diperbarui.');
}


    public function destroy($id)
    {
        Jabatan::destroy($id);
        return redirect()->route('data-jabatan.index')->with('success', ' Data Jabatan berhasil dihapus.');
    }
}
