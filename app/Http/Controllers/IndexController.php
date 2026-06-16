<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // WAJIB DIIMPOR untuk mendeteksi login petugas

class IndexController extends Controller
{
    public function index(Request $request)
    {
        // 1. Cek apakah petugas sudah login menggunakan sistem Auth Laravel bawaan
        $isLoggedIn = Auth::check();
        
        // 2. Jika sudah login, ambil nama asli petugas dari database lewat Auth::user()
        // Kolom di database kamu bernama 'NAMA_PETUGAS'
        $adminName = $isLoggedIn ? Auth::user()->NAMA_PETUGAS : '';

        // 3. Kirimkan data variabel ke file View 'index.blade.php'
        return view('index', [
            'isLoggedIn' => $isLoggedIn,
            'adminName' => $adminName
        ]);
    }
}