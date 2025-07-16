<?php

namespace App\Http\Controllers\AdminStokObat;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\SediaanObat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KetersediaanObatController extends Controller
{
    public function index(Request $request)
    {
        $query = SediaanObat::with('obat.satuan')->latest();

        // Jika checkbox filter aktif
        if ($request->has('expiring_soon')) {
            $query->whereDate('tanggal_kadaluarsa', '<=', Carbon::now()->addDays(7));
        }

        $sediaans = $query->get();

        $obats = Obat::with('satuan')->get();

        // Hitung stok tersisa
        foreach ($obats as $obat) {
            $jumlahTerpakai = $obat->resepDetails()->sum('jumlah');
            $obat->stok_tersisa = $obat->stok_total - $jumlahTerpakai;
        }

        return view('AdminStokObat.kesediaan-obat.index', compact('sediaans', 'obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'required|date|after_or_equal:tanggal_masuk',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:tanggal_keluar',
            'keterangan' => 'nullable|string',
        ]);

        SediaanObat::create($request->all());

        return redirect()->route('kesediaan-obat.index')->with('success', 'Data berhasil ditambahkan.');
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
