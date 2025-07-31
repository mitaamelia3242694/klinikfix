<?php

namespace App\Http\Controllers\Apoteker;

use App\Models\User;
use App\Models\Resep;
use App\Models\ResepDetail;
use Carbon\Carbon;
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

        $allowedStatuses = ['belum', 'sudah diambil', 'diambil setengah'];

        if ($request->filled('status') && $request->status !== 'Semua' && in_array($request->status, $allowedStatuses)) {
            $query->where('status_checklist', $request->status);
        }

        // Filter berdasarkan status checklist jika ada
        // if ($request->filled('status') && $request->status !== 'Semua') {
        //     $query->where('status_checklist', $request->status);
        // }


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
            // dd($e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $pengambilan = PengambilanObat::findOrFail($id);
        $reseps = ResepDetail::with(['resep.pasien', 'obat'])
            ->where('resep_id', $pengambilan->resep_id)->get();
        $users = User::where('role_id', 5)->get();

        return view('Apoteker.pengambilan-obat.edit', compact('pengambilan', 'reseps', 'users'));
    }

    public function update(Request $request, $id)
    {

        $checklistIds = $request->input('checklist_ids', []);
        $checkedReseps = ResepDetail::with('obat')
            ->whereIn('id', $checklistIds)
            ->get();

        $pengambilan = PengambilanObat::findOrFail($id);

        foreach ($checkedReseps as $resepDetail) {

            // Tandai resep detail sudah dicheck
            $resepDetail->tanggal_pengambilan = Carbon::now();
            $resepDetail->save();

            $pengambilan->status_checklist = $request->status_checklist;
            $pengambilan->save();
        }

        return redirect()->route('pengambilan-obat.index')->with('success', 'Data berhasil diperbarui.');
    }




    // $request->validate([
    //     'resep_id' => 'required|exists:resep,id',
    //     'user_id' => 'required|exists:users,id',
    //     'tanggal_pengambilan' => 'required|date',
    //     'status_checklist' => 'required|in:belum,sudah',
    // ]);

    // $pengambilan = PengambilanObat::findOrFail($id);
    // $statusSebelumnya = $pengambilan->status_checklist;
    // $checklistIds = $request->input('checklist_ids', []);



    // DB::beginTransaction();


    //     $pengambilan->update($request->all());

    //     // Jalankan pengurangan stok hanya jika status berubah jadi "sudah"
    //     if ( $request->status_checklist === 'sudah') {
    //         $resep = Resep::with('detail')->findOrFail($request->resep_id);
    //          $obat= Obat::whereIn('id', $checklistIds)->update(['is_checked' => true]);

    //             $jumlah = $detail->jumlah;

    //             if ($obat->stok_total < $jumlah) {
    //                 throw new \Exception("Stok obat '{$obat->nama_obat}' tidak mencukupi. Dibutuhkan: {$jumlah}, tersedia: {$obat->stok_total}");
    //             }

    //             $obat->stok_total -= $jumlah;
    //             $obat->save();

    //             // Tandai tanggal_keluar di entri SediaanObat (jika belum diisi)
    //             SediaanObat::where('obat_id', $obat->id)
    //                 ->orderBy('tanggal_masuk', 'asc')
    //                 ->limit(1)
    //                 ->update(['tanggal_keluar' => $request->tanggal_pengambilan]);
    //         }
    //     }

    //     return redirect()->route('pengambilan-obat.index')->with('success', 'Data berhasil diperbarui.');




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

        // Filter berdasarkan status checklist jika ada
        // if ($request->filled('status') && $request->status !== 'Semua') {
        //     $query->where('status_checklist', $request->status);
        // }

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


    public function update_obat_pasien(Request $request, $id)
    {
        $checklistIds = $request->input('checklist_ids', []);
        $pengambilan = PengambilanObat::findOrFail($id);
        $pengambilan->nama_pengambil = $request->nama_pengambil;
        $pengambilan->status_checklist = $request->status_checklist;

        if ($request->hasFile('bukti_foto')) {
            $pengambilan->bukti_foto = $request->file('bukti_foto')->store('bukti_foto', 'public');
        }

        $pengambilan->save();

        // Hanya proses checklist jika status sudah diambil / diambil setengah
        if (in_array($request->status_checklist, ['sudah diambil', 'diambil setengah'])) {
            $checkedReseps = ResepDetail::with('obat')->whereIn('id', $checklistIds)->get();

            foreach ($checkedReseps as $resepDetail) {
                if ($resepDetail->status !== 'diambil') {
                    $jumlah = $resepDetail->jumlah;
                    $obat = $resepDetail->obat;

                    if ($obat && $obat->stok_total >= $jumlah) {
                        $obat->stok_total -= $jumlah;
                        $obat->save();

                        $resepDetail->status = "diambil";
                        $resepDetail->tanggal_penyerahan = Carbon::now();
                        $resepDetail->save();
                    }
                }
            }
        }
        return redirect()->route('pengambilan-obat-pasien.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function edit_obat_pasien($id)
    {
        $pengambilan = PengambilanObat::findOrFail($id);
        $reseps = ResepDetail::with(['resep.pasien', 'obat'])->where('resep_id', $pengambilan->resep_id)
            ->get();
        $users = User::where('role_id', 5)->get();

        return view('Apoteker.pengambilan-obat-pasien.edit', compact('pengambilan', 'reseps', 'users'));
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
