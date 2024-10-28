<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Trash;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            // Mendapatkan data Customer yang terkait dengan pengguna yang sedang login
            $customer = $user->customer;

            $totalSampah = Purchase::where('user_id', $user->id)->sum('berat');
            $totalPembelianSampah = Purchase::where('user_id', $user->id)->sum('total');

            // Mengelompokkan data sampah per jenis dan menghitung berat untuk setiap jenis
            $sampahPerJenis = Purchase::where('user_id', $user->id)
                ->select('jenis_sampah', DB::raw('SUM(berat) as total_berat'))
                ->groupBy('jenis_sampah')
                ->get();

            // Menyiapkan data untuk Chart.js
            $jenisSampah = $sampahPerJenis->pluck('jenis_sampah'); // Nama jenis sampah
            $beratSampah = $sampahPerJenis->pluck('total_berat'); // Berat per jenis sampah

            return view('user/dashboard_user', compact('user', 'customer', 'totalSampah', 'totalPembelianSampah', 'jenisSampah', 'beratSampah'));
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
        $purchases = Purchase::where('user_id', $user->id)->get();
        return view('user/transaksi_beli_user', compact('purchases', 'user'));
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
            'tanggal_beli' => 'required|date',
            'jenis_sampah' => 'required|string',
            'berat' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanda_tangan' => 'required',
        ]);

        // Membuat direktori baru untuk menyimpan nota jual
        $path1 = 'public/assets/sampah_pembelian';
        Storage::makeDirectory($path1);

        // Proses upload gambar nota jual
        $sampahBeli = time() . '.' . $request->gambar->extension();
        if (!$request->gambar->isValid()) {
            return back()->withErrors(['gambar' => 'File gambar tidak valid']);
        }
        $request->gambar->storeAs($path1, $sampahBeli);

        // Proses tanda tangan
        $path2 = 'public/assets/tanda_tangan_beli';
        Storage::makeDirectory($path2); // Membuat folder jika belum ada

        $signatureData = $request->input('tanda_tangan');
        $signature = str_replace('data:image/png;base64,', '', $signatureData);
        $signature = str_replace(' ', '+', $signature);
        $signatureName = time() . '_signature.png';
        Storage::put($path2 . '/' . $signatureName, base64_decode($signature));

        // Simpan data ke dalam database
        $purchases = new Purchase();
        $purchases->user_id = auth()->id();
        $purchases->tanggal_beli = $request->input('tanggal_beli');
        $purchases->jenis_sampah = $request->input('jenis_sampah');
        $purchases->berat = $request->input('berat');
        $purchases->harga = $request->input('harga');
        $purchases->total = $request->input('berat') * $request->input('harga');
        $purchases->gambar_ttd = $signatureName;
        $purchases->gambar_sampah = $sampahBeli;
        $purchases->save();

        // Redirect ke halaman yang sesuai dengan pesan sukses atau lainnya
        return redirect()->route('transaksi_beli_user')->with('success', 'Data pembelian berhasil disimpan.');
    }

    public function edit_transaksi_beli_user(Request $request)
    {
        $id = $request->input('id');
        $purchases = Purchase::findOrFail($id);

        if (!$purchases) {
            return back()->with('error', 'Data penjualan tidak ditemukan.');
        }

        $trashes = Trash::all();

        return view('user/edit_transaksi_beli_user', compact('purchases', 'trashes'));
    }

    public function update_transaksi_beli_user(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'tanggal_beli' => 'required|date',
            'jenis_sampah' => 'required|string',
            'berat' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar_sampah' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar_sampah
        ]);

        $pruchases = Purchase::findOrFail($id);

        // Tangani file gambar_sampah
        if ($request->hasFile('gambar_sampah')) {
            Storage::delete('public/assets/sampah_pembelian/' . $pruchases->gambar_sampah);

            $sampahJual = time() . '.' . $request->gambar_sampah->extension();
            if (!$request->gambar_sampah->isValid()) {
                return back()->withErrors(['gambar_sampah' => 'File gambar tidak valid']);
            }
            $request->gambar_sampah->storeAs('public/assets/sampah_pembelian', $sampahJual);
            $pruchases->gambar_sampah = $sampahJual;
        }

        $pruchases->tanggal_beli = $request->input('tanggal_beli');
        $pruchases->jenis_sampah = $request->input('jenis_sampah');
        $pruchases->berat = $request->input('berat');
        $pruchases->harga = $request->input('harga');
        $pruchases->total = $request->input('berat') * $request->input('harga');
        $pruchases->save();

        return redirect()->route('transaksi_beli_user')->with('success', 'Data pembelian berhasil diperbarui.');
    }


    public function destroy_transaksi_beli_user($id)
    {
        $purchases = Purchase::findOrFail($id);

        $path1 = 'public/assets/sampah_pembelian/' . $purchases->gambar_sampah;
        if (Storage::exists($path1)) {
            Storage::delete($path1);
        }

        $path2 = 'public/assets/tanda_tangan_beli/' . $purchases->gambar_ttd;
        if (Storage::exists($path2)) {
            Storage::delete($path2);
        }

        $purchases->delete();

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
            'password' => 'required|confirmed|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
        ], [
            'password.regex' => 'Password harus mengandung setidaknya satu huruf, satu angka, dan satu karakter khusus (contoh: @$!%*?&).'
        ]);

        $user = User::find(Auth::id());

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
        $purchases = Purchase::where('user_id', $user->id)
            ->whereBetween('tanggal_beli', [$tglAwal, $tglAkhir])
            ->get();

        // Kembalikan view dengan data yang difilter
        return view('user/transaksi_beli_user', compact('purchases', 'user'));
    }

    public function laporan_beli_user()
    {
        // Ambil data pengguna yang sedang login
        $user = auth()->user();

        // Ambil transaksi pembelian terkait dengan pengguna yang login
        $purchases = Purchase::where('user_id', $user->id)->get();
        return view('user/laporan_beli_user', compact('purchases', 'user'));
    }

    public function tampilkan_tanggal_laporan_beli_user(Request $request)
    {
        // Validasi input
        $request->validate([
            'txtTglAwal' => 'required|date',
            'txtTglAkhir' => 'required|date|after_or_equal:txtTglAwal',
        ]);

        $tglAwal = $request->input('txtTglAwal');
        $tglAkhir = $request->input('txtTglAkhir');

        // Ambil user yang sedang login
        $user = auth()->user();

        // Simpan tanggal di sesi jika diberikan
        if ($tglAwal && $tglAkhir) {
            session(['tglAwal' => $tglAwal, 'tglAkhir' => $tglAkhir]);
        } else {
            session()->forget(['tglAwal', 'tglAkhir']);
        }

        // Ambil data dari database sesuai dengan rentang tanggal jika ada, jika tidak ambil semua data
        if ($tglAwal && $tglAkhir) {
            $purchases = Purchase::where('user_id', $user->id)
                ->whereBetween('tanggal_beli', [$tglAwal, $tglAkhir])
                ->get();
        } else {
            $purchases = Purchase::all();
        }

        // Kembalikan view dengan data yang difilter
        return view('user/laporan_beli_user', compact('purchases'));
    }

    public function cetak_laporan_beli_user(Request $request)
    {
        // Ambil tanggal dari sesi
        $tglAwal = session('tglAwal');
        $tglAkhir = session('tglAkhir');

        // Ambil user yang sedang login
        $user = auth()->user();

        // Cek apakah tanggal awal dan akhir diberikan
        if ($tglAwal && $tglAkhir) {
            // Ambil data dari database sesuai dengan rentang tanggal
            $purchases = Purchase::where('user_id', $user->id)
                ->whereBetween('tanggal_beli', [$tglAwal, $tglAkhir])
                ->get();
        } else {
            // Jika tanggal tidak diberikan, ambil semua data
            $purchases = Purchase::all();
        }

        // Hapus sesi tanggal setelah data diambil
        session()->forget(['tglAwal', 'tglAkhir']);

        // Return view cetak laporan dengan data yang difilter
        return view('user/cetak_laporan_beli_user', compact('purchases', 'tglAwal', 'tglAkhir'));
    }
}
