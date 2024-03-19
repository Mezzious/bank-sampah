<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view("user/dashboard");
    }

    public function data_nasabah_user()
    {
        return view('user/data_nasabah_user');
    }

    public function data_sampah_user()
    {
        return view('user/data_sampah_user');
    }


    public function transaksi_jual_user(){
        return view('user/transaksi_jual_user');
    }

    public function transaksi_beli_user(){
        return view('user/transaksi_beli_user');
    }


    public function laporan_jual_user(){
        return view('user/laporan_jual_user');
    }

    public function laporan_beli_user(){
        return view('user/laporan_beli_user');
    }

    public function ganti_password_user(){
        return view('user/ganti_password_user');
    }
