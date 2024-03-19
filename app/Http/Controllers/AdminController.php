<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Child;

class AdminController extends Controller
{
    public function index()
    {
        return view("admin/dashboard");
    }

    public function data_nasabah()
    {
        return view('admin/data_nasabah');
    }

    public function tambah_nasabah()
    {
        return view("admin/tambah_nasabah");
    }

    public function edit_nasabah()
    {
        return view("admin/edit_nasabah");
    }

    public function hapus_nasabah()
    {
        return view("admin/hapus_nasabah");
    }

    public function data_sampah()
    {
        return view('admin/data_sampah');
    }

    public function tambah_sampah()
    {
        return view("admin/tambah_sampah");
    }

    public function edit_sampah()
    {
        return view("admin/edit_sampah");
    }

    public function hapus_sampah()
    {
        return view("admin/hapus_sampah");
    }

    // public function daftar_sampah(){
    //     return view('admin/daftar_sampah', [
    //         "sampah" => Sampah::all()
    //     ]);
    // }

    public function cari_sampah(){
        return view('admin/cari_sampah');
    }

    public function transaksi_jual(){
        return view('admin/transaksi_jual');
    }

    public function tambah_transaksi_jual(){
        return view('admin/tambah_transaksi_jual');
    }

    public function edit_transaksi_jual(){
        return view('admin/edit_transaksi_jual');
    }

    public function hapus_transaksi_jual(){
        return view('admin/hapus_transaksi_jual');
    }

    public function transaksi_beli(){
        return view('admin/transaksi_beli');
    }

    public function tambah_transaksi_beli(){
        return view('admin/tambah_transaksi_beli');
    }

    public function edit_transaksi_beli(){
        return view('admin/edit_transaksi_beli');
    }

    public function hapus_transaksi_beli(){
        return view('admin/hapus_transaksi_beli');
    }

    public function laporan_jual(){
        return view('admin/laporan_jual');
    }

    public function laporan_beli(){
        return view('admin/laporan_beli');
    }

    public function laporan_akhir(){
        return view('admin/laporan_akhir');
    }

}
