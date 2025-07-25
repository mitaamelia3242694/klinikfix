<?php

namespace App\Http\Controllers\Perawat;

use App\Models\User;
use App\Models\Pasien;
use App\Models\DiagnosaAwal;
use Illuminate\Http\Request;
use App\Models\MasterDiagnosa;
use App\Models\Pendaftaran;
use App\Models\Pelayanan;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DataDiagnosaAwalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $masters = MasterDiagnosa::all();
        $layanans = Pelayanan::all();
        $diagnosas = DiagnosaAwal::with(['pasien', 'user'])
            ->when($search, function ($query, $search) {
                $query->whereHas('pasien', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%');
                })->orWhereHas('user', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        $pendaftarans = Pendaftaran::whereDate('created_at', Carbon::today())->get(); // untuk dropdown tambah
        $user = Auth::user()->id;
        $perawats = User::where('id', $user)->first();
        return view('Perawat.data-diagnosa-awal.index', compact('diagnosas', 'pendaftarans', 'search', 'masters', 'layanans', 'perawats'));
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'diagnosa' => 'required|string',
            'master_diagnosa_id' => 'required|exists:master_diagnosa,id',
            'pelayanan_id' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status' => 'required|in:belum_diperiksa,sudah_diperiksa',
        ]);

        DiagnosaAwal::create([
            'pasien_id' => $request->pasien_id,
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'diagnosa' => $request->diagnosa,
            'master_diagnosa_id' => $request->master_diagnosa_id,
            'pelayanan_id' => $request->pelayanan_id,
            'catatan' => $request->catatan,
            'status' => $request->status,
        ]);

        return redirect()->route('data-diagnosa-awal.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        $diagnosa = DiagnosaAwal::with(['pasien', 'user'])->findOrFail($id);

        return view('Perawat.data-diagnosa-awal.show', compact('diagnosa'));
    }

    public function edit($id)
    {
        $diagnosa = DiagnosaAwal::findOrFail($id);
        $pendaftarans = Pendaftaran::with('pasien')->get(); // ambil dari pendaftaran
        $user = Auth::user()->id;
        $perawats = User::where('id', $user)->first();
        $masters = MasterDiagnosa::all();
        $layanans = Pelayanan::all();

        return view('Perawat.data-diagnosa-awal.edit', compact('diagnosa', 'pendaftarans', 'perawats', 'masters', 'layanans'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'diagnosa' => 'required|string',
            'catatan' => 'nullable|string',
            'master_diagnosa_id' => 'required|exists:master_diagnosa,id',
            'pelayanan_id' => 'required|exists:pelayanan,id', // ✅ diganti dari 'pelayanan'
            'status' => 'required|in:belum_diperiksa,sudah_diperiksa',
        ]);

        $diagnosa = DiagnosaAwal::findOrFail($id);
        $diagnosa->update($validated);

        return redirect()->route('data-diagnosa-awal.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $diagnosa = DiagnosaAwal::findOrFail($id);
        $diagnosa->delete();

        return redirect()->route('data-diagnosa-awal.index')->with('success', 'Data berhasil dihapus.');
    }
}
