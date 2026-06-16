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
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DetailPenjualanController;

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
Route::resource('pembelian', PembelianController::class);
Route::get('barang/{id}/bom', [BarangBomController::class, 'index'])->name('barang.bom.index');
Route::get('barang/{id}/bom/create', [BarangBomController::class, 'create'])->name('barang.bom.create');
Route::post('barang/{id}/bom', [BarangBomController::class, 'store'])->name('barang.bom.store');
Route::get('barang/{id}/bom/{bahan}/edit', [BarangBomController::class, 'edit'])->name('barang.bom.edit');
Route::put('barang/{id}/bom/{bahan}', [BarangBomController::class, 'update'])->name('barang.bom.update');
Route::delete('barang/{id}/bom/{bahan}', [BarangBomController::class, 'destroy'])->name('barang.bom.destroy');
Route::get('barang/{id}/bom/cetak', [BarangBomController::class, 'cetak'])->name('barang.bom.cetak');
Route::prefix('pembelian/{no_invoice}/detail')->name('detail-pembelian.')->group(function () {
    Route::get('create',           [DetailPembelianController::class, 'create'])->name('create');
    Route::post('/',               [DetailPembelianController::class, 'store'])->name('store');
    Route::get('{id_bahan}/edit',  [DetailPembelianController::class, 'edit'])->name('edit');
    Route::put('{id_bahan}',       [DetailPembelianController::class, 'update'])->name('update');
    Route::delete('{id_bahan}',    [DetailPembelianController::class, 'destroy'])->name('destroy');
});
// Route Penjualan
Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
Route::get('/penjualan/edit/{id}', [PenjualanController::class, 'edit'])->name('penjualan.edit');
Route::put('/penjualan/{id}', [PenjualanController::class, 'update'])->name('penjualan.update');
Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

// Route Detail Penjualan
Route::get('/detailpenjualan', [DetailPenjualanController::class, 'index'])->name('detailpenjualan.index');
Route::get('/detailpenjualan/create', [DetailPenjualanController::class, 'create'])->name('detailpenjualan.create');
Route::post('/detailpenjualan', [DetailPenjualanController::class, 'store'])->name('detailpenjualan.store');
Route::get('/detailpenjualan/edit', [DetailPenjualanController::class, 'edit'])->name('detailpenjualan.edit');
Route::put('/detailpenjualan', [DetailPenjualanController::class, 'update'])->name('detailpenjualan.update');
Route::delete('/detailpenjualan', [DetailPenjualanController::class, 'destroy'])->name('detailpenjualan.destroy');
Route::get('/detailpenjualan/cetak', [DetailPenjualanController::class, 'cetak'])->name('detailpenjualan.cetak');
