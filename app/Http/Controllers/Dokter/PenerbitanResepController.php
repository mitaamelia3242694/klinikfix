<?php

namespace App\Http\Controllers\Dokter;

use App\Models\Obat;
use App\Models\Pelayanan;
use App\Models\User;
use App\Models\Resep;
use App\Models\Pasien;
use App\Models\ResepDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PenerbitanResepController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $reseps = Resep::with(['pasien', 'user', 'detail.obat'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('pasien', function ($q) use ($keyword) {
                    $q->where('nama', 'like', '%' . $keyword . '%');
                })->orWhereHas('user', function ($q) use ($keyword) {
                    $q->where('nama_lengkap', 'like', '%' . $keyword . '%');
                });
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->withQueryString(); // penting agar pencarian tetap terjaga di halaman berikutnya

        $pasiens = Pendaftaran::whereDate('created_at', Carbon::today())->get();
        $user = Auth::user()->id;
        $dokters = User::where('id', $user)->first();
        $obats = Obat::all();
        $pelayanans = Pelayanan::all();


        return view('Dokter.penerbitan-resep.index', compact('reseps', 'pasiens', 'dokters', 'obats', 'pelayanans'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'obat_id' => 'required|array|min:1',
            'obat_id.*' => 'required|exists:obat,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'dosis' => 'required|array|min:1',
            'dosis.*' => 'required|string',
            'aturan_pakai' => 'required|array|min:1',
            'aturan_pakai.*' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $resep = Resep::create([
                'pasien_id' => $request->pasien_id,
                'user_id' => $request->user_id,
                'pelayanan_id' => $request->pelayanan_id,
                'tanggal' => $request->tanggal,
                'catatan' => $request->catatan,
            ]);

            foreach ($request->obat_id as $i => $obatId) {
                ResepDetail::create([
                    'resep_id' => $resep->id,
                    'obat_id' => $obatId,
                    'jumlah' => $request->jumlah[$i],
                    'dosis' => $request->dosis[$i],
                    'aturan_pakai' => $request->aturan_pakai[$i],
                ]);
            }

            DB::commit();
            return redirect()->route('penerbitan-resep.index')->with('success', 'Resep berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Gagal menyimpan resep: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $resep = Resep::with(['pasien', 'user', 'detail.obat'])->findOrFail($id);
        return view('Dokter.penerbitan-resep.show', compact('resep'));
    }

    public function edit($id)
    {
        $resep = Resep::with(['detail'])->findOrFail($id);
        $pasiens = Pasien::all();
        $user = Auth::user()->id;
        $dokters = User::where('id', $user)->first();
        $obats = Obat::all();

        return view('Dokter.penerbitan-resep.edit', compact('resep', 'pasiens', 'dokters', 'obats'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'obat_id' => 'required|array|min:1',
            'obat_id.*' => 'required|exists:obat,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'dosis' => 'required|array|min:1',
            'dosis.*' => 'required|string',
            'aturan_pakai' => 'required|array|min:1',
            'aturan_pakai.*' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $resep = Resep::findOrFail($id);
            $resep->update([
                'pasien_id' => $request->pasien_id,
                'user_id' => $request->user_id,
                'tanggal' => $request->tanggal,
                'catatan' => $request->catatan,
            ]);

            // Hapus semua detail lama lalu buat ulang
            $resep->detail()->delete();

            foreach ($request->obat_id as $i => $obatId) {
                ResepDetail::create([
                    'resep_id' => $resep->id,
                    'obat_id' => $obatId,
                    'jumlah' => $request->jumlah[$i],
                    'dosis' => $request->dosis[$i],
                    'aturan_pakai' => $request->aturan_pakai[$i],
                ]);
            }

            DB::commit();
            return redirect()->route('penerbitan-resep.index')->with('success', 'Resep berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Gagal memperbarui resep: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $resep = Resep::findOrFail($id);
            $resep->detail()->delete();
            $resep->delete();

            return redirect()->route('penerbitan-resep.index')->with('success', 'Resep berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors('Gagal menghapus resep: ' . $e->getMessage());
        }
    }
}