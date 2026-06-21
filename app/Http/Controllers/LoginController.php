<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Petugas;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $username = trim($request->input('username'));
        $password = trim($request->input('password'));

        $petugas = Petugas::whereRaw("TRIM(NAMA_PETUGAS) = ?", [$username])->first();

        if (!$petugas || !Hash::check($password, $petugas->password)) {
            return back()
                ->with('error', 'Nama Petugas atau Kata Sandi salah!')
                ->withInput($request->only('username'));
        }

        // URUTAN PENTING: simpan session SEBELUM regenerate
        session([
            'login'        => true,
            'id_petugas'   => $petugas->ID_PETUGAS,
            'nama_petugas' => $petugas->NAMA_PETUGAS,
            'jabatan'      => $petugas->JABATAN,
            // 'nama' dipakai oleh layouts/app.blade.php
            'nama'         => $petugas->NAMA_PETUGAS,
        ]);

        Auth::login($petugas);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // invalidate() menghapus seluruh data session SEKALIGUS mengganti
        // session ID dengan cara yang aman & konsisten (cara resmi Laravel
        // untuk logout). Jangan pakai flush() di sini -- flush() hanya
        // mengosongkan data session tanpa mengganti session ID, sehingga
        // bisa menyebabkan CSRF token lama vs baru tabrakan dan memicu
        // error 419 Page Expired saat user langsung login lagi setelah logout.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}