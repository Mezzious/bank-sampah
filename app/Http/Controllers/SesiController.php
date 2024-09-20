<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class SesiController extends Controller
{
    function index()
    {
        return view('auth/login');
    }

    function login(Request $request)
    {
        // Validasi input
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek apakah remember me dicentang
        $remember = $request->has('remember');

        // Attempt login dengan remember me
        if (Auth::attempt(['email' => $validate['email'], 'password' => $validate['password']], $remember)) {
            $request->session()->regenerate();

            // Jika Remember Me dicentang, simpan email dalam cookie
            if ($remember) {
                Cookie::queue('remember_email', $request->email, 43200); // Simpan selama 30 hari
            }

            // Cek role pengguna dan arahkan ke halaman yang sesuai
            if (Auth::user()->roles == 'super-admin') {
                return redirect()->intended('/superadmin');
            } elseif (Auth::user()->roles == 'admin') {
                return redirect()->intended('/admin');
            } elseif (Auth::user()->roles == 'user') {
                return redirect()->intended('/user');
            } elseif (Auth::user()->roles == 'nasabah') {
                return redirect()->intended('/nasabah');
            }

        } else {
            // Cek apakah email ada di database
            $user = User::where('email', $request->email)->first();
            if ($user) {
                // Jika email ada tapi password salah
                return redirect('/')->with('error', 'Email atau password yang Anda masukkan salah')->withInput();
            } else {
                // Jika email tidak ada di database
                return redirect('/')->with('error', 'User belum terdaftar')->withInput();
            }
        }
    }

    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
