<?php

namespace App\Http\Controllers\Dokter;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Pelayanan;
use Illuminate\Http\Request;
use App\Models\DiagnosaAkhir;
use App\Models\MasterDiagnosa;
use App\Http\Controllers\Controller;

class PencatatanDiagnosaController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $diagnosas = DiagnosaAkhir::with(['pasien', 'user'])
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('pasien', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%{$keyword}%");
                })->orWhereHas('user', function ($q) use ($keyword) {
                    $q->where('nama_lengkap', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(5)
            ->appends(['keyword' => $keyword]);

        $pasiens = Pasien::all(); // untuk dropdown modal
        $dokters = User::where('role_id', '3')->get();
        $masters = MasterDiagnosa::all();
        $layanans = Pelayanan::all();


        return view('Dokter.pencatatan-diagnosa.index', compact('diagnosas', 'pasiens', 'dokters', 'masters', 'layanans'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'diagnosa' => 'required|string',
            'master_diagnosa_id' => 'required|exists:master_diagnosa,id',
            'pelayanan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        DiagnosaAkhir::create($request->all());

        return redirect()->route('pencatatan-diagnosa.index')->with('success', 'Diagnosa berhasil ditambahkan.');
    }

    public function show($id)
    {
        $diagnosa = DiagnosaAkhir::with(['pasien', 'user'])->findOrFail($id);

        return view('Dokter.pencatatan-diagnosa.show', compact('diagnosa'));
    }

    public function edit($id)
    {
        $diagnosa = DiagnosaAkhir::findOrFail($id);
        $pasiens = Pasien::all();
        $dokters = User::where('role_id', '3')->get();
        $masters = MasterDiagnosa::all();
        $layanans = Pelayanan::all();

        return view('Dokter.pencatatan-diagnosa.edit', compact('diagnosa', 'pasiens', 'dokters', 'masters', 'layanans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'diagnosa' => 'required|string',
            'master_diagnosa_id' => 'required|exists:master_diagnosa,id',
            'pelayanan_id' => 'required|exists:pelayanan,id', // ✅ diganti dari 'pelayanan'
            'catatan' => 'nullable|string',
        ]);

        $diagnosa = DiagnosaAkhir::findOrFail($id);
        $diagnosa->update($request->only([
            'pasien_id',
            'user_id',
            'tanggal',
            'diagnosa',
            'master_diagnosa_id',
            'pelayanan_id',
            'catatan',
        ]));

        return redirect()->route('pencatatan-diagnosa.index')->with('success', 'Diagnosa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $diagnosa = DiagnosaAkhir::findOrFail($id);
        $diagnosa->delete();

        return redirect()->route('pencatatan-diagnosa.index')->with('success', 'Diagnosa berhasil dihapus.');
    }
}
