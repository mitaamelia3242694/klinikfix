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


    public function store(Request $request)
    {
        $request->validate([
            'tekanan_darah' => [
                'required',
                'regex:/^\d{2,3}\/\d{2,3}$/',
                function ($attribute, $value, $fail) {
                    list($sistolik, $diastolik) = explode('/', $value);

                    if ($sistolik < 80 || $sistolik > 200 || $diastolik < 50 || $diastolik > 130) {
                        $fail('Tekanan darah tidak masuk rentang normal (80–200 / 50–130).');
                    }

                    if ($sistolik <= $diastolik) {
                        $fail('Sistolik harus lebih tinggi dari diastolik.');
                    }
                },
            ],
            'suhu_tubuh' => 'required|numeric|between:34,42',
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
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'keluhan_utama' => 'required|string',
            'tekanan_darah' => 'required|string',
            'suhu_tubuh' => 'required|string',
            'status' => 'required|in:belum,sudah',
            'diagnosa_awal' => 'required|string', // ✅ tambahkan
            'pelayanan_id' => 'required|exists:pelayanan,id', // ✅ tambahkan
            'catatan' => 'nullable|string',
        ]);

        $kajian = PengkajianAwal::findOrFail($id);
        $kajian->update($request->all());

        return redirect()->route('data-kajian-awal.index')->with('success', 'Data kajian awal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kajian = PengkajianAwal::findOrFail($id);
        $kajian->delete();

        return redirect()->route('data-kajian-awal.index')->with('success', 'Data kajian awal berhasil dihapus.');
    }
}
