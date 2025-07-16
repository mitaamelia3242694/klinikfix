<?php

namespace App\Http\Controllers\AdminIT;

use App\Models\User;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardITController extends Controller
{
    public function index()
    {
        $totalPegawai = Pegawai::count();
        $totalJabatan = Jabatan::count();
        $totalPengguna = User::count();
        return view('AdminIT.dashboard', compact('totalPegawai', 'totalJabatan', 'totalPengguna'));
    }
}
