<?php

namespace App\Http\Controllers\Apoteker;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\User;
use App\Models\Resep;
use App\Models\ResepDetail;
use App\Models\SediaanObat;
use Illuminate\Http\Request;
use App\Models\PengambilanObat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PengambilanObatDetail;
use Illuminate\Support\Facades\Storage;

class PengambilanObatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data pengambilan obat dengan relasi resep → pasien, dokter dan petugas
        $query = PengambilanObat::with(['resep.pasien', 'resep.user', 'user']);

        $allowedStatuses = ['belum', 'sudah diambil', 'diambil setengah'];

        if ($request->filled('status') && $request->status !== 'Semua' && in_array($request->status, $allowedStatuses)) {
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

    // Add this method to your PengambilanObatController
    public function getResepInfo($id)
    {
        $resep = Resep::with(['pasien', 'detail.obat.sediaan' => function ($query) {
            $query->where('jumlah', '>', 0)
                ->orderBy('tanggal_kadaluarsa', 'asc');
        }])->findOrFail($id);

        return response()->json([
            'pasien' => [
                'nama' => $resep->pasien->nama ?? 'Tidak Ada Data',
            ],
            'dokter' => $resep->user->nama_lengkap ?? 'Tidak Ada Data',
            'pelayanan' => $resep->pelayanan->nama_pelayanan ?? 'Tidak Ada Data',
            'tanggal' => $resep->tanggal ? \Carbon\Carbon::parse($resep->tanggal)->format('d-m-Y') : 'Tidak Ada Data',
            'obat' => $resep->detail->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_obat' => $item->obat->nama_obat,
                    'jumlah' => $item->jumlah,
                    'dosis' => $item->dosis,
                    'aturan_pakai' => $item->aturan_pakai,
                    'sediaan' => $item->obat->sediaan->map(function ($sediaan) {
                        return [
                            'id' => $sediaan->id,
                            'nama_sediaan' => $sediaan->nama_sediaan,
                            'stok' => $sediaan->jumlah,
                            'kadaluarsa' => $sediaan->tanggal_kadaluarsa
                                ? \Carbon\Carbon::parse($sediaan->tanggal_kadaluarsa)->format('d-m-Y')
                                : 'Tidak Ada Data'
                        ];
                    })
                ];
            })
        ]);
    }

    public function create()
    {
        $reseps = Resep::with('pasien')->get();
        $users = User::where('role_id', 5)->get(); // Assuming role_id 5 is for pharmacists
        return view('Apoteker.pengambilan-obat.create', compact('reseps', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'resep_id' => 'required|exists:resep,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_pengambilan' => 'required|date',
            'status_checklist' => 'required|in:belum,sudah diambil,diambil setengah',
        ]);

        DB::beginTransaction();
        try {
            $pengambilan = PengambilanObat::create([
                'resep_id' => $request->resep_id,
                'user_id' => $request->user_id,
                'tanggal_pengambilan' => $request->tanggal_pengambilan,
                'status_checklist' => $request->status_checklist,
            ]);

            $checklistIds = $request->input('checklist_ids', []);
            $sediaanData = $request->input('sediaan', []);

            foreach ($checklistIds as $resepDetailId) {
                $resepDetail = ResepDetail::with('obat')->findOrFail($resepDetailId);

                if (isset($sediaanData[$resepDetailId])) {
                    foreach ($sediaanData[$resepDetailId] as $sediaanId => $jumlahDiambil) {
                        if ($jumlahDiambil > 0) {
                            $sediaan = SediaanObat::findOrFail($sediaanId);
                            if ($sediaan->jumlah < $jumlahDiambil) {
                                throw new \Exception("Stok tidak mencukupi untuk {$resepDetail->obat->nama_obat}");
                            }

                            $sediaan->decrement('jumlah', $jumlahDiambil);

                            PengambilanObatDetail::create([
                                'pengambilan_obat_id' => $pengambilan->id,
                                'resep_detail_id' => $resepDetailId,
                                'sediaan_obat_id' => $sediaanId,
                                'jumlah_diambil' => $jumlahDiambil,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('pengambilan-obat.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    private function kurangiStokSediaan(Obat $obat, int $jumlah, $tanggalPengambilan)
    {
        $sediaans = SediaanObat::where('obat_id', $obat->id)
            ->where('status', 'aktif')
            ->where('jumlah', '>', 0)
            ->orderBy('tanggal_masuk')
            ->get();

        foreach ($sediaans as $sediaan) {
            if ($jumlah <= 0) break;

            $pengurangan = min($jumlah, $sediaan->jumlah);
            $sediaan->jumlah -= $pengurangan;
            $sediaan->tanggal_keluar = $sediaan->jumlah == 0 ? $tanggalPengambilan : $sediaan->tanggal_keluar;
            $sediaan->save();

            $jumlah -= $pengurangan;
        }

        if ($jumlah > 0) {
            throw new \Exception("Stok sediaan untuk '{$obat->nama_obat}' tidak mencukupi.");
        }
    }

    public function edit($id)
    {
        $pengambilan = PengambilanObat::with(['resep.pasien', 'details.sediaanObat'])->findOrFail($id);
        $reseps = ResepDetail::with(['obat.sediaan', 'pengambilanObatDetail'])
            ->where('resep_id', $pengambilan->resep_id)
            ->get();
        $users = User::where('role_id', 5)->get();

        return view('Apoteker.pengambilan-obat.edit', compact('pengambilan', 'reseps', 'users'));
    }

    public function update(Request $request, $id)
    {
        $pengambilan = PengambilanObat::findOrFail($id);

        // Jika hanya ingin mengupdate status tanpa mengubah data lain
        $pengambilan->status_checklist = $request->status_checklist;
        $pengambilan->save();

        return redirect()->route('pengambilan-obat.index')->with('success', 'Status pengambilan berhasil diperbarui.');
    }

    // public function update(Request $request, $id)
    // {
    //     $checklistIds = $request->input('checklist_ids', []);
    //     $sediaanData = $request->input('sediaan', []);
    //     $checkedReseps = ResepDetail::with('obat')
    //         ->whereIn('id', $checklistIds)
    //         ->get();

    //     $pengambilan = PengambilanObat::findOrFail($id);

    //     DB::beginTransaction();
    //     try {
    //         foreach ($checkedReseps as $resepDetail) {
    //             // $resepDetail = ResepDetail::findOrFail($resepId);

    //             // Tandai resep detail sudah dicheck
    //             $resepDetail->tanggal_pengambilan = Carbon::now();
    //             $resepDetail->save();

    //             // Kurangi stok sediaan obat
    //             if (isset($sediaanData[$resepDetail->id])) {
    //                 foreach ($sediaanData[$resepDetail->id] as $sediaanId => $jumlahDiambil) {
    //                     if ($jumlahDiambil > 0) {
    //                         $sediaan = SediaanObat::find($sediaanId);
    //                         if ($sediaan && $sediaan->jumlah >= $jumlahDiambil) {
    //                             $sediaan->decrement('jumlah', $jumlahDiambil);
    //                             Log::info('Pengambilan detail', [
    //                                 'pengambilan_obat_id' => $pengambilan->id,
    //                                 'resep_detail_id' => $resepDetail->id,
    //                                 'sediaan_obat_id' => $sediaanId,
    //                                 'jumlah_diambil' => $jumlahDiambil,
    //                             ]);

    //                             // Catat detail pengambilan
    //                             try {
    //                                 PengambilanObatDetail::create([
    //                                     'pengambilan_obat_id' => $pengambilan->id,
    //                                     'resep_detail_id' => $resepDetail->id,
    //                                     'sediaan_obat_id' => $sediaanId,
    //                                     'jumlah_diambil' => $jumlahDiambil,
    //                                 ]);
    //                             } catch (\Throwable $th) {
    //                                 Log::error('Gagal menyimpan detail pengambilan obat', [
    //                                     'error' => $th->getMessage(),
    //                                     'pengambilan_obat_id' => $pengambilan->id,
    //                                     'resep_detail_id' => $resepDetail->id,
    //                                     'sediaan_obat_id' => $sediaanId,
    //                                     'jumlah_diambil' => $jumlahDiambil,
    //                                 ]);
    //                                 throw new \Exception('Gagal menyimpan detail pengambilan obat: ' . $th->getMessage());
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         $pengambilan->status_checklist = $request->status_checklist;
    //         $pengambilan->save();

    //         DB::commit();

    //         return redirect()->route('pengambilan-obat.index')->with('success', 'Data berhasil diperbarui.');
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', $th->getMessage());
    //     }
    // }

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


    public function index_obat_pasien(Request $request)
    {
        // Ambil data pengambilan obat dengan relasi resep → pasien, dokter dan petugas
        $query = PengambilanObat::with(['resep.pasien', 'resep.user', 'user']);

        $allowedStatuses = ['belum', 'sudah diambil', 'diambil setengah'];
        // Validasi status yang diterima
        if ($request->filled('status') && $request->status !== 'Semua' && in_array($request->status, $allowedStatuses)) {
            $query->where('status_checklist', $request->status);
        }

        // Paginate data utama yang ditampilkan di tabel
        $pengambilanObats = $query->orderBy('tanggal_pengambilan', 'desc')->paginate(10)->withQueryString();

        // Data dropdown untuk modal tambah
        $reseps = Resep::with('pasien')->get();
        $user = Auth::user()->id;
        $users = User::where('id', $user)->first();
        return view('Apoteker.pengambilan-obat-pasien.index', compact('pengambilanObats', 'reseps', 'users'));
    }

    public function show_obat_pasien($id)
    {
        $pengambilan = PengambilanObat::with(['resep.pasien', 'resep.user', 'user'])->findOrFail($id);
        return view('Apoteker.pengambilan-obat-pasien.detail', compact('pengambilan'));
    }

    public function edit_obat_pasien($id)
    {
        $pengambilan = PengambilanObat::with(['resep.pasien', 'details.sediaanObat'])->findOrFail($id);
        $reseps = ResepDetail::with(['obat.sediaan', 'pengambilanObatDetail'])
            ->where('resep_id', $pengambilan->resep_id)
            ->get();
        $users = User::where('role_id', 5)->get();

        return view('Apoteker.pengambilan-obat-pasien.edit', compact('pengambilan', 'reseps', 'users'));
    }

    public function update_obat_pasien(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_pengambil' => 'required|string|max:255',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Temukan data pengambilan obat
        $pengambilan = PengambilanObat::findOrFail($id);

        DB::beginTransaction();
        try {
            // Update hanya nama_pengambil dan bukti_foto
            $pengambilan->nama_pengambil = $request->nama_pengambil;

            if ($request->hasFile('bukti_foto')) {
                // Hapus foto lama jika ada
                if ($pengambilan->bukti_foto) {
                    Storage::disk('public')->delete($pengambilan->bukti_foto);
                }
                // Simpan foto baru
                $pengambilan->bukti_foto = $request->file('bukti_foto')->store('bukti_foto', 'public');
            }

            $pengambilan->save();

            DB::commit();

            return redirect()->route('pengambilan-obat-pasien.index')
                ->with('success', 'Data pengambilan obat berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
        // $checklistIds = $request->input('checklist_ids', []);
        // $pengambilan = PengambilanObat::findOrFail($id);
        // $pengambilan->nama_pengambil = $request->nama_pengambil;
        // $pengambilan->status_checklist = $request->status_checklist;

        // if ($request->hasFile('bukti_foto')) {
        //     $pengambilan->bukti_foto = $request->file('bukti_foto')->store('bukti_foto', 'public');
        // }

        // $pengambilan->save();

        // // Hanya proses checklist jika status sudah diambil / diambil setengah
        // if (in_array($request->status_checklist, ['sudah diambil', 'diambil setengah'])) {
        //     $checkedReseps = ResepDetail::with('obat')->whereIn('id', $checklistIds)->get();

        //     foreach ($checkedReseps as $resepDetail) {
        //         if ($resepDetail->status !== 'diambil') {
        //             $jumlah = $resepDetail->jumlah;
        //             $obat = $resepDetail->obat;

        //             if ($obat && $obat->stok_total >= $jumlah) {
        //                 // $obat->stok_total -= $jumlah;
        //                 // $obat->save();
        //                 $this->kurangiStokSediaan($obat, $jumlah, now());
        //                 $obat->stok_total = SediaanObat::where('obat_id', $obat->id)->sum('jumlah');
        //                 $obat->save();


        //                 $resepDetail->status = "diambil";
        //                 $resepDetail->tanggal_penyerahan = Carbon::now();
        //                 $resepDetail->save();
        //             }
        //         }
        //     }
        // }
        // return redirect()->route('pengambilan-obat-pasien.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy_obat_pasien($id)
    {
        $pengambilan = PengambilanObat::findOrFail($id);
        $pengambilan->delete();

        return redirect()->route('pengambilan-obat-pasien.index')->with('success', 'Data berhasil dihapus.');
    }

    public function getResepDetail($id)
    {
        $resep = Resep::with('detail.obat')->findOrFail($id);

        $data = $resep->detail->map(function ($detail) {
            return [
                'nama_obat' => $detail->obat->nama_obat,
                'jumlah' => $detail->jumlah,
                'dosis' => $detail->dosis,
            ];
        });

        return response()->json($data);
    }
}
