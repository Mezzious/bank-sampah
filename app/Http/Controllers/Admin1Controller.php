<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin1;

class Admin1Controller extends Controller
{
    public function index()
    {
        return view("admin1/dashboard_admin1");
    }
    public function transaksi_beli_admin1(){
        return view('admin1/transaksi_beli_admin1');
        }

    public function tambah_transaksi_beli_admin1(){
        return view('admin1/tambah_transaksi_beli_admin1');
        }

    public function edit_transaksi_beli_admin1(){
        return view('admin1/edit_transaksi_beli_admin1');
        }
    public function laporan_beli_admin1(){
        return view('admin1/laporan_beli_admin1');
        }
    public function ganti_password_admin1(){
        return view('admin1/ganti_password_admin1');
            }


}


