<?php

namespace App\Http\Controllers\AdminPendaftaran;

use Illuminate\Http\Request;
use App\Models\MasterDiagnosa;
use App\Http\Controllers\Controller;

class MasterDiagnosaController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterDiagnosa::query();

        if ($request->has('keyword') && $request->keyword) {
            $keyword = $request->keyword;
            $query->where('nama', 'like', '%' . $keyword . '%');
        }

        $diagnosas = $query->orderBy('nama')->paginate(10)->withQueryString();

        return view('AdminPendaftaran.master-diagnosa.index', compact('diagnosas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        MasterDiagnosa::create($request->only('nama'));

        return redirect()->route('master-diagnosa.index')->with('success', 'Diagnosa berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $diagnosa = MasterDiagnosa::findOrFail($id);
        return view('AdminPendaftaran.master-diagnosa.edit', compact('diagnosa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $diagnosa = MasterDiagnosa::findOrFail($id);
        $diagnosa->update($request->only('nama'));

        return redirect()->route('master-diagnosa.index')->with('success', 'Diagnosa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $diagnosa = MasterDiagnosa::findOrFail($id);
        $diagnosa->delete();

        return redirect()->route('master-diagnosa.index')->with('success', 'Diagnosa berhasil dihapus.');
    }
}
