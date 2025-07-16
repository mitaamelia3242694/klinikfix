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
        $jumlahPasien = Pasien::count();
        $jumlahPelayanan = Pelayanan::count();
        $jumlahAsuransi = Asuransi::count();
        $pendaftarHariIni = Pasien::whereDate('created_at', Carbon::today())->count();

        // Filter Hari
        $tanggal = $request->input('tanggal');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', now()->year); // Default: tahun sekarang

        if ($tanggal) {
            $pendaftarHariIni = Pasien::whereDate('created_at', $tanggal)->count();
        } else {
            $pendaftarHariIni = Pasien::whereDate('created_at', Carbon::today())->count();
        }

        $query = Pasien::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah');

        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        $pendaftaranBulanan = $query->groupByRaw('MONTH(created_at)')->pluck('jumlah', 'bulan');

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
            'dataBulanan'
        ));
    }
}
