<?php

namespace App\Http\Controllers\AdminPendaftaran;

use Illuminate\Http\Request;
use App\Models\AsalPendaftaran;
use App\Http\Controllers\Controller;

class DataAsalPendaftaranController extends Controller
{
    public function index()
    {
        $asals = AsalPendaftaran::orderBy('nama')->paginate(10);
        return view('AdminPendaftaran.data-asal-pendaftaran.index', compact('asals'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255'
    ]);

    AsalPendaftaran::create([
        'nama' => $request->nama
    ]);

    return redirect()->back()->with('success', 'Asal pendaftaran berhasil ditambahkan.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255'
    ]);

    $asal = AsalPendaftaran::findOrFail($id);
    $asal->update([
        'nama' => $request->nama
    ]);

    return redirect()->back()->with('success', 'Asal pendaftaran berhasil diperbarui.');
}

public function destroy($id)
{
    $asal = AsalPendaftaran::findOrFail($id);
    $asal->delete();

    return redirect()->back()->with('success', 'Asal pendaftaran berhasil dihapus.');
}
}
