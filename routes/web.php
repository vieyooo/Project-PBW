<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\BarangBomController;

// Rute Halaman Utama
Route::get('/', [IndexController::class, 'index'])->name('index');

// Rute Login/Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Resource routes
Route::resource('suppliers', SupplierController::class);
Route::resource('pelanggans', PelangganController::class);
Route::resource('barang', BarangController::class);
Route::resource('bahan-bakus', BahanBakuController::class);
Route::resource('petugas', PetugasController::class);
Route::get('barang/{id}/bom', [BarangBomController::class, 'index'])->name('barang.bom.index');
Route::get('barang/{id}/bom/create', [BarangBomController::class, 'create'])->name('barang.bom.create');
Route::post('barang/{id}/bom', [BarangBomController::class, 'store'])->name('barang.bom.store');
Route::get('barang/{id}/bom/{bahan}/edit', [BarangBomController::class, 'edit'])->name('barang.bom.edit');
Route::put('barang/{id}/bom/{bahan}', [BarangBomController::class, 'update'])->name('barang.bom.update');
Route::delete('barang/{id}/bom/{bahan}', [BarangBomController::class, 'destroy'])->name('barang.bom.destroy');
Route::get('barang/{id}/bom/cetak', [BarangBomController::class, 'cetak'])->name('barang.bom.cetak');