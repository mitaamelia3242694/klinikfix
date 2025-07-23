<?php

namespace App\Http\Controllers\Dokter;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Tindakan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pelayanan;
use Illuminate\Support\Facades\Auth;

class PencatatanTindakanController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $tindakans = Tindakan::with(['pasien', 'user'])
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('pasien', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%{$keyword}%");
                })->orWhereHas('user', function ($q) use ($keyword) {
                    $q->where('nama_lengkap', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->appends(['keyword' => $keyword]);

        $pasiens = Pasien::all();
        $user = Auth::user()->id;
        $dokters = User::where('id', $user)->first();
        $layanan = Pelayanan::all();

        return view('Dokter.pencatatan-tindakan.index', compact('tindakans', 'pasiens', 'dokters', 'layanan'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'jenis_tindakan' => 'required|string|max:255',
            'tarif' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        Tindakan::create($validated);

        return redirect()->route('pencatatan-tindakan.index')->with('success', 'Tindakan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $tindakan = Tindakan::with(['pasien', 'user'])->findOrFail($id);
        return view('Dokter.pencatatan-tindakan.show', compact('tindakan'));
    }

    public function edit($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        $pasiens = Pasien::all();
        $user = Auth::user()->id;
        $dokters = User::where('id', $user)->first();

        return view('Dokter.pencatatan-tindakan.edit', compact('tindakan', 'pasiens', 'dokters'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'jenis_tindakan' => 'required|string|max:255',
            'tarif' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $tindakan = Tindakan::findOrFail($id);
        $tindakan->update($validated);

        return redirect()->route('pencatatan-tindakan.index')->with('success', 'Tindakan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        $tindakan->delete();

        return redirect()->route('pencatatan-tindakan.index')->with('success', 'Tindakan berhasil dihapus.');
    }
}
