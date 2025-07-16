<?php

namespace App\Http\Controllers\Apoteker;

use App\Models\User;
use App\Models\Resep;
use Illuminate\Http\Request;
use App\Models\PengambilanObat;
use App\Http\Controllers\Controller;

class PengambilanObatController extends Controller
{
   public function index(Request $request)
{
    // Ambil data pengambilan obat dengan relasi resep → pasien, dokter dan petugas
    $query = PengambilanObat::with(['resep.pasien', 'resep.user', 'user']);

    // Filter berdasarkan status checklist jika ada
    if ($request->filled('status') && $request->status !== 'Semua') {
    $query->where('status_checklist', $request->status);
}


    // Paginate data utama yang ditampilkan di tabel
    $pengambilanObats = $query->orderBy('tanggal_pengambilan', 'desc')->paginate(10)->withQueryString();

    // Data dropdown untuk modal tambah
    $reseps = Resep::with('pasien')->get();
    $users = User::where('role_id', 5)->get(); // Role 5 = petugas apotek?

    return view('Apoteker.pengambilan-obat.index', compact('pengambilanObats', 'reseps', 'users'));
}



    public function store(Request $request)
    {
        $request->validate([
            'resep_id' => 'required|exists:resep,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_pengambilan' => 'required|date',
            'status_checklist' => 'required|in:Lengkap,Tidak Lengkap',
        ]);

        PengambilanObat::create($request->all());

        return redirect()->route('pengambilan-obat.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengambilan = PengambilanObat::findOrFail($id);
        $reseps = Resep::with('pasien')->get();
        $users = User::where('role_id', 5)->get();

        return view('Apoteker.pengambilan-obat.edit', compact('pengambilan', 'reseps', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'resep_id' => 'required|exists:resep,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_pengambilan' => 'required|date',
            'status_checklist' => 'required|in:Lengkap,Tidak Lengkap',
        ]);

        $pengambilan = PengambilanObat::findOrFail($id);
        $pengambilan->update($request->all());

        return redirect()->route('pengambilan-obat.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function show($id)
    {
        $pengambilan = PengambilanObat::with(['resep.pasien', 'resep.user', 'user'])->findOrFail($id);
        return view('Apoteker.pengambilan-obat.detail', compact('pengambilan'));
    }

    public function destroy($id)
    {
        $pengambilan = PengambilanObat::findOrFail($id);
        $pengambilan->delete();

        return redirect()->route('pengambilan-obat.index')->with('success', 'Data berhasil dihapus.');
    }
}
