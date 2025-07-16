<?php

namespace App\Http\Controllers\Perawat;

use App\Models\Tindakan;
use App\Models\DiagnosaAwal;
use Illuminate\Http\Request;
use App\Models\PengkajianAwal;
use App\Http\Controllers\Controller;

class DashboardPerawatController extends Controller
{
    public function index()
    {
        $totalPengkajian = PengkajianAwal::count();
        $totalDiagnosa = DiagnosaAwal::count();
        $totalTindakan = Tindakan::count();

        return view('Perawat.dashboard-perawat', compact('totalPengkajian', 'totalDiagnosa', 'totalTindakan'));
    }
}
