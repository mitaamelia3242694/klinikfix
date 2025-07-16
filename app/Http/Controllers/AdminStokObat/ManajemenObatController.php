<?php

namespace App\Http\Controllers\AdminStokObat;

use App\Models\Obat;
use App\Models\SatuanObat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManajemenObatController extends Controller
{
    public function index(Request $request)
    {
        $satuans = SatuanObat::all();
        $filterBulan = $request->filter_bulan;

        $query = Obat::with(['satuan', 'sediaan']);

        if ($filterBulan) {
            [$tahun, $bulan] = explode('-', $filterBulan);
            $query->whereHas('sediaan', function ($q) use ($tahun, $bulan) {
                $q->whereYear('tanggal_masuk', $tahun)
                  ->whereMonth('tanggal_masuk', $bulan);
            });
        }

        // Ambil 10 per halaman dan simpan parameter query (seperti filter_bulan)
        $obats = $query->paginate(10)->withQueryString();

        // Tambahkan properti stok_tersisa pada setiap item
        foreach ($obats as $obat) {
            $jumlahTerpakai = $obat->resepDetails()->sum('jumlah');
            $obat->stok_tersisa = $obat->stok_total - $jumlahTerpakai;
        }

        return view('AdminStokObat.menejemen-obat.index', compact('obats', 'satuans'));
    }

    public function create()
    {
        $satuans = SatuanObat::all();
        return view('AdminStokObat.menejemen-obat.tambah', compact('satuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'satuan_id' => 'required|exists:satuan_obat,id',
            'stok_total' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        Obat::create($request->all());

        return redirect()->route('menejemen-obat.index')->with('success', 'Data obat berhasil ditambahkan.');
    }

    public function show($id)
    {
        $obat = Obat::with('satuan')->findOrFail($id);
        return view('AdminStokObat.menejemen-obat.detail', compact('obat'));
    }

    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        $satuans = SatuanObat::all();
        return view('AdminStokObat.menejemen-obat.edit', compact('obat', 'satuans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'satuan_id' => 'required|exists:satuan_obat,id',
            'stok_total' => 'required|integer|min:0', // inputan user akan dianggap penambahan
            'keterangan' => 'nullable|string',
        ]);

        $obat = Obat::findOrFail($id);

        // Jumlahkan stok lama dengan stok baru
        $obat->stok_total += $request->stok_total;

        // Update field lain
        $obat->nama_obat = $request->nama_obat;
        $obat->satuan_id = $request->satuan_id;
        $obat->keterangan = $request->keterangan;
        $obat->save();

        return redirect()->route('menejemen-obat.index')->with('success', 'Stok obat berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('menejemen-obat.index')->with('success', 'Data obat berhasil dihapus.');
    }
}
