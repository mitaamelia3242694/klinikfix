<?php

namespace App\Http\Controllers\Dokter;

use Carbon\Carbon;
use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardDokterController extends Controller
{
    public function index()
    {
        // Data per hari (hari ini)
        $pasienHarian = Pasien::whereDate('tanggal_daftar', Carbon::today())->count();

        // Data per bulan (bulan ini)
        $pasienBulanan = Pasien::whereMonth('tanggal_daftar', Carbon::now()->month)
            ->whereYear('tanggal_daftar', Carbon::now()->year)
            ->count();

        // Grafik: Total pasien per bulan di tahun ini
        $pasienPerBulan = Pasien::selectRaw('MONTH(tanggal_daftar) as bulan, COUNT(*) as jumlah')
            ->whereYear('tanggal_daftar', Carbon::now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('jumlah', 'bulan')
            ->toArray();

        // Pastikan semua bulan ada
        $dataChart = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataChart[] = $pasienPerBulan[$i] ?? 0;
        }

        return view('Dokter.dashboard-dokter', compact('pasienHarian', 'pasienBulanan', 'dataChart'));
    }
}