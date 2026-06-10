<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        // Pengecekan session menggunakan helper Laravel
        $isLoggedIn = $request->session()->has('login') && $request->session()->get('login') === true;
        
        // Mengambil nama admin dari session, default 'Admin' jika tidak ada
        $adminName = $isLoggedIn ? $request->session()->get('nama', 'Admin') : '';

        // Mengirimkan data variabel ke file View 'home.blade.php'
        return view('index', [
            'isLoggedIn' => $isLoggedIn,
            'adminName' => $adminName
        ]);
    }
}