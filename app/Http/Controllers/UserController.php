<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
    return view("user/dashboard_user");
    }

    public function transaksi_jual_user(){
        return view('user/transaksi_jual_user');
    }

    public function tambah_transaksi_jual_user(){
        return view('user/tambah_transaksi_jual_user');
    }

    public function edit_transaksi_jual_user(){
        return view('user/edit_transaksi_jual_user');
    }

    public function laporan_jual_user(){
        return view('user/laporan_jual_user');
    }
    public function ganti_password_user(){
        return view('user/ganti_password_user');
    }
}
