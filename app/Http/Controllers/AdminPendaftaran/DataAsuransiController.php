<?php

namespace App\Http\Controllers\AdminPendaftaran;

use App\Models\Asuransi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataAsuransiController extends Controller
{
    public function index(Request $request)
    {
        $query = Asuransi::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_perusahaan', 'like', "%$keyword%")
                    ->orWhere('nomor_polis', 'like', "%$keyword%")
                    ->orWhere('jenis_asuransi', 'like', "%$keyword%");
            });
        }

        $asuransis = $query->orderBy('created_at', 'desc')->paginate(5);

        return view('AdminPendaftaran.data-asuransi.index', compact('asuransis'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'nomor_polis' => 'required|string|max:255',
            'jenis_asuransi' => 'required|string|max:255',
            'masa_berlaku_mulai' => 'required|date',
            'masa_berlaku_akhir' => 'required|date|after_or_equal:masa_berlaku_mulai',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        Asuransi::create($validated);

        return redirect()->route('data-asuransi.index')->with('success', 'Data asuransi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $asuransi = Asuransi::findOrFail($id);
        return view('AdminPendaftaran.data-asuransi.edit', compact('asuransi'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'nomor_polis' => 'required|string|max:255',
            'jenis_asuransi' => 'required|string|max:255',
            'masa_berlaku_mulai' => 'required|date',
            'masa_berlaku_akhir' => 'required|date|after_or_equal:masa_berlaku_mulai',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $asuransi = Asuransi::findOrFail($id);
        $asuransi->update($validated);

        return redirect()->route('data-asuransi.index')->with('success', 'Data asuransi berhasil diperbarui.');
    }

    public function show($id)
    {
        $asuransi = Asuransi::findOrFail($id);
        return view('AdminPendaftaran.data-asuransi.show', compact('asuransi'));
    }

    public function destroy($id)
    {
        $asuransi = Asuransi::findOrFail($id);
        $asuransi->delete();

        return redirect()->route('data-asuransi.index')->with('success', 'Data asuransi berhasil dihapus.');
    }
}