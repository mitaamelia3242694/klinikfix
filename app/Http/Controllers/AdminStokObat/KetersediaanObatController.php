<?php

namespace App\Http\Controllers\AdminStokObat;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\SediaanObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class KetersediaanObatController extends Controller
{
    public function index(Request $request)
    {
        SediaanObat::where('tanggal_kadaluarsa', '<', Carbon::now())
            ->where('status', 'aktif')
            ->update(['status' => 'kadaluarsa']);

        $query = SediaanObat::with([
            'obat.satuan',
            'obat.resepDetails',
            'obat.pengambilanDetails' // pastikan relasi ini ada
        ])->where('status', 'aktif')->latest();

        if ($request->has('expiring_soon')) {
            $query->whereDate('tanggal_kadaluarsa', '<=', Carbon::now()->addDays(7));
        }

        $sediaans = $query->get();
        $obats = Obat::with('satuan', 'resepDetails', 'sediaan')->get();

        foreach ($sediaans as $sediaan) {
            $obat = $sediaan->obat;

            // Total keluar (global) dari stok_total
            $totalKeluar = $obat->pengambilanDetails->sum('jumlah_diambil');
            $keluarHariIni = $obat->pengambilanDetails
                ->where('created_at', '>=', Carbon::today())
                ->sum('jumlah_diambil');

            $sediaan->jumlah_keluar_total = $totalKeluar;
            $sediaan->jumlah_keluar_hari_ini = $keluarHariIni;

            // stok awal global sebelum batch ini masuk
            $stokAwalGlobal = $obat->stok_total - $sediaan->jumlah;
            $sediaan->stok_awal = max($stokAwalGlobal, 0);

            // stok akhir = stok_total - total keluar (global)
            $sediaan->stok_akhir = max($obat->stok_total - $totalKeluar, 0);

            // Simpan stok_total global biar view bisa akses
            $sediaan->stok_total_global = $obat->stok_total;
        }

        // Hitung stok tersisa per obat
        foreach ($obats as $obat) {
            // $jumlahTerpakai = $obat->resepDetails()->sum('jumlah');
            $obat->stok_tersisa = $obat->stok_total;
        }

        $start = Carbon::now()->startOfMonth()->toDateString();
        $end = Carbon::now()->endOfMonth()->toDateString();
        $riwayatObat = DB::table('resep_detail')
            ->selectRaw('obat_id, DATE(created_at) as tanggal, SUM(jumlah) as jumlah')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('obat_id', 'tanggal')
            ->get()
            ->groupBy('obat_id');

        return view('AdminStokObat.kesediaan-obat.index', compact('sediaans', 'obats', 'riwayatObat'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_kadaluarsa' => 'required|date',
            'tanggal_keluar' => 'nullable|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Simpan ke tabel sediaan_obat
        SediaanObat::create([
            'obat_id' => $request->obat_id,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => Carbon::now(),
            'tanggal_keluar' => $request->tanggal_keluar ?: null,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'keterangan' => $request->keterangan,
        ]);

        // Tambah stok ke tabel Obat
        $obat = Obat::find($request->obat_id);
        $obat->stok_total += $request->jumlah;
        $obat->save();

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
        $sediaan = SediaanObat::findOrFail($id);

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
