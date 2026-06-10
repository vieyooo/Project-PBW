<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;

// Rute Halaman Utama (Beranda)
Route::get('/', [IndexController::class, 'index'])->name('index');


// Rute untuk Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute sementara untuk dashboard (nanti bisa kita buat controllernya terpisah)
Route::get('/dashboard', function () {
    if (!session()->has('login')) return redirect()->route('login');
    return "Selamat datang di Dashboard, " . session('nama_petugas');
})->name('dashboard');

// Daftarkan rute dashboard utama
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('supplier', SupplierController::class);
});