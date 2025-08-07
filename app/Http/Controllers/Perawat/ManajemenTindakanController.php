<?php

namespace App\Http\Controllers\Perawat;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Tindakan;
use App\Models\DiagnosaAwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;

class ManajemenTindakanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pendaftarans = Pendaftaran::with([
            'pasien',
            'diagnosaAwal',
            'diagnosaAkhir',
            'perawat',
            'dokter',
            'tindakan'
        ])
            // ->whereHas('diagnosaAwal')
            // ->whereHas('diagnosaAkhir')
            ->when($search, function ($query, $search) {
                $query->whereHas('pasien', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('Perawat.manajemen-tindakan.index', compact('pendaftarans', 'search'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'jenis_tindakan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        Tindakan::create([
            'pasien_id' => $request->pasien_id,
            'user_id' => $request->user_id,
            'jenis_tindakan' => $request->jenis_tindakan,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('manajemen-tindakan.index')->with('success', 'Tindakan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $tindakan = Tindakan::with([
            'pasien.diagnosaAwal',
            'pasien.diagnosaAkhir',
            'user'
        ])->findOrFail($id);

        return view('Perawat.manajemen-tindakan.show', compact('tindakan'));
    }

    public function edit($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        $pasiens = Pasien::all();
        $perawats = User::where('role_id', '4')->get();

        return view('Perawat.manajemen-tindakan.edit', compact('tindakan', 'pasiens', 'perawats'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'jenis_tindakan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        $tindakan = Tindakan::findOrFail($id);
        $tindakan->update([
            'pasien_id' => $request->pasien_id,
            'user_id' => $request->user_id,
            'jenis_tindakan' => $request->jenis_tindakan,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('manajemen-tindakan.index')->with('success', 'Tindakan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        $tindakan->delete();

        return redirect()->route('manajemen-tindakan.index')->with('success', 'Tindakan berhasil dihapus.');
    }
}
