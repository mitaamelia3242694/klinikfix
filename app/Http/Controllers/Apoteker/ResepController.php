<?php

namespace App\Http\Controllers\Apoteker;

use App\Models\User;
use App\Models\Resep;
use App\Models\Pasien;
use App\Models\Pelayanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResepController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $reseps = Resep::with(['pasien', 'user', 'pengambilanObat'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('pasien', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%$keyword%");
                })->orWhereHas('user', function ($q) use ($keyword) {
                    $q->where('nama_lengkap', 'like', "%$keyword%");
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['keyword' => $keyword]); // agar keyword tetap tersimpan di URL saat berpindah halaman
        // dd($reseps);
        $pasiens = Pasien::all();
        $users = User::where('role_id', 3)->get();
        $pelayanans = Pelayanan::all();

        return view('Apoteker.resep.index', compact('reseps', 'pasiens', 'users', 'pelayanans'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'pelayanan_id' => 'required|exists:pelayanan,id',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        Resep::create($request->all());

        return redirect()->route('data-resep.index')->with('success', 'Data resep berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $resep = Resep::findOrFail($id);
        $pasiens = Pasien::all();
        $users = User::where('role_id', 3)->get();
        $pelayanans = Pelayanan::all();

        return view('Apoteker.resep.edit', compact('resep', 'pasiens', 'users', 'pelayanans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'pelayanan_id' => 'required|exists:pelayanan,id',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        $resep = Resep::findOrFail($id);
        $resep->update($request->all());

        return redirect()->route('data-resep.index')->with('success', 'Data resep berhasil diperbarui.');
    }
    public function show($id)
    {
        $resep = Resep::with(['pasien', 'user'])->findOrFail($id);
        return view('Apoteker.resep.detail', compact('resep'));
    }


    public function destroy($id)
    {
        $resep = Resep::findOrFail($id);
        $resep->delete();

        return redirect()->route('data-resep.index')->with('success', 'Data resep berhasil dihapus.');
    }
}
