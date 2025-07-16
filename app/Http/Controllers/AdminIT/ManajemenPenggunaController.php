<?php

namespace App\Http\Controllers\AdminIT;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ManajemenPenggunaController extends Controller
{
    public function index()
    {
        // Ambil user dengan relasi role, dan pagination 10 per halaman
        $users = User::with('role')->paginate(10);
        $roles = Role::all();

        return view('AdminIT.manajemen-pengguna.index', compact('users', 'roles'));
    }



    public function create()
    {
        $roles = Role::all();
        return view('AdminIT.manajemen-pengguna.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
            'nama_lengkap' => 'required',
            'email' => 'nullable|email',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return redirect()->route('manajemen-pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user = User::with('role')->findOrFail($id);
        return view('AdminIT.manajemen-pengguna.show', compact('user'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('AdminIT.manajemen-pengguna.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'password' => 'nullable|min:6',
            'role_id' => 'required|exists:roles,id',
            'nama_lengkap' => 'required',
            'email' => 'nullable|email',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->role_id = $request->role_id;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->save();

        return redirect()->route('manajemen-pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('manajemen-pengguna.index')->with('success', 'Pengguna dihapus.');
    }
}
