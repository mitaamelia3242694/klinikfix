<?php

namespace App\Http\Controllers\AdminPendaftaran;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Asuransi;
use App\Models\Pelayanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
   public function index(Request $request)
{
    // Statistik Umum
    $jumlahPasien = Pasien::count();
    $jumlahPelayanan = Pelayanan::count();
    $jumlahAsuransi = Asuransi::count();

    // Tahun dipilih (default: tahun sekarang)
    $tahun = $request->input('tahun', now()->year);

    // Jumlah pendaftar hari ini
    $pendaftarHariIni = Pasien::whereDate('created_at', Carbon::today())->count();

    // Query pendaftaran bulanan berdasarkan tahun
    $pendaftaranBulanan = Pasien::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
        ->whereYear('created_at', $tahun)
        ->groupByRaw('MONTH(created_at)')
        ->pluck('jumlah', 'bulan');

    // Siapkan data lengkap Jan–Des
    $dataBulanan = [];
    for ($i = 1; $i <= 12; $i++) {
        $dataBulanan[] = $pendaftaranBulanan->get($i, 0);
    }

    return view('AdminPendaftaran.dashboard', compact(
        'jumlahPasien',
        'jumlahPelayanan',
        'jumlahAsuransi',
        'pendaftarHariIni',
        'dataBulanan',
        'tahun'
    ));
}

}
