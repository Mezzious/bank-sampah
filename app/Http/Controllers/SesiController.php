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
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            if (Auth::user()->role == 'super-admin') {
                return redirect('/superAdmin');
            } elseif (Auth::user()->role == 'admin') {
                return redirect('/admin');
            } elseif (Auth::user()->role == 'user') {
                return redirect('/user');
            }
        } else {
            return redirect('/index')->withErrors('Email atau password yang anda masukkan salah')->withInput();
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('/index');
    }
}
