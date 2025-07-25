<?php

namespace App\Http\Controllers\AdminPendaftaran;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Asuransi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataPasienController extends Controller
{
    public function index(Request $request)
    {
        $query = Pasien::query();

        // Filter berdasarkan bulan dan tahun
        if ($request->has('filter_bulan') && $request->filter_bulan) {
            $bulanTahun = explode('-', $request->filter_bulan);
            $tahun = $bulanTahun[0];
            $bulan = $bulanTahun[1];

            $query->whereYear('tanggal_daftar', $tahun)
                ->whereMonth('tanggal_daftar', $bulan);
        }

        // Filter berdasarkan nama atau NIK
        if ($request->has('keyword') && $request->keyword) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhere('NIK', 'like', '%' . $keyword . '%');
            });
        }

        // Filter berdasarkan jenis kelamin
        if ($request->has('filter_gender') && in_array($request->filter_gender, ['L', 'P'])) {
            $query->where('jenis_kelamin', $request->filter_gender);
        }

        // ✅ Filter berdasarkan status asuransi (punya/tidak)
        if ($request->has('filter_asuransi') && $request->filter_asuransi) {
            if ($request->filter_asuransi === 'punya') {
                $query->whereNotNull('asuransi_id');
            } elseif ($request->filter_asuransi === 'tidak') {
                $query->whereNull('asuransi_id');
            }
        }

        $pasiens = $query->paginate(10)->withQueryString();
        $asuransis = Asuransi::all();

        return view('AdminPendaftaran.data-pasien.index', compact('pasiens', 'asuransis'));
    }



    public function create()
    {
        $asuransis = Asuransi::all();
        return view('AdminPendaftaran.data-pasien.tambah', compact('asuransis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'NIK' => 'required|unique:pasien,NIK',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'no_hp' => 'required',
            'asuransi_id' => 'nullable|exists:asuransi,id',
        ]);
        // Tambahkan tanggal_daftar secara otomatis
        $validated['tanggal_daftar'] = Carbon::now()->toDateString();

        Pasien::create($validated);

        return redirect()->back()->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pasien = Pasien::with('asuransi')->findOrFail($id);
        return view('AdminPendaftaran.data-pasien.detail', compact('pasien'));
    }

    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        $asuransis = Asuransi::all();
        return view('AdminPendaftaran.data-pasien.edit', compact('pasien', 'asuransis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NIK' => 'required|unique:pasien,NIK,' . $id,
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'no_hp' => 'required',
            'tanggal_daftar' => 'required|date',
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->all());

        return redirect()->route('data-pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()->route('data-pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }
}
