<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardApotekerController extends Controller
{
    public function index()
    {
        return view('Apoteker.dashboard-apoteker');
    }
}
