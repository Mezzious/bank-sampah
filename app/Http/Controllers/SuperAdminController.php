<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sales;
use Illuminate\Http\Request;
use App\Models\SuperAdmin;
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
            return view('superadmin/dashboard', compact('user'));
        } else {
            // Jika pengguna belum login, bisa diarahkan ke halaman login atau tindakan lainnya
            return redirect()->route('login');
        }
    }

    public function data_user()
    {
        $users = SuperAdmin::whereNotIn('roles', ['nasabah'])->get();
        return view('superadmin/data_user', compact('users'));
    }

    public function tambah_user()
    {
        return view("superadmin/tambah_user");
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
        $users = new SuperAdmin();
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
        $user = SuperAdmin::find($id);

        if (!$user) {
            return back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $roles = SuperAdmin::distinct('roles')->pluck('roles');
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

        $user = SuperAdmin::find($id);
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
        $user = SuperAdmin::findOrFail($id); 
        if($user->roles == 'nasabah'){
                $customer = Customer::where('user_id', $id)->first();
            if($customer){
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
        $user = SuperAdmin::findOrFail($customer->user_id);

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
        $user = SuperAdmin::findOrFail($customer->user_id);

        if (!$user) {
            return back()->with('error', 'Data pengguna tidak ditemukan.');
        }

        // Update data pengguna (user)
        $user->name = $request->input('nama_nasabah');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('data_nasabah', $id)->with('success', 'User berhasil diupdate');
    }

    public function destroy_nasabah($id)
    {
        $user = SuperAdmin::findOrFail($id); 
        if($user->roles == 'nasabah'){
            $customer = Customer::where('user_id', $id)->first();
            if($customer){
                $customer->delete();
            }
        }
        $user->delete();

        return redirect()->route('data_nasabah')->with('success', 'User berhasil dihapus');
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
    
            return redirect()->route('data_sampah')->with('success', 'Data Sampah berhasil diperbarui');
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

        return redirect()->route('data_sampah')->with('success', 'Sampah berhasil dihapus');
    }
    
    public function tampilkan_tanggal()
    {
        return view('superadmin/transaksi_jual');
    }
    
    public function transaksi_jual()
    {
        $saleses = Sales::all();
        return view('superadmin/transaksi_jual', compact('saleses'));
    }

    // public function tambah_transaksi_jual()
    // {
    //     return view('superadmin/tambah_transaksi_jual');
    // }

    // public function edit_transaksi_jual()
    // {
    //     return view('superadmin/edit_transaksi_jual');
    // }

    public function transaksi_beli()
    {
        return view('superadmin/transaksi_beli');
    }

    public function tambah_transaksi_beli()
    {
        return view('superadmin/tambah_transaksi_beli');
    }

    public function edit_transaksi_beli()
    {
        return view('superadmin/edit_transaksi_beli');
    }

    public function laporan_jual()
    {
        $saleses = Sales::all();
        return view('superadmin/laporan_jual', compact('saleses'));
    }

    public function laporan_beli()
    {
        return view('superadmin/laporan_beli');
    }

    public function cetak_laporan_jual()
    {
        return view('superadmin/cetak_laporan_jual');
    }
    public function cetak_laporan_beli()
    {
        return view('superadmin/cetak_laporan_beli');
    }
}
