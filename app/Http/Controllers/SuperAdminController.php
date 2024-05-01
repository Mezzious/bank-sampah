<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\SuperAdmin;
use App\Models\Trash;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view("superadmin/dashboard");
    }

    public function data_user()
    {
        $users = SuperAdmin::all();
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
        $user->delete();

        return redirect()->route('data_user')->with('success', 'User berhasil dihapus');
    }

    public function ganti_password()
    {
        return view("superadmin/ganti_password");
    }

    public function data_nasabah()
    {
        $cust = Customer::all();
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
            'RW' => 'required|string|min:1',
            'telepon' => 'required|string|min:12', 
            'alamat' => 'required', 
        ]);
    
        // Simpan data ke dalam database
        $customers = new Customer();
        $customers->user_id = auth()->id();
        $customers->nama_nasabah = $request->input('nama_nasabah');
        $customers->email = $request->input('email');
        $customers->RW = $request->input('RW');
        $customers->telepon = $request->input('telepon');
        $customers->alamat = $request->input('alamat');
        $customers->save();
    
        return redirect()->route('data_nasabah')->with('success', 'Nasabah berhasil ditambahkan');
    }    

    public function edit_nasabah(Request $request)
    {
        $id = $request->input('id');
        $customer = Customer::findOrFail($id);
    
        if (!$customer) {
            return back()->with('error', 'Data nasabah tidak ditemukan.');
        }
    
        return view('superadmin/edit_nasabah', compact('customer'));
    }

    public function update_nasabah(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'nama_nasabah' => 'required|string',
            'email' => 'required|email',
            'RW' => 'required|string|min:1',
            'telepon' => 'required|string|min:12', 
            'alamat' => 'required', 
        ]);

        $customers = Customer::find($id);
        $customers->nama_nasabah = $request->input('nama_nasabah');
        $customers->email = $request->input('email');
        $customers->RW = $request->input('RW');
        $customers->telepon = $request->input('telepon');
        $customers->alamat = $request->input('alamat');
        $customers->save();

        return redirect()->route('data_nasabah', $id)->with('success', 'User berhasil diupdate');
    }

    public function destroy_nasabah($id)
    {   
        $customers = Customer::findOrFail($id);
        $customers->delete();

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
        {
            $id = $request->input('id');
            $trashes = Trash::findOrFail($id);
        
            if (!$trashes) {
                return back()->with('error', 'Data sampah tidak ditemukan.');
            }
        
            return view('superadmin/edit_sampah', compact('trashes'));
        }
    }

    public function update_sampah(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'jenis_sampah' => 'required|string',
            'satuan' => 'required|string|max:2',
            'harga' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required',
        ]);

        $trashes = Trash::find($id);
        $trashes->jenis_sampah = $request->input('jenis_sampah');
        $trashes->satuan = $request->input('satuan');
        $trashes->harga = $request->input('harga');
        $trashes->deskripsi = $request->input('deskripsi');
        $trashes->save();

        return redirect()->route('data_nasabah', $id)->with('success', 'User berhasil diupdate');
    }

    public function transaksi_jual()
    {
        return view('superadmin/transaksi_jual');
    }

    public function tambah_transaksi_jual()
    {
        return view('superadmin/tambah_transaksi_jual');
    }

    public function edit_transaksi_jual()
    {
        return view('superadmin/edit_transaksi_jual');
    }

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
        return view('superadmin/laporan_jual');
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
