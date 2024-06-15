<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\SuperAdmin;
use App\Models\Trash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();

        // Pastikan pengguna telah login sebelum menampilkan data
        if ($user) {
            $totalBerat = Purchase::sum('berat');
            $totalPenjualan = Sales::sum('total');
            $totalPembelian = Purchase::sum('total');
            $totalNasabah = Customer::count();

            // Mendapatkan data SuperAdmin yang terkait dengan pengguna yang sedang login
            $superAdmin = User::where('id', $user->id)->first();

            // Mendapatkan roles pengguna
            $roles = $superAdmin ? $superAdmin->roles : 'Default Role';

            // Mengirimkan data ke tampilan
            return view('admin/dashboard_admin', compact('roles', 'totalBerat', 'totalPenjualan', 'totalPembelian', 'totalNasabah'));
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
        $saleses = Sales::all();
        return view('admin/transaksi_jual_admin', compact('saleses'));
    }

    public function transaksi_beli_admin(){
        $purchases = Purchase::all();
        return view('admin/transaksi_beli_admin', compact('purchases'));
    }


    public function laporan_jual_admin(){
        $saleses = Sales::all();
        return view('admin/laporan_jual_admin', compact('saleses'));
    }

    public function laporan_beli_admin(){
        $purchases = Purchase::all();
        return view('admin/laporan_beli_admin', compact('purchases'));
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

    public function tampilkan_tanggal_jual_admin(Request $request)
    {
        // Validasi input
        $request->validate([
            'txtTglAwal' => 'required|date',
            'txtTglAkhir' => 'required|date|after_or_equal:txtTglAwal',
        ]);

        $tglAwal = $request->input('txtTglAwal');
        $tglAkhir = $request->input('txtTglAkhir');

        // Ambil data dari database sesuai dengan rentang tanggal
        $saleses = Sales::whereBetween('tanggal_jual', [$tglAwal, $tglAkhir])->get();

        // Kembalikan view dengan data yang difilter
        return view('admin/transaksi_jual_admin', compact('saleses'));
    }

    public function tampilkan_tanggal_beli_admin(Request $request)
    {
        // Validasi input
        $request->validate([
            'txtTglAwal' => 'required|date',
            'txtTglAkhir' => 'required|date|after_or_equal:txtTglAwal',
        ]);

        $tglAwal = $request->input('txtTglAwal');
        $tglAkhir = $request->input('txtTglAkhir');

        // Ambil data dari database sesuai dengan rentang tanggal
        $purchases = Purchase::whereBetween('tanggal_beli', [$tglAwal, $tglAkhir])->get();

        // Kembalikan view dengan data yang difilter
        return view('admin/transaksi_beli_admin', compact('purchases'));
    }

    public function tampilkan_tanggal_jual_laporan_admin(Request $request)
    {
        // Validasi input
        $request->validate([
            'txtTglAwal' => 'required|date',
            'txtTglAkhir' => 'required|date|after_or_equal:txtTglAwal',
        ]);

        $tglAwal = $request->input('txtTglAwal');
        $tglAkhir = $request->input('txtTglAkhir');

        // Simpan tanggal di sesi jika diberikan
        if ($tglAwal && $tglAkhir) {
            session(['tglAwal' => $tglAwal, 'tglAkhir' => $tglAkhir]);
        } else {
            session()->forget(['tglAwal', 'tglAkhir']);
        }

        // Ambil data dari database sesuai dengan rentang tanggal jika ada, jika tidak ambil semua data
        if ($tglAwal && $tglAkhir) {
            $saleses = Sales::whereBetween('tanggal_jual', [$tglAwal, $tglAkhir])->get();
        } else {
            $saleses = Sales::all();
        }

        // Kembalikan view dengan data yang difilter
        return view('admin/laporan_jual_admin', compact('saleses'));
    }
    
    public function tampilkan_tanggal_beli_laporan_admin(Request $request)
    {
        // Validasi input
        $request->validate([
            'txtTglAwal' => 'required|date',
            'txtTglAkhir' => 'required|date|after_or_equal:txtTglAwal',
        ]);

        $tglAwal = $request->input('txtTglAwal');
        $tglAkhir = $request->input('txtTglAkhir');

        // Simpan tanggal di sesi jika diberikan
        if ($tglAwal && $tglAkhir) {
            session(['tglAwal' => $tglAwal, 'tglAkhir' => $tglAkhir]);
        } else {
            session()->forget(['tglAwal', 'tglAkhir']);
        }

        // Ambil data dari database sesuai dengan rentang tanggal jika ada, jika tidak ambil semua data
        if ($tglAwal && $tglAkhir) {
            $purchases = Purchase::whereBetween('tanggal_beli', [$tglAwal, $tglAkhir])->get();
        } else {
            $purchases = Purchase::all();
        }

        // Kembalikan view dengan data yang difilter
        return view('admin/laporan_beli_admin', compact('purchases'));
    }

    public function cetak_laporan_jual_admin(Request $request)
    {
        // Ambil tanggal dari sesi
        $tglAwal = session('tglAwal');
        $tglAkhir = session('tglAkhir');

        // Cek apakah tanggal awal dan akhir diberikan
        if ($tglAwal && $tglAkhir) {
            // Ambil data dari database sesuai dengan rentang tanggal
            $saleses = Sales::whereBetween('tanggal_jual', [$tglAwal, $tglAkhir])->get();
        } else {
            // Jika tanggal tidak diberikan, ambil semua data
            $saleses = Sales::all();
        }

        // Hapus sesi tanggal setelah data diambil
        session()->forget(['tglAwal', 'tglAkhir']);

        // Return view cetak laporan dengan data yang difilter
        return view('admin/cetak_laporan_jual_admin', compact('saleses', 'tglAwal', 'tglAkhir'));
    }
    
    public function cetak_laporan_beli_admin(Request $request)
    {
        // Ambil tanggal dari sesi
        $tglAwal = session('tglAwal');
        $tglAkhir = session('tglAkhir');

        // Cek apakah tanggal awal dan akhir diberikan
        if ($tglAwal && $tglAkhir) {
            // Ambil data dari database sesuai dengan rentang tanggal
            $purchases = Purchase::whereBetween('tanggal_beli', [$tglAwal, $tglAkhir])->get();
        } else {
            // Jika tanggal tidak diberikan, ambil semua data
            $purchases = Purchase::all();
        }

        // Hapus sesi tanggal setelah data diambil
        session()->forget(['tglAwal', 'tglAkhir']);

        // Return view cetak laporan dengan data yang difilter
        return view('admin/cetak_laporan_beli_admin', compact('purchases', 'tglAwal', 'tglAkhir'));
    }
}
