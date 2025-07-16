<?php

namespace App\Http\Controllers\AdminIT;

use App\Models\User;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataPegawaiController extends Controller
{
    public function index()
    {
        // Ambil data pegawai dengan relasi jabatan dan pagination 10 data per halaman
        $pegawai = Pegawai::with('jabatan')->paginate(10);

        // Tetap ambil semua jabatan dan user seperti sebelumnya
        $jabatans = Jabatan::all();
        $users = User::all();

        // Kirim data ke view
        return view('AdminIT.data-pegawai.index', compact('pegawai', 'jabatans', 'users'));
    }

    public function create()
    {
        $jabatan = Jabatan::all();
        $users = User::all();
        return view('AdminIT.data-pegawai.create', compact('jabatan', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:pegawai,nik',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'ttl' => 'required|date',
            'alamat' => 'required',
            'no_telp' => 'required',
            'jabatan_id' => 'required',
        ]);

        Pegawai::create($validated + $request->only([
            'nip',
            'gelar',
            'email',
            'str',
            'sip',
            'instansi_induk',
            'tanggal_berlaku',
            'user_id'
        ]));

        return redirect()->route('data-pegawai.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pegawai = Pegawai::with('jabatan', 'user')->findOrFail($id);
        return view('AdminIT.data-pegawai.show', compact('pegawai'));
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $jabatans = Jabatan::all();
        $users = User::all();
        return view('AdminIT.data-pegawai.edit', compact('pegawai', 'jabatans', 'users'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $validated = $request->validate([
            'nik' => 'required|unique:pegawai,nik,' . $pegawai->id,
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'ttl' => 'required|date',
            'alamat' => 'required',
            'no_telp' => 'required',
            'jabatan_id' => 'required',
        ]);

        $pegawai->update($validated + $request->only([
            'nip',
            'gelar',
            'email',
            'str',
            'sip',
            'instansi_induk',
            'tanggal_berlaku',
            'user_id'
        ]));

        return redirect()->route('data-pegawai.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('data-pegawai.index')->with('success', 'Data berhasil dihapus.');
    }
}
