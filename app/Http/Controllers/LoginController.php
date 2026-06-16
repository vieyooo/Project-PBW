<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 1. Menampilkan halaman login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        // Sesuaikan dengan letak file kamu: 'login' jika di luar, 'auth.login' jika di dalam folder auth
        return view('auth.login'); 
    }

    // 2. Memproses data login asli
public function login(Request $request)
{
    $username = trim($request->input('username'));
    $password = trim($request->input('password'));

    $credentials = [
        'NAMA_PETUGAS' => $username,
        'password'     => $password,
    ];

    if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    return back()->with('error', 'Nama Petugas atau Kata Sandi salah!')->withInput();
}

    // 3. Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}