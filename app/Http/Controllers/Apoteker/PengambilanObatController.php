<?php

namespace App\Http\Controllers\Apoteker;

use App\Models\User;
use App\Models\Resep;
use Illuminate\Http\Request;
use App\Models\PengambilanObat;
use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\SediaanObat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user = Auth::user()->id;
        $users = User::where('id', $user)->first();
        return view('Apoteker.pengambilan-obat.index', compact('pengambilanObats', 'reseps', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'resep_id' => 'required|exists:resep,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_pengambilan' => 'required|date',
            'status_checklist' => 'required|in:belum,sudah',
        ]);

        DB::beginTransaction();

        try {
            if ($request->status_checklist === 'sudah') {
                $resep = Resep::with('detail')->findOrFail($request->resep_id);

                foreach ($resep->detail as $detail) {
                    $obat = Obat::findOrFail($detail->obat_id);
                    $jumlah = $detail->jumlah;

                    if ($obat->stok_total < $jumlah) {
                        throw new \Exception("Stok obat '{$obat->nama_obat}' tidak mencukupi.");
                    }

                    // Kurangi stok_total
                    $obat->stok_total -= $jumlah;
                    $obat->save();

                    // Tandai tanggal_keluar di entri SediaanObat (jika belum diisi)
                    SediaanObat::where('obat_id', $obat->id)
                        ->orderBy('tanggal_masuk', 'asc')
                        ->limit(1)
                        ->update(['tanggal_keluar' => $request->tanggal_pengambilan]);
                }
            }

            PengambilanObat::create($request->all());

            DB::commit();

            return redirect()->route('pengambilan-obat.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
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
            'status_checklist' => 'required|in:belum,sudah',
        ]);

        $pengambilan = PengambilanObat::findOrFail($id);
        $statusSebelumnya = $pengambilan->status_checklist;

        DB::beginTransaction();

        try {
            $pengambilan->update($request->all());

            // Jalankan pengurangan stok hanya jika status berubah jadi "sudah"
            if ($statusSebelumnya === 'belum' && $request->status_checklist === 'sudah') {
                $resep = Resep::with('detail')->findOrFail($request->resep_id);

                foreach ($resep->detail as $detail) {
                    $obat = Obat::findOrFail($detail->obat_id);
                    $jumlah = $detail->jumlah;

                    if ($obat->stok_total < $jumlah) {
                        throw new \Exception("Stok obat '{$obat->nama_obat}' tidak mencukupi. Dibutuhkan: {$jumlah}, tersedia: {$obat->stok_total}");
                    }

                    $obat->stok_total -= $jumlah;
                    $obat->save();

                    // Tandai tanggal_keluar di entri SediaanObat (jika belum diisi)
                    SediaanObat::where('obat_id', $obat->id)
                        ->orderBy('tanggal_masuk', 'asc')
                        ->limit(1)
                        ->update(['tanggal_keluar' => $request->tanggal_pengambilan]);
                }
            }

            DB::commit();

            return redirect()->route('pengambilan-obat.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
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
