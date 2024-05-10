<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Nasabah;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    public function index()
    {
        $cust = Customer::all();
        return view('nasabah/dashboard_nasabah', compact('cust'));
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
