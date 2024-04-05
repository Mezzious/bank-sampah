<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuperAdmin;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view("superadmin/dashboard");
    }

    public function data_user()
    {
        return view('superadmin/data_user');
    }

    public function tambah_user()
    {
        return view("superadmin/tambah_user");
    }

    public function edit_user()
    {
        return view("superadmin/edit_user");
    }

    public function ganti_password()
    {
        return view("superadmin/ganti_password");
    }

    public function data_nasabah()
    {
        return view('superadmin/data_nasabah');
    }

    public function tambah_nasabah()
    {
        return view("superadmin/tambah_nasabah");
    }

    public function edit_nasabah()
    {
        return view("superadmin/edit_nasabah");
    }

    public function data_sampah()
    {
        return view('superadmin/data_sampah');
    }

    public function tambah_sampah()
    {
        return view("superadmin/tambah_sampah");
    }

    public function edit_sampah()
    {
        return view("superadmin/edit_sampah");
    }

    public function transaksi_jual(){
        return view('superadmin/transaksi_jual');
    }

    public function tambah_transaksi_jual(){
        return view('superadmin/tambah_transaksi_jual');
    }

    public function edit_transaksi_jual(){
        return view('superadmin/edit_transaksi_jual');
    }

    public function transaksi_beli(){
        return view('superadmin/transaksi_beli');
    }

    public function tambah_transaksi_beli(){
        return view('superadmin/tambah_transaksi_beli');
    }

    public function edit_transaksi_beli(){
        return view('superadmin/edit_transaksi_beli');
    }

    public function laporan_jual(){
        return view('superadmin/laporan_jual');
    }

    public function laporan_beli(){
        return view('superadmin/laporan_beli');
    }

    public function cetak_laporan_jual(){
        return view('superadmin/cetak_laporan_jual');
    }
    public function cetak_laporan_beli(){
        return view('superadmin/cetak_laporan_beli');
    }

}
