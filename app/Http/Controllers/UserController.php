<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Sales;
use App\Models\SuperAdmin;
use App\Models\Trash;
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
            
            $totalSampah = Sales::where('user_id', $user->id)->sum('berat');
            $totalPenjualanSampah = Sales::where('user_id', $user->id)->sum('total');

            return view('user/dashboard_user', compact('user', 'totalSampah', 'totalPenjualanSampah'));
        } else {
            // Jika pengguna belum login, bisa diarahkan ke halaman login atau tindakan lainnya
            return redirect()->route('login');
        }
    }

    public function transaksi_beli_user()
    {
       // Ambil data pengguna yang sedang login
       $user = auth()->user();

       // Ambil transaksi pembelian terkait dengan pengguna yang login
       $saleses = Sales::where('user_id', $user->id)->get();
        return view('user/transaksi_beli_user', compact('saleses', 'user'));
    }

    public function tambah_transaksi_beli_user()
    {
        $trashes = Trash::all();
        return view('user/tambah_transaksi_beli_user', compact('trashes'));
    }

    public function store_transaksi_beli(Request $request)
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
        return redirect()->route('transaksi_beli_user')->with('success', 'Data pembelian berhasil disimpan.');
    }

    public function edit_transaksi_beli_user(Request $request)
    {
        $id = $request->input('id');
        $sales = Sales::findOrFail($id);

        if (!$sales) {
            return back()->with('error', 'Data penjualan tidak ditemukan.');
        }

        $trashes = Trash::all();

        return view('user/edit_transaksi_beli_user', compact('sales', 'trashes'));
    }

    public function update_transaksi_beli_user(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'tanggal_jual' => 'required|date',
            'jenis_sampah' => 'required|string',
            'berat' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar_sampah' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar_sampah
            'gambar_nota' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar_nota
        ]);

        $sales = Sales::findOrFail($id);

        // Tangani file gambar_sampah
        if ($request->hasFile('gambar_sampah')) {
            Storage::delete('public/assets/sampah_penjualan/' . $sales->gambar_sampah);

            $sampahJual = time() . '.' . $request->gambar_sampah->extension();
            if (!$request->gambar_sampah->isValid()) {
                return back()->withErrors(['gambar_sampah' => 'File gambar tidak valid']);
            }
            $request->gambar_sampah->storeAs('public/assets/sampah_penjualan', $sampahJual);
            $sales->gambar_sampah = $sampahJual;
        }

        // Tangani file gambar_nota
        if ($request->hasFile('gambar_nota')) {
            Storage::delete('public/assets/nota_jual/' . $sales->gambar_nota);

            $notaJualName = time() . '.' . $request->gambar_nota->extension();
            if (!$request->gambar_nota->isValid()) {
                return back()->withErrors(['gambar_nota' => 'File gambar tidak valid']);
            }
            $request->gambar_nota->storeAs('public/assets/nota_jual', $notaJualName);
            $sales->gambar_nota = $notaJualName;
        }

        $sales->tanggal_jual = $request->input('tanggal_jual');
        $sales->jenis_sampah = $request->input('jenis_sampah');
        $sales->berat = $request->input('berat');
        $sales->harga = $request->input('harga');
        $sales->total = $request->input('berat') * $request->input('harga');
        $sales->save();

        return redirect()->route('transaksi_beli_user')->with('success', 'Data pembelian berhasil diperbarui.');
    }


    public function destroy_transaksi_beli_user($id)
    {
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

        return redirect()->route('transaksi_beli_user')->with('success', 'Data pembelian berhasil dihapus.');
    }

    public function ganti_password_user()
    {
        return view('user/ganti_password_user');
    }

    public function update_password_user(Request $request)
    {
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

    public function tampilkan_tanggal_transaksi_user(Request $request)
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
        $saleses = Sales::where('user_id', $user->id)
            ->whereBetween('tanggal_jual', [$tglAwal, $tglAkhir])
            ->get();

        // Kembalikan view dengan data yang difilter
        return view('user/transaksi_beli_user', compact('saleses', 'user'));
    }
}
