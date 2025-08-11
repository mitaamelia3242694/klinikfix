<?php

namespace App\Http\Controllers\Dokter;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Pelayanan;
use Illuminate\Http\Request;
use App\Models\DiagnosaAkhir;
use App\Models\MasterDiagnosa;
use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Pendaftaran;
use App\Models\PengkajianAwal;
use App\Models\Tindakan;
use Carbon\Carbon;
use App\Models\Resep;
use Illuminate\Support\Facades\Auth;

class PencatatanDiagnosaController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $pendaftarans = Pendaftaran::with(['pasien', 'dokter', 'diagnosaAwal'])
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('pasien', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%{$keyword}%");
                })->orWhereHas('dokter', function ($q) use ($keyword) {
                    $q->where('nama_lengkap', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->appends(['keyword' => $keyword]);
        $diagnosas = DiagnosaAkhir::with(['pasien', 'user', 'masterDiagnosa', 'pelayanan', 'pengkajianAwal'])->paginate(10);

        $pasiens = Pendaftaran::whereDate('created_at', Carbon::today())->get(); // untuk dropdown modal
        $dokters = User::where('role_id', '3')->get();
        $masters = MasterDiagnosa::all();
        $layanans = Pelayanan::all();
        $obats = Obat::all();
        $tindakans = Tindakan::all();

        // $pendaftarans = Pendaftaran::whereDate('created_at', Carbon::today())->get(); // untuk dropdown tambah
        $user = Auth::user()->id;
        $dokters = User::where('id', $user)->first();
        $pengkajian = PengkajianAwal::all();

        return view('Dokter.pencatatan-diagnosa.index', compact('pendaftarans', 'dokters', 'masters', 'layanans', 'obats', 'tindakans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'diagnosa' => 'required|string',
            'master_diagnosa_id' => 'required|exists:master_diagnosa,id',
            'pelayanan_id' => 'required|exists:pelayanan,id',
            'catatan' => 'nullable|string',
        ]);

        // Ambil ID pendaftaran dari terbaru
        $pendaftaran = Pendaftaran::where('pasien_id', $request->pasien_id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$pendaftaran) {
            return redirect()->back()->withErrors(['error' => 'Pendaftaran tidak ditemukan untuk pasien ini.']);
        }

        DiagnosaAkhir::create([
            'pendaftaran_id' => $pendaftaran->id,
            'pasien_id' => $request->pasien_id,
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'diagnosa' => $request->diagnosa,
            'master_diagnosa_id' => $request->master_diagnosa_id,
            'pelayanan_id' => $request->pelayanan_id,
            'catatan' => $request->catatan,
        ]);

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
