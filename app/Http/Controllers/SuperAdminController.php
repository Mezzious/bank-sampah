<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuperAdmin;
use App\Models\User;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view("superadmin/dashboard");
    }

    public function data_user()
    {
        $users = SuperAdmin::all();
        return view('superadmin/data_user', compact('users'));
    }

    public function tambah_user()
    {
        $roles = SuperAdmin::all();
        return view("superadmin/tambah_user", compact('roles'));
    }

    public function store_user(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'roles' => 'required|in:super-admin,admin,user', // Pastikan rolenya sesuai dengan yang diizinkan
        ]);

        // Simpan data ke dalam database
        $users = new SuperAdmin();
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->password = bcrypt($request->input('password')); // Encrypt password menggunakan bcrypt
        $users->roles = $request->input('roles');
        $users->save();

        return redirect()->route('data_user')->with('success', 'User berhasil ditambahkan');
    }

    public function edit_user(Request $request)
    {
        $id = $request->input('id');
        $user = SuperAdmin::find($id);
    
        if (!$user) {
            return back()->with('error', 'Pengguna tidak ditemukan.');
        }
    
        $roles = SuperAdmin::distinct('roles')->pluck('roles');
        return view("superadmin/edit_user", compact('user', 'roles'));
    }

    public function update_user(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|string|min:6',
        ]);

        $user = SuperAdmin::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->route('data_user', $id)->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request, $id)
    {   
        $user = SuperAdmin::findOrFail($id);
        $user->delete();

        return redirect()->route('data_user')->with('success', 'User deleted successfully');
    }

    public function ganti_password()
    {
        return view("superadmin/ganti_password");
    }

    public function data_nasabah()
    {
        return view('superadmin/data_nasabah');
    }

    public function tambah_nasabah()
    {
        return view("superadmin/tambah_nasabah");
    }

    public function edit_nasabah()
    {
        return view("superadmin/edit_nasabah");
    }

    public function data_sampah()
    {
        return view('superadmin/data_sampah');
    }

    public function tambah_sampah()
    {
        return view("superadmin/tambah_sampah");
    }

    public function edit_sampah()
    {
        return view("superadmin/edit_sampah");
    }

    public function transaksi_jual()
    {
        return view('superadmin/transaksi_jual');
    }

    public function tambah_transaksi_jual()
    {
        return view('superadmin/tambah_transaksi_jual');
    }

    public function edit_transaksi_jual()
    {
        return view('superadmin/edit_transaksi_jual');
    }

    public function transaksi_beli()
    {
        return view('superadmin/transaksi_beli');
    }

    public function tambah_transaksi_beli()
    {
        return view('superadmin/tambah_transaksi_beli');
    }

    public function edit_transaksi_beli()
    {
        return view('superadmin/edit_transaksi_beli');
    }

    public function laporan_jual()
    {
        return view('superadmin/laporan_jual');
    }

    public function laporan_beli()
    {
        return view('superadmin/laporan_beli');
    }

    public function cetak_laporan_jual()
    {
        return view('superadmin/cetak_laporan_jual');
    }
    public function cetak_laporan_beli()
    {
        return view('superadmin/cetak_laporan_beli');
    }
}
