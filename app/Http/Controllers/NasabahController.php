<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Trash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $customer = $user->customer;

            // Mendapatkan total berat dan total penjualan berdasarkan pengguna login
            $totalSampah = Sales::where('user_id', $user->id)->sum('berat');
            $totalPenjualanSampah = Sales::where('user_id', $user->id)->sum('total');

            // Mengelompokkan data sampah per jenis dan menghitung berat untuk setiap jenis
            $sampahPerJenis = Sales::where('user_id', $user->id)
                ->select('jenis_sampah', DB::raw('SUM(berat) as total_berat'))
                ->groupBy('jenis_sampah')
                ->get();

            // Menyiapkan data untuk Chart.js
            $jenisSampah = $sampahPerJenis->pluck('jenis_sampah'); // Nama jenis sampah
            $beratSampah = $sampahPerJenis->pluck('total_berat'); // Berat per jenis sampah

            // Mengirimkan data ke tampilan
            return view('nasabah/dashboard_nasabah', compact('customer', 'totalSampah', 'totalPenjualanSampah', 'jenisSampah', 'beratSampah'));
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
        $saleses = Sales::where('user_id', $user->id)->get();

        return view('nasabah/transaksi_jual_nasabah', compact('saleses', 'user'));
    }

    public function tambah_transaksi_jual_nasabah()
    {
        $trashes = Trash::all();
        return view('nasabah/tambah_transaksi_jual_nasabah', compact('trashes'));
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
            'tanda_tangan' => 'required',
        ]);

        $path1 = 'public/assets/sampah_penjualan';
        Storage::makeDirectory($path1);

        // Proses upload gambar nota jual
        $sampahBeli = time() . '.' . $request->gambar->extension();
        if (!$request->gambar->isValid()) {
            return back()->withErrors(['gambar' => 'File gambar tidak valid']);
        }
        $request->gambar->storeAs($path1, $sampahBeli);

        // Proses tanda tangan
        $path2 = 'public/assets/tanda_tangan_jual';
        Storage::makeDirectory($path2); // Membuat folder jika belum ada

        $signatureData = $request->input('tanda_tangan');
        $signature = str_replace('data:image/png;base64,', '', $signatureData);
        $signature = str_replace(' ', '+', $signature);
        $signatureName = time() . '_signature.png';
        Storage::put($path2 . '/' . $signatureName, base64_decode($signature));

        // Simpan data ke dalam database
        $saleses = new Sales();
        $saleses->user_id = auth()->id();
        $saleses->tanggal_jual = $request->input('tanggal_jual');
        $saleses->jenis_sampah = $request->input('jenis_sampah');
        $saleses->berat = $request->input('berat');
        $saleses->harga = $request->input('harga');
        $saleses->total = $request->input('berat') * $request->input('harga');
        $saleses->gambar_ttd = $signatureName;
        $saleses->gambar_sampah = $sampahBeli;
        $saleses->save();
        $saleses->user_id = auth()->id();

        // Redirect ke halaman yang sesuai dengan pesan sukses atau lainnya
        return redirect()->route('transaksi_jual_nasabah')->with('success', 'Data penjualan berhasil disimpan.');
    }

    public function edit_transaksi_jual_nasabah(Request $request)
    {
        $id = $request->input('id');
        $saleses = Sales::findOrFail($id);

        if (!$saleses) {
            return back()->with('error', 'Data penjualan tidak ditemukan.');
        }

        $trashes = Trash::all();

        return view('nasabah/edit_transaksi_jual_nasabah', compact('saleses', 'trashes'));
    }

    public function update_transaksi_jual_nasabah(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'tanggal_jual' => 'required|date',
            'jenis_sampah' => 'required|string',
            'berat' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar_sampah' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar_sampah
        ]);

        $saleses = Sales::findOrFail($id);

        // Tangani file gambar_sampah
        if ($request->hasFile('gambar_sampah')) {
            Storage::delete('public/assets/sampah_penjualan/' . $saleses->gambar_sampah);

            $sampahBeli = time() . '.' . $request->gambar_sampah->extension();
            if (!$request->gambar_sampah->isValid()) {
                return back()->withErrors(['gambar_sampah' => 'File gambar tidak valid']);
            }
            $request->gambar_sampah->storeAs('public/assets/sampah_penjualan', $sampahBeli);
            $saleses->gambar_sampah = $sampahBeli;
        }

        $saleses->tanggal_jual = $request->input('tanggal_jual');
        $saleses->jenis_sampah = $request->input('jenis_sampah');
        $saleses->berat = $request->input('berat');
        $saleses->harga = $request->input('harga');
        $saleses->total = $request->input('berat') * $request->input('harga');
        $saleses->save();

        return redirect()->route('transaksi_jual_nasabah')->with('success', 'Data Penjualan berhasil diperbarui.');
    }

    public function destroy_transaksi_jual_nasabah($id)
    {
        $saleses = Sales::findOrFail($id);

        $path1 = 'public/assets/sampah_penjualan/' . $saleses->gambar_sampah;
        if (Storage::exists($path1)) {
            Storage::delete($path1);
        }

        $path2 = 'public/assets/tanda_tangan_jual/' . $saleses->gambar_ttd;
        if (Storage::exists($path2)) {
            Storage::delete($path2);
        }

        $saleses->delete();

        return redirect()->route('transaksi_jual_nasabah')->with('success', 'Data Penjualan berhasil dihapus.');
    }

    public function ganti_password_nasabah()
    {
        return view('nasabah/ganti_password_nasabah');
    }

    public function update_ganti_password_nasabah(Request $request)
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

        // Check if the new password is the same as the current password
        if ($request->current_password === $request->password) {
            return back()->with('status', 'Password baru tidak boleh sama dengan password saat ini');
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
        $saleses = Sales::where('user_id', $user->id)
            ->whereBetween('tanggal_jual', [$tglAwal, $tglAkhir])
            ->get();

        // Kembalikan view dengan data yang difilter
        return view('nasabah/transaksi_jual_nasabah', compact('saleses', 'user'));
    }

    public function laporan_jual_nasabah()
    {
        // Ambil data pengguna yang sedang login
        $user = auth()->user();

        // Ambil transaksi pembelian terkait dengan pengguna yang login
        $saleses = Sales::where('user_id', $user->id)->get();

        return view('nasabah/laporan_jual_nasabah', compact('saleses', 'user'));
    }

    public function cetak_laporan_jual_nasabah(Request $request)
    {
        // Ambil tanggal dari sesi
        $tglAwal = session('tglAwal');
        $tglAkhir = session('tglAkhir');

        // Ambil user yang sedang login
        $user = auth()->user();

        // Cek apakah tanggal awal dan akhir diberikan
        if ($tglAwal && $tglAkhir) {
            // Ambil data dari database sesuai dengan rentang tanggal dan hanya untuk user yang login
            $saleses = Sales::where('user_id', $user->id)
                ->whereBetween('tanggal_jual', [$tglAwal, $tglAkhir])
                ->get();
        } else {
            // Jika tanggal tidak diberikan, ambil semua data untuk user yang login
            $saleses = Sales::where('user_id', $user->id)->get();
        }

        // Hapus sesi tanggal setelah data diambil
        session()->forget(['tglAwal', 'tglAkhir']);

        return view('nasabah/cetak_laporan_jual_nasabah', compact('saleses', 'tglAwal', 'tglAkhir'));
    }

    public function tampilkan_tanggal_laporan_jual_nasabah(Request $request)
    {
        // Validasi input
        $request->validate([
            'txtTglAwal' => 'required|date',
            'txtTglAkhir' => 'required|date|after_or_equal:txtTglAwal',
        ]);

        $tglAwal = $request->input('txtTglAwal');
        $tglAkhir = $request->input('txtTglAkhir');

        // Simpan tanggal di sesi jika diberikan
        if ($tglAwal && $tglAkhir) {
            session(['tglAwal' => $tglAwal, 'tglAkhir' => $tglAkhir]);
        } else {
            session()->forget(['tglAwal', 'tglAkhir']);
        }

        // Ambil data dari database sesuai dengan rentang tanggal jika ada, jika tidak ambil semua data
        if ($tglAwal && $tglAkhir) {
            $saleses = Sales::whereBetween('tanggal_jual', [$tglAwal, $tglAkhir])->get();
        } else {
            $saleses = Sales::all();
        }

        // Kembalikan view dengan data yang difilter
        return view('nasabah/laporan_jual_nasabah', compact('saleses'));
    }
}
