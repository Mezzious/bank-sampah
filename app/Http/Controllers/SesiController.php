<?php

namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index()
    {
        return view('auth/login');
    }

    function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($validate)) {
            $request->session()->regenerate();
            if (Auth::user()->roles == 'super-admin') {
                return redirect()->intended('/superadmin');
            } elseif (Auth::user()->roles == 'admin') {
                return redirect('/admin');
            } elseif (Auth::user()->roles == 'user') {
                return redirect('/user');
            }
        } else {
            return redirect('/index')->withErrors('Email atau password yang anda masukkan salah')->withInput();
        }
    }

    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/index');
    }
}
