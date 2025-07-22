<?php

namespace App\Http\Controllers\Dokter;

use App\Models\Pasien;
use App\Models\Tindakan;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DiagnosaAkhir;
use App\Models\Pendaftaran;

class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $pendaftarans = Pendaftaran::with(['diagnosaAkhir', 'pasien', 'tindakan'])
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('pasien', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%$keyword%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('Dokter.rekam-medis.index', compact('pendaftarans'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'tanggal_kunjungan' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosa' => 'nullable|string',
            'tindakan_id' => 'nullable|exists:tindakan,id',
            'catatan_tambahan' => 'nullable|string',
        ]);

        RekamMedis::create($request->all());

        return redirect()->route('rekam-medis.index')->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rekam = RekamMedis::findOrFail($id);
        $pasiens = Pasien::all();
        $tindakans = Tindakan::all();

        return view('Dokter.rekam-medis.edit', compact('rekam', 'pasiens', 'tindakans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'tanggal_kunjungan' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosa' => 'nullable|string',
            'tindakan_id' => 'nullable|exists:tindakan,id',
            'catatan_tambahan' => 'nullable|string',
        ]);

        $rekam = RekamMedis::findOrFail($id);
        $rekam->update($request->all());

        return redirect()->route('rekam-medis.index')->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function show($id)
    {
        $rekam = RekamMedis::with(['pasien', 'tindakan'])->findOrFail($id);
        return view('Dokter.rekam-medis.show', compact('rekam'));
    }

    public function destroy($id)
    {
        $rekam = RekamMedis::findOrFail($id);
        $rekam->delete();

        return redirect()->route('rekam-medis.index')->with('success', 'Rekam medis berhasil dihapus.');
    }
}
