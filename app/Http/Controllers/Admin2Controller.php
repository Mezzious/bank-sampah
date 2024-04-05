<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin2;

class Admin2Controller extends Controller
{

    public function index()
    {
    return view("admin2/dashboard_admin2");
    }

    public function transaksi_jual_admin2(){
        return view('admin2/transaksi_jual_admin2');
    }

    public function tambah_transaksi_jual_admin2(){
        return view('admin2/tambah_transaksi_jual_admin2');
    }

    public function edit_transaksi_jual_admin2(){
        return view('admin2/edit_transaksi_jual_admin2');
    }

    public function laporan_jual_admin2(){
        return view('admin2/laporan_jual_admin2');
    }
    public function ganti_password_admin2(){
        return view('admin2/ganti_password_admin2');
    }
}
