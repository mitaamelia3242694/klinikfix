<?php

namespace App\Http\Controllers\AdminPendaftaran;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class RiwayatKunjunganController extends Controller
{
    public function index() {
        $riwayatKunjungan = Pendaftaran::with(['pasien', 'dokter', 'tindakan', 'asalPendaftaran', 'perawat', 'diagnosaAwal', 'diagnosaAkhir', 'resep.detail.obat'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('AdminPendaftaran.riwayat-kunjungan.index', compact('riwayatKunjungan'));
    }
}
