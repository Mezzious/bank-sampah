<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sales;
use Illuminate\Http\Request;
use App\Models\Trash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class SuperAdminController extends Controller
{
    public function index()
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();

        // Pastikan pengguna telah login sebelum menampilkan data
        if ($user) {
            // Data statistik
            $totalBerat = Purchase::sum('berat');
            $totalPenjualan = Sales::sum('total');
            $totalPembelian = Purchase::sum('total');
            $totalNasabah = Customer::count();

            // Data untuk grafik
            $sales = Sales::selectRaw('DATE_FORMAT(tanggal_jual, "%Y-%m") as month, SUM(berat) as total_berat, SUM(total) as total_harga')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $purchases = Purchase::selectRaw('DATE_FORMAT(tanggal_beli, "%Y-%m") as month, SUM(berat) as total_berat, SUM(total) as total_harga')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $months = $sales->pluck('month')->union($purchases->pluck('month'))->unique()->sort();

            $totalBeratPenjualanPerBulan = $sales->pluck('total_berat', 'month');
            $totalHargaPenjualanPerBulan = $sales->pluck('total_harga', 'month');

            $totalBeratPembelianPerBulan = $purchases->pluck('total_berat', 'month');
            $totalHargaPembelianPerBulan = $purchases->pluck('total_harga', 'month');

            return view('superadmin/dashboard', compact(
                'user',
                'totalBerat',
                'totalPenjualan',
                'totalPembelian',
                'totalNasabah',
                'months',
                'totalBeratPenjualanPerBulan',
                'totalHargaPenjualanPerBulan',
                'totalBeratPembelianPerBulan',
                'totalHargaPembelianPerBulan'
            ));
        } else {
            // Jika pengguna belum login, bisa diarahkan ke halaman login atau tindakan lainnya
            return redirect()->route('login');
        }
    }


    public function data_user()
    {
        $users = User::whereNotIn('roles', ['nasabah'])->get();
        return view('superadmin/data_user', compact('users'));
    }

    public function tambah_user()
    {
        // Roles yang harus ada
        $defaultRoles = ['super-admin', 'admin', 'user'];

        // Ambil roles yang ada di database
        $existingRoles = User::select('roles')
            ->whereIn('roles', $defaultRoles)
            ->distinct()
            ->pluck('roles')
            ->toArray();

        // Gabungkan roles dari database dengan roles default dan hilangkan duplikat
        $roles = array_unique(array_merge($defaultRoles, $existingRoles));

        // Buat array objek roles
        $roles = array_map(function ($role) {
            return (object) ['roles' => $role];
        }, $roles);

        return view("superadmin/tambah_user", compact('roles'));

        return view("superadmin/tambah_user", compact('roles'));
    }

    public function store_user(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'roles' => 'required|in:super-admin,admin,user', // Pastikan rolenya sesuai dengan yang diizinkan
        ]);

        // Simpan data ke dalam database
        $users = new User();
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->password = bcrypt($request->input('password')); // Encrypt password menggunakan bcrypt
        $users->roles = $request->input('roles');
        $users->save();

        return redirect()->route('data_user')->with('success', 'User berhasil ditambahkan');
    }

    public function edit_user(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $roles = User::distinct('roles')->pluck('roles');
        return view("superadmin/edit_user", compact('user', 'roles'));
    }

    public function update_user(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|string|min:6',
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->route('data_user', $id)->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->roles == 'nasabah') {
            $customer = Customer::where('user_id', $id)->first();
            if ($customer) {
                $customer->delete();
            }
        }
        $user->delete();

        return redirect()->route('data_user')->with('success', 'User berhasil dihapus');
    }

    public function ganti_password()
    {
        return view("superadmin/ganti_password");
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
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

    public function data_nasabah()
    {
        $cust = Customer::with('user')->get();
        return view('superadmin/data_nasabah', compact('cust'));
    }

    public function tambah_nasabah()
    {
        return view("superadmin/tambah_nasabah");
    }

    public function store_nasabah(Request $request)
    {
        $request->validate([
            'nama_nasabah' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'RW' => 'required|string|min:1',
            'telepon' => 'required|string|min:12',
            'alamat' => 'required',
        ]);

        // Simpan data ke dalam database
        $user = new User();
        $user->name = $request->input('nama_nasabah');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->roles = 'nasabah';
        $user->save();

        $customer = new Customer();
        $customer->user_id = $user->id;
        $customer->RW = $request->input('RW');
        $customer->telepon = $request->input('telepon');
        $customer->alamat = $request->input('alamat');
        $customer->save();

        return redirect()->route('data_nasabah')->with('success', 'Nasabah berhasil ditambahkan');
    }

    public function edit_nasabah(Request $request)
    {
        $id = $request->input('id');
        $customer = Customer::findOrFail($id);
        $user = User::findOrFail($customer->user_id);

        if (!$customer) {
            return back()->with('error', 'Data nasabah tidak ditemukan.');
        }

        return view('superadmin/edit_nasabah', compact('customer', 'user'));
    }

    public function update_nasabah(Request $request)
    {
        $id = $request->input('id');

        // Validasi input
        $request->validate([
            'nama_nasabah' => 'required|string',
            'email' => 'required|email',
            'RW' => 'required|string|min:1',
            'telepon' => 'required|string|min:12',
            'alamat' => 'required',
        ]);

        // Ambil data nasabah berdasarkan id
        $customer = Customer::findOrFail($id);

        if (!$customer) {
            return back()->with('error', 'Data nasabah tidak ditemukan.');
        }

        // Update data nasabah
        $customer->RW = $request->input('RW');
        $customer->telepon = $request->input('telepon');
        $customer->alamat = $request->input('alamat');
        $customer->save();

        // Ambil data pengguna (user) yang terkait dengan nasabah
        $user = User::findOrFail($customer->user_id);

        if (!$user) {
            return back()->with('error', 'Data pengguna tidak ditemukan.');
        }

        // Update data pengguna (user)
        $user->name = $request->input('nama_nasabah');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('data_nasabah', $id)->with('success', 'Nasabah berhasil diupdate');
    }

    public function destroy_nasabah($id)
    {
        $user = User::findOrFail($id);
        if ($user->roles == 'nasabah') {
            $customer = Customer::where('user_id', $id)->first();
            if ($customer) {
                $customer->delete();
            }
        }
        $user->delete();

        return redirect()->route('data_nasabah')->with('success', 'Nasabah berhasil dihapus');
    }

    public function data_sampah()
    {
        $trashes = Trash::all();
        return view('superadmin/data_sampah', compact('trashes'));
    }

    public function tambah_sampah()
    {
        return view("superadmin/tambah_sampah");
    }

    public function store_sampah(Request $request)
    {
        $request->validate([
            'jenis_sampah' => 'required|string',
            'satuan' => 'required|string|max:2',
            'harga' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required',
        ]);

        //simpan gambar
        $gambarName = time() . '.' . $request->gambar->extension();
        if (!$request->gambar->isValid()) {
            return back()->withErrors(['gambar' => 'File gambar tidak valid']);
        }
        $request->gambar->storeAs('public/assets/sampah', $gambarName);

        //Simpan data ke dalam database
        $trashes = new Trash();
        $trashes->user_id = auth()->id();
        $trashes->jenis_sampah = $request->input('jenis_sampah');
        $trashes->satuan = $request->input('satuan');
        $trashes->harga = $request->input('harga');
        $trashes->gambar = $gambarName;
        $trashes->deskripsi = $request->input('deskripsi');
        $trashes->save();

        return redirect()->route('data_sampah')->with('success', 'Data Sampah berhasil ditambahkan');
    }

    public function edit_sampah(Request $request)
    {
        $id = $request->input('id');
        $trashes = Trash::findOrFail($id);

        if (!$trashes) {
            return back()->with('error', 'Data sampah tidak ditemukan.');
        }

        return view('superadmin/edit_sampah', compact('trashes'));
    }

    public function update_sampah(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'jenis_sampah' => 'required|string',
            'satuan' => 'required|string|max:2',
            'harga' => 'required|numeric',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required',
        ]);

        // Temukan sampah berdasarkan ID
        $trash = Trash::findOrFail($id);

        // Hapus gambar lama jika pengguna mengunggah gambar baru
        if ($request->hasFile('gambar')) {
            Storage::delete('public/assets/sampah/' . $trash->gambar);

            $gambarName = time() . '.' . $request->gambar->extension();
            if (!$request->gambar->isValid()) {
                return back()->withErrors(['gambar' => 'File gambar tidak valid']);
            }
            $request->gambar->storeAs('public/assets/sampah', $gambarName);
            $trash->gambar = $gambarName;
        }

        // Perbarui data lainnya
        $trash->jenis_sampah = $request->input('jenis_sampah');
        $trash->satuan = $request->input('satuan');
        $trash->harga = $request->input('harga');
        $trash->deskripsi = $request->input('deskripsi');
        $trash->save();

        return redirect()->route('data_sampah')->with('success', 'Data Sampah berhasil diupdate');
    }

    public function destroy_sampah($id)
    {
        $trashes = Trash::findOrFail($id);

        // Path gambar di storage
        $gambarPath = 'public/assets/sampah/' . $trashes->gambar;

        // Hapus gambar dari storage
        if (Storage::exists($gambarPath)) {
            Storage::delete($gambarPath);
        }

        $trashes->delete();

        return redirect()->route('data_sampah')->with('success', ' Data Sampah berhasil dihapus');
    }

    public function tampilkan_tanggal()
    {
        return view('superadmin/transaksi_jual');
    }

    public function transaksi_beli()
    {
        $purchases = Purchase::all();
        return view('superadmin/transaksi_beli', compact('purchases'));
    }

    public function transaksi_jual()
    {
        $saleses = Sales::all();
        return view('superadmin/transaksi_jual', compact('saleses'));
    }

    public function laporan_beli()
    {
        $purchases = Purchase::all();
        return view('superadmin/laporan_beli', compact('purchases'));
    }

    public function laporan_jual()
    {
        $saleses = Sales::all();
        return view('superadmin/laporan_jual', compact('saleses'));
    }

    public function cetak_laporan_beli(Request $request)
    {
        // Ambil tanggal dari sesi
        $tglAwal = session('tglAwal');
        $tglAkhir = session('tglAkhir');

        // Cek apakah tanggal awal dan akhir diberikan
        if ($tglAwal && $tglAkhir) {
            // Ambil data dari database sesuai dengan rentang tanggal
            $purchases = Purchase::whereBetween('tanggal_beli', [$tglAwal, $tglAkhir])->get();
        } else {
            // Jika tanggal tidak diberikan, ambil semua data
            $purchases = Purchase::all();
        }

        // Hapus sesi tanggal setelah data diambil
        session()->forget(['tglAwal', 'tglAkhir']);

        // Return view cetak laporan dengan data yang difilter
        return view('superadmin/cetak_laporan_beli', compact('purchases', 'tglAwal', 'tglAkhir'));
    }

    public function cetak_laporan_jual(Request $request)
    {
        // Ambil tanggal dari sesi
        $tglAwal = session('tglAwal');
        $tglAkhir = session('tglAkhir');

        // Cek apakah tanggal awal dan akhir diberikan
        if ($tglAwal && $tglAkhir) {
            // Ambil data dari database sesuai dengan rentang tanggal
            $saleses = Sales::whereBetween('tanggal_jual', [$tglAwal, $tglAkhir])->get();
        } else {
            // Jika tanggal tidak diberikan, ambil semua data
            $saleses = Sales::all();
        }

        // Hapus sesi tanggal setelah data diambil
        session()->forget(['tglAwal', 'tglAkhir']);

        return view('superadmin/cetak_laporan_jual', compact('saleses', 'tglAwal', 'tglAkhir')); //return view terbalik
    }

    public function tampilkan_tanggal_beli_transaksi(Request $request)
    {
        // Validasi input
        $request->validate([
            'txtTglAwal' => 'required|date',
            'txtTglAkhir' => 'required|date|after_or_equal:txtTglAwal',
        ]);

        $tglAwal = $request->input('txtTglAwal');
        $tglAkhir = $request->input('txtTglAkhir');

        // Ambil data dari database sesuai dengan rentang tanggal
        $purchases = Purchase::whereBetween('tanggal_beli', [$tglAwal, $tglAkhir])->get();

        // Kembalikan view dengan data yang difilter
        return view('superadmin/transaksi_beli', compact('purchases'));
    }

    public function tampilkan_tanggal_jual_transaksi(Request $request)
    {
        // Validasi input
        $request->validate([
            'txtTglAwal' => 'required|date',
            'txtTglAkhir' => 'required|date|after_or_equal:txtTglAwal',
        ]);

        $tglAwal = $request->input('txtTglAwal');
        $tglAkhir = $request->input('txtTglAkhir');

        // Ambil data dari database sesuai dengan rentang tanggal
        $saleses = Sales::whereBetween('tanggal_jual', [$tglAwal, $tglAkhir])->get();

        // Kembalikan view dengan data yang difilter
        return view('superadmin/transaksi_jual', compact('saleses'));
    }

    public function tampilkan_tanggal_beli_laporan(Request $request)
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
            $purchases = Purchase::whereBetween('tanggal_beli', [$tglAwal, $tglAkhir])->get();
        } else {
            $purchases = Purchase::all();
        }

        // Kembalikan view dengan data yang difilter
        return view('superadmin/laporan_beli', compact('purchases'));
    }

    public function tampilkan_tanggal_jual_laporan(Request $request)
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
        return view('superadmin/laporan_jual', compact('saleses'));
    }

    public function nota_transaksi_beli(Request $request)
    {
        $id = $request->input('id');
        // Mengambil data purchase berdasarkan ID
        $purchases = Purchase::with('user') // Mengambil data terkait customer dan user
            ->where('id', $id)
            ->firstOrFail(); // Mengambil satu data atau gagal

        //mengambil user dengan role 'superadmin'
        $superadmin = User::where('roles', 'super-admin')->first();

        return view('superadmin/nota_transaksi_beli', compact('purchases', 'superadmin'));
    }

    public function nota_transaksi_jual(Request $request)
    {
        $id = $request->input('id');
        // Mengambil data purchase berdasarkan ID
        $saleses = Sales::with('user') // Mengambil data terkait customer dan user
            ->where('id', $id)
            ->firstOrFail(); // Mengambil satu data atau gagal

        //mengambil user dengan role 'superadmin'
        $superadmin = User::where('roles', 'super-admin')->first();

        return view('superadmin/nota_transaksi_jual', compact('saleses', 'superadmin'));
    }
}
