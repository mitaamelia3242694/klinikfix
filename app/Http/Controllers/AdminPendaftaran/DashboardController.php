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

        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan'); // bisa null

        $pendaftarHariIni = Pasien::whereDate('created_at', Carbon::today())->count();

        // Ambil pendaftaran berdasarkan filter tahun & bulan
        $query = Pasien::query()->whereYear('created_at', $tahun);

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        $pendaftaranBulanan = $query
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->groupByRaw('MONTH(created_at)')
            ->pluck('jumlah', 'bulan');

        // Data bulanan (isi sesuai bulan yg dipilih, atau jan-des)
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
            'tahun',
            'bulan'
        ));
    }
}
