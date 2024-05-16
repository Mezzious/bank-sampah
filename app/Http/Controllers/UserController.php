<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index()
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();

        // Pastikan pengguna telah login sebelum menampilkan data
        if ($user) {
            return view('user/dashboard_user', compact('user'));
        } else {
            // Jika pengguna belum login, bisa diarahkan ke halaman login atau tindakan lainnya
            return redirect()->route('login');
        }
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
            'nota' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Membuat direktori baru untuk menyimpan nota jual
        $path = 'public/assets/nota_jual';
        Storage::makeDirectory($path);

        $path1 = 'public/assets/sampah_penjualan';
        Storage::makeDirectory($path1);
        
        // Proses upload gambar nota jual
        $notaJualName = time() . '.' . $request->nota->extension();
        if (!$request->nota->isValid()) {
            return back()->withErrors(['gambar' => 'File gambar tidak valid']);
        }
        $request->nota->storeAs($path, $notaJualName);

        // Proses upload gambar nota jual
        $sampahJual = time() . '.' . $request->gambar->extension();
        if (!$request->gambar->isValid()) {
            return back()->withErrors(['gambar' => 'File gambar tidak valid']);
        }
        $request->gambar->storeAs($path1, $sampahJual);

        // Simpan data ke dalam database
        $sales = new Sales();
        $sales->user_id = auth()->id();
        $sales->tanggal_jual = $request->input('tanggal_jual');
        $sales->jenis_sampah = $request->input('jenis_sampah');
        $sales->berat = $request->input('berat');
        $sales->harga = $request->input('harga');
        $sales->total = $request->input('berat') * $request->input('harga');
        $sales->gambar_nota = $notaJualName;
        $sales->gambar_sampah = $sampahJual;
        $sales->save();

        // Redirect ke halaman yang sesuai dengan pesan sukses atau lainnya
        return redirect()->route('transaksi_jual_user')->with('success', 'Data penjualan berhasil disimpan.');
    }

    public function edit_transaksi_jual_user(Request $request){
        $id = $request->input('id');
        $sales = Sales::findOrFail($id);

        if (!$sales) {
            return back()->with('error', 'Data penjualan tidak ditemukan.');
        }

        return view('user/edit_transaksi_jual_user', compact('sales'));
    }
    
    public function update_transaksi_jual_user(Request $request){
        $id = $request->input('id');
        $request->validate([
            'tanggal_jual' => 'required|date',
            'jenis_sampah' => 'required|string',
            'berat' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        $sales = Sales::findOrFail($id);

        $sales->tanggal_jual = $request->input('tanggal_jual');
        $sales->jenis_sampah = $request->input('jenis_sampah');
        $sales->berat = $request->input('berat');
        $sales->harga = $request->input('harga');
        $sales->total = $request->input('berat') * $request->input('harga');
        $sales->save();

        return redirect()->route('transaksi_jual_user')->with('success', 'Data penjualan berhasil diperbarui.');
    }
    
    public function destroy_transaksi_jual_user($id){
        $sales = Sales::findOrFail($id);

        $path = 'public/assets/nota_jual/' . $sales->gambar_nota;
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
        
        $path1 = 'public/assets/sampah_penjualan/' . $sales->gambar_sampah;
        if (Storage::exists($path1)) {
            Storage::delete($path1);
        }

        $sales->delete();

        return redirect()->route('transaksi_jual_user')->with('success', 'Data penjualan berhasil dihapus.');
    }

    public function ganti_password_user(){
        return view('user/ganti_password_user');
    }
    
    public function update_password_user(Request $request){
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = SuperAdmin::find(Auth::id());

        //cek password lama
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with('status', 'Password anda saat ini tidak sesuai');
        }

        //cek password baru dan konfirmasi password
        if ($request->password != $request->password_confirmation) {
            return back()->with('status', 'Password baru dan Konfirmasi Password Baru tidak sesuai');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }
}
