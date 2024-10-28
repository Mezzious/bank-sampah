<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sales;
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
            // Mendapatkan total berat, penjualan, pembelian, dan jumlah nasabah
            $totalBerat = Purchase::sum('berat');
            $totalPenjualan = Sales::sum('total');
            $totalPembelian = Purchase::sum('total');
            $totalNasabah = Customer::count();

            // Mendapatkan data SuperAdmin yang terkait dengan pengguna yang sedang login
            $superAdmin = User::where('id', $user->id)->first();

            // Mendapatkan roles pengguna
            $roles = $superAdmin ? $superAdmin->roles : 'Default Role';

            // Mendapatkan data penjualan per bulan
            $sales = Sales::selectRaw('DATE_FORMAT(tanggal_jual, "%Y-%m") as month, SUM(berat) as total_berat, SUM(total) as total_harga')
                            ->groupBy('month')
                            ->orderBy('month')
                            ->get();

            // Mendapatkan data pembelian per bulan
            $purchases = Purchase::selectRaw('DATE_FORMAT(tanggal_beli, "%Y-%m") as month, SUM(berat) as total_berat, SUM(total) as total_harga')
                                ->groupBy('month')
                                ->orderBy('month')
                                ->get();

            // Menggabungkan bulan-bulan dari penjualan dan pembelian, diurutkan dan unik
            $months = $sales->pluck('month')->union($purchases->pluck('month'))->unique()->sort();

            // Mengambil total berat dan total harga penjualan per bulan
            $totalBeratPenjualanPerBulan = $sales->pluck('total_berat', 'month');
            $totalHargaPenjualanPerBulan = $sales->pluck('total_harga', 'month');

            // Mengambil total berat dan total harga pembelian per bulan
            $totalBeratPembelianPerBulan = $purchases->pluck('total_berat', 'month');
            $totalHargaPembelianPerBulan = $purchases->pluck('total_harga', 'month');

            // Mengirimkan data ke tampilan
            return view('admin/dashboard_admin', compact(
                'roles', 'totalBerat', 'totalPenjualan', 'totalPembelian', 'totalNasabah',
                'months', 'totalBeratPenjualanPerBulan', 'totalHargaPenjualanPerBulan',
                'totalBeratPembelianPerBulan', 'totalHargaPembelianPerBulan'
            ));
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
        $users = User::whereNotIn('roles', ['nasabah'])->get();
        return view('admin/data_user_admin', compact('users'));
    }


    public function transaksi_beli_admin(){
        $purchases = Purchase::all();
        return view('admin/transaksi_beli_admin', compact('purchases'));
    }

    public function transaksi_jual_admin(){
        $saleses = Sales::all();
        return view('admin/transaksi_jual_admin', compact('saleses'));
    }


    public function laporan_beli_admin(){
        $purchases = Purchase::all();
        return view('admin/laporan_beli_admin', compact('purchases'));
    }

    public function laporan_jual_admin(){
        $saleses = Sales::all();
        return view('admin/laporan_jual_admin', compact('saleses'));
    }

    public function ganti_password_admin(){
        return view('admin/ganti_password_admin');
    }
    
    public function update_ganti_password_admin(Request $request){
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
        ], [
            'password.regex' => 'Password harus mengandung setidaknya satu huruf, satu angka, dan satu karakter khusus (contoh: @$!%*?&).'
        ]);

        $user = User::find(Auth::id());

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
}
