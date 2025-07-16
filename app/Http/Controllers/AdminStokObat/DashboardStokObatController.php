<?php

namespace App\Http\Controllers\AdminStokObat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardStokObatController extends Controller
{
    public function index()
    {
        return view('AdminStokObat.dashboard-stokobat');
    }
}
