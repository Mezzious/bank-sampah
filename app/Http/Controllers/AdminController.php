<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        return view("admin/dashboard_admin");
    }

    public function data_nasabah_admin()
    {
        return view('admin/data_nasabah_admin');
    }

    public function data_sampah_admin()
    {
        return view('admin/data_sampah_admin');
    }

    public function data_user_admin()
    {
        return view('admin/data_user_admin');
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

}
