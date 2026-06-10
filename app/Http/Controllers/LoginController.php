<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Petugas;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        // Jika sudah login, langsung lempar ke dashboard
        if (session()->has('login') && session('login') === true) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }

    // Memproses data login
    public function login(Request $request)
    {
        // Ambil input dari form
        $username = $request->input('username');
        $password = $request->input('password');

        // Cari data di tabel petugas
        $petugas = Petugas::where('NAMA_PETUGAS', $username)->first();

        if ($petugas) {
            // Pengecekan password (masih mengikuti logikamu: password default '123')
            // Catatan: Nanti untuk sistem produksi nyata, gunakan Hash::check() ya!
            if ($password === '123') {
                
                // Set session menggunakan helper Laravel
                session([
                    'login' => true,
                    'id_petugas' => $petugas->ID_PETUGAS,
                    'nama_petugas' => $petugas->NAMA_PETUGAS,
                    'jabatan' => $petugas->JABATAN
                ]);

                return redirect()->route('dashboard');
            } else {
                // Kembali ke halaman login dengan pesan error
                return back()->with('error', 'Password salah!')->withInput();
            }
        } else {
            return back()->with('error', 'Nama Petugas tidak ditemukan!')->withInput();
        }
    }

    // Fungsi untuk logout sekalian
    public function logout()
    {
        session()->flush(); // Hapus semua session
        return redirect()->route('login');
    }
}