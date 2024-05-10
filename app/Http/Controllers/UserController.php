<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index()
    {
    return view("user/dashboard_user");
    }

    public function transaksi_jual_user(){
        $saleses = Sales::all();
        return view('user/transaksi_jual_user', compact('saleses'));
    }

    public function tambah_transaksi_jual_user(){
        return view('user/tambah_transaksi_jual_user');
    }

    public function store_transaksi_jual(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_jual' => 'required|date',
            'jenis_sampah' => 'required|string',
            'berat' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Membuat direktori baru untuk menyimpan nota jual
        $path = 'public/assets/nota_jual';
        Storage::makeDirectory($path);

        // Proses upload gambar nota jual
        $notaJualName = time() . '.' . $request->gambar->extension();
        if (!$request->gambar->isValid()) {
            return back()->withErrors(['gambar' => 'File gambar tidak valid']);
        }
        $request->gambar->storeAs($path, $notaJualName);

        // Simpan data ke dalam database
        $sales = new Sales();
        $sales->user_id = auth()->id();
        $sales->tanggal_jual = $request->input('tanggal_jual');
        $sales->jenis_sampah = $request->input('jenis_sampah');
        $sales->berat = $request->input('berat');
        $sales->harga = $request->input('harga');
        $sales->total = $request->input('berat') * $request->input('harga');
        $sales->gambar = $notaJualName;
        $sales->save();

        // Redirect ke halaman yang sesuai dengan pesan sukses atau lainnya
        return redirect()->route('transaksi_jual_user')->with('success', 'Data penjualan berhasil disimpan.');
    }

    public function edit_transaksi_jual_user(){
        return view('user/edit_transaksi_jual_user');
    }

    public function ganti_password_user(){
        return view('user/ganti_password_user');
    }
}
