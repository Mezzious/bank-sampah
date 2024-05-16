<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\SuperAdmin;
use App\Models\Trash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();

        // Pastikan pengguna telah login sebelum menampilkan data
        if ($user) {
            // Mendapatkan data SuperAdmin yang terkait dengan pengguna yang sedang login
            $superAdmin = SuperAdmin::where('id', $user->id)->first();

            // Mendapatkan roles pengguna
            $roles = $superAdmin ? $superAdmin->roles : 'Default Role';

            // Mengirimkan data ke tampilan
            return view('admin/dashboard_admin', compact('roles'));
        } else {
            // Jika pengguna belum login, bisa diarahkan ke halaman login atau tindakan lainnya
            return redirect()->route('login');
        }
    }

    public function data_nasabah_admin()
    {
        $cust = Customer::with('user')->get();
        return view('admin/data_nasabah_admin', compact('cust'));
    }

    public function data_sampah_admin()
    {
        $trashes = Trash::all();
        return view('admin/data_sampah_admin', compact('trashes'));
    }

    public function data_user_admin()
    {
        $users = SuperAdmin::whereNotIn('roles', ['nasabah'])->get();
        return view('admin/data_user_admin', compact('users'));
    }


    public function transaksi_jual_admin(){
        return view('admin/transaksi_jual_admin');
    }

    public function transaksi_beli_admin(){
        return view('admin/transaksi_beli_admin');
    }


    public function laporan_jual_admin(){
        return view('admin/laporan_jual_admin');
    }

    public function laporan_beli_admin(){
        return view('admin/laporan_beli_admin');
    }

    public function ganti_password_admin(){
        return view('admin/ganti_password_admin');
    }
    
    public function update_ganti_password_admin(Request $request){
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = SuperAdmin::find(Auth::id());

        //cek password lama
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with('status', 'Password anda saat ini tidak sesuai');
        }

        //cek password baru dan konfirmasi password
        if ($request->password != $request->password_confirmation) {
            return back()->with('status', 'Password baru dan Konfirmasi Password Baru tidak sesuai');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }

}
