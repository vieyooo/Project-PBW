<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Jika belum login, tendang ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil jabatan user yang sedang login
        $jabatanUser = Auth::user()->JABATAN;

        // 3. COCOKKAN MENGGUNAKAN KATA KUNCI (Mencegah masalah karakter baris baru di phpMyAdmin)
        $izinkanAkses = false;
        foreach ($roles as $role) {
            if (Str::contains(strtolower($jabatanUser), strtolower($role))) {
                $izinkanAkses = true;
                break;
            }
        }

        // 4. Jika tidak ada kata kunci yang cocok, kunci aksesnya
        if (!$izinkanAkses) {
            abort(403, 'Akses Ditolak: Jabatan Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}