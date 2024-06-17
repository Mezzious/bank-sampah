<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Nasabah;
use App\Models\Purchase;
use App\Models\SuperAdmin;
use App\Models\Trash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class NasabahController extends Controller
{
    public function index()
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();

        // Pastikan pengguna telah login sebelum menampilkan data
        if ($user) {
            // Mendapatkan data Customer yang terkait dengan pengguna yang sedang login
            // $customer = Customer::where('user_id', $user->id)->first();
            $customer = $user->customer;

            $totalSampah = Purchase::where('user_id', $user->id)->sum('berat');
            $totalPenjualanSampah = Purchase::where('user_id', $user->id)->sum('total');

            // Mendapatkan nilai RW dari customer yang terkait
            // $rw = $customer ? $customer->RW : 'Default RW';

            // Mengirimkan data ke tampilan
            return view('nasabah/dashboard_nasabah', compact('customer', 'totalSampah', 'totalPenjualanSampah'));
        } else {
            // Jika pengguna belum login, bisa diarahkan ke halaman login atau tindakan lainnya
            return redirect()->route('login');
        }
    }

    public function transaksi_jual_nasabah()
    {
        // Ambil data pengguna yang sedang login
        $user = auth()->user();

        // Ambil transaksi pembelian terkait dengan pengguna yang login
        $purchases = Purchase::where('user_id', $user->id)->get();

        return view('nasabah/transaksi_jual_nasabah', compact('purchases', 'user'));
    }

    public function tambah_transaksi_jual_nasabah(){
        $trashes = Trash::all();
        return view('nasabah/tambah_transaksi_jual_nasabah', compact('trashes'));
    }

    public function store_transaksi_jual(Request $request){
            // Validasi input
            $request->validate([
                'tanggal_beli' => 'required|date',
                'jenis_sampah' => 'required|string',
                'berat' => 'required|numeric',
                'harga' => 'required|numeric',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'nota' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            // Membuat direktori baru untuk menyimpan nota jual
            $path = 'public/assets/nota_beli';
            Storage::makeDirectory($path);
    
            $path1 = 'public/assets/sampah_pembelian';
            Storage::makeDirectory($path1);
            
            // Proses upload gambar nota jual
            $notaBeliName = time() . '.' . $request->nota->extension();
            if (!$request->nota->isValid()) {
                return back()->withErrors(['nota' => 'File gambar tidak valid']);
            }
            $request->nota->storeAs($path, $notaBeliName);
    
            // Proses upload gambar nota jual
            $sampahBeli = time() . '.' . $request->gambar->extension();
            if (!$request->gambar->isValid()) {
                return back()->withErrors(['gambar' => 'File gambar tidak valid']);
            }
            $request->gambar->storeAs($path1, $sampahBeli);
    
            // Simpan data ke dalam database
            $purchase = new Purchase();
            $purchase->user_id = auth()->id();
            $purchase->tanggal_beli = $request->input('tanggal_beli');
            $purchase->jenis_sampah = $request->input('jenis_sampah');
            $purchase->berat = $request->input('berat');
            $purchase->harga = $request->input('harga');
            $purchase->total = $request->input('berat') * $request->input('harga');
            $purchase->gambar_nota = $notaBeliName;
            $purchase->gambar_sampah = $sampahBeli;
            $purchase->save();
    
            // Redirect ke halaman yang sesuai dengan pesan sukses atau lainnya
            return redirect()->route('transaksi_jual_nasabah')->with('success', 'Data penjualan berhasil disimpan.');
    }

    public function edit_transaksi_jual_nasabah(Request $request){
        $id = $request->input('id');
        $purchase = Purchase::findOrFail($id);

        if (!$purchase) {
            return back()->with('error', 'Data penjualan tidak ditemukan.');
        }

        $trashes = Trash::all();

        return view('nasabah/edit_transaksi_jual_nasabah', compact('purchase', 'trashes'));
    }

    public function update_transaksi_jual_nasabah(Request $request) 
    {
        $id = $request->input('id');
        $request->validate([
            'tanggal_beli' => 'required|date',
            'jenis_sampah' => 'required|string',
            'berat' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar_sampah' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar_sampah
            'gambar_nota' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar_nota
        ]);

        $purchase = Purchase::findOrFail($id);

        // Tangani file gambar_sampah
        if ($request->hasFile('gambar_sampah')) {
            Storage::delete('public/assets/sampah_pembelian/' . $purchase->gambar_sampah);

            $sampahBeli = time() . '.' . $request->gambar_sampah->extension();
            if (!$request->gambar_sampah->isValid()) {
                return back()->withErrors(['gambar_sampah' => 'File gambar tidak valid']);
            }
            $request->gambar_sampah->storeAs('public/assets/sampah_pembelian', $sampahBeli);
            $purchase->gambar_sampah = $sampahBeli;
        }

        // Tangani file gambar_nota
        if ($request->hasFile('gambar_nota')) {
            Storage::delete('public/assets/nota_beli/' . $purchase->gambar_nota);

            $notaBeliName = time() . '.' . $request->gambar_nota->extension();
            if (!$request->gambar_nota->isValid()) {
                return back()->withErrors(['gambar_nota' => 'File gambar tidak valid']);
            }
            $request->gambar_nota->storeAs('public/assets/nota_beli', $notaBeliName);
            $purchase->gambar_nota = $notaBeliName;
        }

        $purchase->tanggal_beli = $request->input('tanggal_beli');
        $purchase->jenis_sampah = $request->input('jenis_sampah');
        $purchase->berat = $request->input('berat');
        $purchase->harga = $request->input('harga');
        $purchase->total = $request->input('berat') * $request->input('harga');
        $purchase->save();

        return redirect()->route('transaksi_jual_nasabah')->with('success', 'Data Penjualan berhasil diperbarui.');
    }

    public function destroy_transaksi_jual_nasabah($id)
    {
        $purchase = Purchase::findOrFail($id);

        $path = 'public/assets/nota_beli/' . $purchase->gambar_nota;
        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $path1 = 'public/assets/sampah_pembelian/' . $purchase->gambar_sampah;
        if (Storage::exists($path1)) {
            Storage::delete($path1);
        }

        $purchase->delete();

        return redirect()->route('transaksi_jual_nasabah')->with('success', 'Data Penjualan berhasil dihapus.');
    }

    public function ganti_password_nasabah(){
        return view('nasabah/ganti_password_nasabah');
    }

    public function update_ganti_password_nasabah(Request $request){
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

    public function tampilkan_tanggal_transaksi_nasabah(Request $request)
    {
        // Validasi input
        $request->validate([
            'txtTglAwal' => 'required|date',
            'txtTglAkhir' => 'required|date|after_or_equal:txtTglAwal',
        ]);

        $tglAwal = $request->input('txtTglAwal');
        $tglAkhir = $request->input('txtTglAkhir');

        // Ambil data pengguna yang sedang login
        $user = auth()->user();

        // Ambil data transaksi pembelian sesuai dengan rentang tanggal
        $purchases = Purchase::where('user_id', $user->id)
            ->whereBetween('tanggal_beli', [$tglAwal, $tglAkhir])
            ->get();

        // Kembalikan view dengan data yang difilter
        return view('nasabah/transaksi_jual_nasabah', compact('purchases', 'user'));
    }

}
