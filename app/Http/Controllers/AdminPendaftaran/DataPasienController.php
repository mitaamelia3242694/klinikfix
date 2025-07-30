<?php

namespace App\Http\Controllers\AdminPendaftaran;

use App\Models\Pendaftaran;
use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Asuransi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataPasienController extends Controller
{
    public function index(Request $request)
    {
        $query = Pasien::query()->orderBy('created_at', 'desc');

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

    public function riwayatAjax($id)
    {
        $pasien = Pasien::findOrFail($id);

        $riwayat = Pendaftaran::with([
            'pasien',
            'dokter',
            'tindakan',
            'diagnosaAwal',
            'diagnosaAkhir',
            'resep.detail.obat'
        ])
            ->where('pasien_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_pasien' => $item->pasien->nama,
                    'tanggal' => $item->created_at->format('d F Y'),
                    'keluhan' => $item->keluhan ?? '-',
                    'tindakan' => $item->tindakan->jenis_tindakan ?? '-',
                    'diagnosa_awal' => $item->diagnosaAwal->diagnosa ?? '-',
                    'diagnosa_akhir' => $item->diagnosaAkhir->diagnosa ?? '-',
                    'resep' => $item->resep->isEmpty() ? null : $item->resep->map(function ($resep) {
                        return $resep->detail->map(function ($detail) {
                            return [
                                'nama_obat' => $detail->obat->nama_obat ?? '-',
                                'dosis' => $detail->dosis,
                                'aturan_pakai' => $detail->aturan_pakai
                            ];
                        });
                    })
                ];
            });

        return response()->json([
            'pasien' => [
                'nama' => $pasien->nama,
                'NIK' => $pasien->NIK,
                'tanggal_lahir_formatted' => \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d-m-Y'),
                'jenis_kelamin' => $pasien->jenis_kelamin,
                'no_hp' => $pasien->no_hp
            ],
            'riwayat' => $riwayat
        ]);
    }
}
