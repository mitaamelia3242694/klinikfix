<?php

namespace App\Http\Controllers\Perawat;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Pelayanan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Models\PengkajianAwal;
use App\Http\Controllers\Controller;
use App\Models\MasterDiagnosa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DataKajianAwalController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;

        $pengkajian = Pendaftaran::where('perawat_id', auth()->user()->id)->with(['perawat'])
            ->when($search, function ($query, $search) {
                $query->whereHas('perawat', function ($q) use ($search) {
                    $q->where('perawat_id', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(10);


        $masters = MasterDiagnosa::all();
        $pendaftarans = Pendaftaran::whereDate('created_at', Carbon::today())->get(); // untuk dropdown tambah
        $user = Auth::user()->id;
        $perawats = User::where('id', $user)->first();
        $layanans = Pelayanan::all();

        return view('Perawat.data-kajian-awal.index', compact('pengkajian', 'pendaftarans', 'perawats', 'layanans', 'masters'));
    }

    public function create()
    {
        $user = Auth::user()->id;
        return view('Perawat.data-kajian-awal.create', [
            'pasiens' => Pasien::all(),
            'perawats' => User::where('id', $user)->first(),
            'layanans' => Pelayanan::all(),
            'pendaftarans' => Pendaftaran::with('pasien')->get(),
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            // 'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'keluhan_utama' => 'required|string',
            'sistol' => 'required|string',
            'diastol' => 'required|string',
            'suhu_tubuh' => 'required|string',
            // 'status' => 'required|in:belum,sudah',
            'diagnosa_awal' => 'nullable|string', // ✅ tambahkan
            'pelayanan_id' => 'required|exists:pelayanan,id', // ✅ tambahkan
            'catatan' => 'nullable|string',
        ]);

        PengkajianAwal::create($request->all());

        return redirect()->route('data-kajian-awal.index')
            ->with('success', 'Data kajian awal berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kajian = PengkajianAwal::with(['pasien', 'user'])->findOrFail($id);

        return view('Perawat.data-kajian-awal.show', compact('kajian'));
    }

    public function edit($id)
    {
        $kajian = PengkajianAwal::findOrFail($id);
        $pasiens = Pasien::all();
        $user = Auth::user()->id;
        $perawats = User::where('id', $user)->first();
        $pendaftarans = Pendaftaran::with('pasien')->get();
        $layanans = Pelayanan::all();

        return view('Perawat.data-kajian-awal.edit', compact('kajian', 'pasiens', 'perawats', 'layanans', 'pendaftarans'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'pasien_id' => 'required|exists:pasien,id',
                'user_id' => 'required|exists:users,id',
                'tanggal' => 'required|date',
                'keluhan_utama' => 'required|string',
                'sistol' => 'required|string',
                'diastol' => 'required|string',
                'suhu_tubuh' => 'required|string',
                // 'status' => 'required|in:belum,sudah',
                'diagnosa_awal' => 'required|string', // ✅ tambahkan
                'pelayanan_id' => 'required|exists:pelayanan,id', // ✅ tambahkan
                'catatan' => 'nullable|string',
            ]);

            $kajian = PengkajianAwal::findOrFail($id);
            $kajian->update($request->all());

            return redirect()->route('data-kajian-awal.index')->with('success', 'Data kajian awal berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $kajian = PengkajianAwal::findOrFail($id);
        $kajian->delete();

        return redirect()->route('data-kajian-awal.index')->with('success', 'Data kajian awal berhasil dihapus.');
    }
}
