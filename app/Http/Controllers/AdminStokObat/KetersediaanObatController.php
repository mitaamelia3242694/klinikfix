<?php

namespace App\Http\Controllers\AdminStokObat;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\SediaanObat;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KetersediaanObatController extends Controller
{
    public function index(Request $request)
    {
        $query = SediaanObat::with('obat.satuan', 'obat.resepDetails')->latest();

        // Filter untuk obat hampir kadaluarsa
        if ($request->has('expiring_soon')) {
            $query->whereDate('tanggal_kadaluarsa', '<=', Carbon::now()->addDays(7));
        }

        $sediaans = $query->get();
        $obats = Obat::with('satuan', 'resepDetails')->get();

        foreach ($sediaans as $sediaan) {
            $obat = $sediaan->obat;

            // Total resep keluar keseluruhan
            $sediaan->jumlah_keluar_total = $obat->resepDetails->sum('jumlah');

            // Jumlah keluar hari ini
            $sediaan->jumlah_keluar_hari_ini = $obat->resepDetails
                ->where('created_at', '>=', Carbon::today())
                ->sum('jumlah');
        }

        // Hitung stok tersisa per obat (tidak wajib jika tidak digunakan)
        foreach ($obats as $obat) {
            $jumlahTerpakai = $obat->resepDetails()->sum('jumlah');
            $obat->stok_tersisa = $obat->stok_total - $jumlahTerpakai;
        }


        $start = Carbon::now()->startOfMonth()->toDateString();
        $end = Carbon::now()->endOfMonth()->toDateString();
        $riwayatObat = DB::table('resep_detail')
            ->selectRaw('obat_id, DATE(created_at) as tanggal, SUM(jumlah) as jumlah')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('obat_id', 'tanggal')
            ->get()
            ->groupBy('obat_id'); // hasilnya: $riwayatObat[obat_id] => list harian

        foreach ($obats as $obat) {
            $obat->jumlah = $obat->sediaan->sum('jumlah') ?? 0;
            $obat->stok_awal = 0;
            $obat->stok_akhir = 0;
            $obat->stok_total = $obat->stok_total ?? 0;
        }

        return view('AdminStokObat.kesediaan-obat.index', compact('sediaans', 'obats', 'riwayatObat'));
    }

    public function store(Request $request)
    {


        // Validasi input
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'tanggal_kadaluarsa' => 'required|date',
            'tanggal_keluar' => 'nullable|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Simpan ke tabel sediaan_obat
        SediaanObat::create([
            'obat_id' => $request->obat_id,
            'tanggal_masuk' => Carbon::now(),
            'tanggal_keluar' => $request->tanggal_keluar ?: null,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data ketersediaan obat berhasil ditambahkan.');
    }




    public function show($id)
    {
        $sediaan = SediaanObat::with('obat.satuan')->findOrFail($id);
        return view('AdminStokObat.kesediaan-obat.show', compact('sediaan'));
    }

    public function edit($id)
    {
        $sediaan = SediaanObat::findOrFail($id);
        $obats = Obat::with('satuan')->get();
        return view('AdminStokObat.kesediaan-obat.edit', compact('sediaan', 'obats'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'required|date|after_or_equal:tanggal_masuk',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:tanggal_keluar',
            'stok_total' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $sediaan = SediaanObat::findOrFail($id);


        // Tambah stok ke tabel Obat
        $obat = $sediaan->obat;
        $obat->stok_total += $request->stok_total;
        $obat->save();

        // Update data sediaan_obat
        $sediaan->update([
            'obat_id' => $request->obat_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'tanggal_keluar' => $request->tanggal_keluar,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('kesediaan-obat.index')
            ->with('success', 'Data berhasil diperbarui dan stok ditambahkan.');
    }



    public function destroy($id)
    {
        $sediaan = SediaanObat::findOrFail($id);
        $sediaan->delete();

        return redirect()->route('kesediaan-obat.index')->with('success', 'Data berhasil dihapus.');
    }
}
