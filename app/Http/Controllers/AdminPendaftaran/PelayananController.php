<?php

namespace App\Http\Controllers\AdminPendaftaran;

use App\Models\Pelayanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PelayananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelayanan::query();

        if ($request->has('keyword') && $request->keyword) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_pelayanan', 'like', '%' . $keyword . '%')
                    ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
            });
        }

        $layanans = $query->orderBy('nama_pelayanan')->paginate(10)->withQueryString();

        return view('AdminPendaftaran.pelayanan.index', compact('layanans'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelayanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'biaya' => 'required|numeric|min:0',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        Pelayanan::create($request->all());

        return redirect()->route('data-pelayanan.index')->with('success', 'Pelayanan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $layanan = Pelayanan::findOrFail($id);
        return view('AdminPendaftaran.pelayanan.detail', compact('layanan'));
    }

    public function edit($id)
    {
        $layanan = Pelayanan::findOrFail($id);
        return view('AdminPendaftaran.pelayanan.edit', compact('layanan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelayanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'biaya' => 'required|numeric|min:0',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $layanan = Pelayanan::findOrFail($id);
        $layanan->update($request->all());

        return redirect()->route('data-pelayanan.index')->with('success', 'Pelayanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $layanan = Pelayanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('data-pelayanan.index')->with('success', 'Pelayanan berhasil dihapus.');
    }
}
