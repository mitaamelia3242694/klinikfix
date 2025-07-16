<?php

namespace App\Http\Controllers\AdminPendaftaran;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Tindakan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Models\AsalPendaftaran;
use App\Http\Controllers\Controller;

class DataPendaftaranController extends Controller
{
    public function index()
    {
        $pendaftarans = Pendaftaran::with(['pasien', 'dokter', 'tindakan', 'asalPendaftaran', 'perawat'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $pasiens = Pasien::all();
        $dokters = User::where('role_id', '3')->get();
        $perawats = User::where('role_id', '4')->get();
        $tindakans = Tindakan::all();
        $asals = AsalPendaftaran::all();

        return view('AdminPendaftaran.data-pendaftaran.index', compact(
            'pendaftarans',
            'pasiens',
            'dokters',
            'perawats',
            'tindakans',
            'asals'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'jenis_kunjungan' => 'required|in:baru,lama',
            'dokter_id' => 'required|exists:users,id',
            'tindakan_id' => 'nullable|exists:tindakan,id',
            'asal_pendaftaran_id' => 'nullable|exists:asal_pendaftaran,id',
            'status' => 'nullable|string',
            'perawat_id' => 'nullable|exists:users,id',
            'keluhan' => 'nullable|string',
        ]);

        Pendaftaran::create($request->all());

        return redirect()->route('data-pendaftaran.index')->with('success', 'Pendaftaran berhasil disimpan.');
    }

    // Tampilkan form edit pendaftaran
    public function edit($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pasiens = Pasien::all();
        $dokters = User::where('role_id', '3')->get();
        $perawats = User::where('role_id', '4')->get();
        $tindakans = Tindakan::all();
        $asalPendaftarans = AsalPendaftaran::all();

        return view('AdminPendaftaran.data-pendaftaran.edit', compact(
            'pendaftaran',
            'pasiens',
            'dokters',
            'perawats',
            'tindakans',
            'asalPendaftarans'
        ));
    }

    // Update data pendaftaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'jenis_kunjungan' => 'required|in:baru,lama',
            'dokter_id' => 'required|exists:users,id',
            'tindakan_id' => 'nullable|exists:tindakan,id',
            'asal_pendaftaran_id' => 'nullable|exists:asal_pendaftaran,id',
            'status' => 'nullable|string',
            'perawat_id' => 'nullable|exists:users,id',
            'keluhan' => 'nullable|string',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update($request->all());

        return redirect()->route('data-pendaftaran.index')->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    // Tampilkan detail pendaftaran
    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['pasien', 'dokter', 'perawat', 'tindakan', 'asalPendaftaran'])
            ->findOrFail($id);

        return view('AdminPendaftaran.data-pendaftaran.detail', compact('pendaftaran'));
    }

    // Hapus data pendaftaran
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('data-pendaftaran.index')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
