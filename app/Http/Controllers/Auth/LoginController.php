<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showlogin()
    {
        return view('Auth.login');
    }

    // Di LoginController
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);

            // Redirect berdasarkan role
            switch ($user->role->nama_role) {
                case 'Admin Pendaftaran':
                    return redirect()->route('dashboard.index');
                case 'Dokter':
                    return redirect()->route('dashboard-dokter.index');
                case 'Perawat':
                    return redirect()->route('dashboard-perawat.index');
                case 'Apoteker':
                    return redirect()->route('dashboard-apoteker.index');
                case 'Admin Stok Obat':
                    return redirect()->route('dashboard-stokobat.index');
                case 'Admin IT':
                    return redirect()->route('dashboard-it.index');
                default:
                    return redirect('/');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
