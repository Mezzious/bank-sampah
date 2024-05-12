<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Nasabah;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NasabahController extends Controller
{
    public function index()
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();

        // Pastikan pengguna telah login sebelum menampilkan data
        if ($user) {
            // Mendapatkan data Customer yang terkait dengan pengguna yang sedang login
            $customer = Customer::where('user_id', $user->id)->first();

            // Mendapatkan nilai RW dari customer yang terkait
            $rw = $customer ? $customer->RW : 'Default RW';

            // Mengirimkan data ke tampilan
            return view('nasabah/dashboard_nasabah', compact('customer'));
        } else {
            // Jika pengguna belum login, bisa diarahkan ke halaman login atau tindakan lainnya
            return redirect()->route('login');
        }
    }

    public function transaksi_beli_nasabah(){
        return view('nasabah/transaksi_beli_nasabah');
        }

    public function tambah_transaksi_beli_nasabah(){
        return view('nasabah/tambah_transaksi_beli_nasabah');
        }

    public function edit_transaksi_beli_nasabah(){
        return view('nasabah/edit_transaksi_beli_nasabah');
        }

    public function ganti_password_nasabah(){
        return view('nasabah/ganti_password_nasabah');
            }
}
