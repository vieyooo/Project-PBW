<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\BarangBomController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\DetailPembelianController;

// Rute Publik & Login/Logout
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ========================================================
// KELOMPOK ROUTE WAJIB LOGIN ('auth')
// ========================================================
Route::middleware(['auth'])->group(function () {

    // SEMUA ROLE BISA DASHBOARD
    Route::middleware(['checkrole:Owner,Admin,Head'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // OWNER & ADMIN SAJA (Petugas, Pelanggan, Supplier, Penjualan)
    Route::middleware(['checkrole:Owner,Admin'])->group(function () {
        Route::resource('petugas', PetugasController::class);
        Route::resource('pelanggans', PelangganController::class);
        Route::resource('suppliers', SupplierController::class);
        // Route untuk Penjualan (resource)
        Route::resource('penjualan', PenjualanController::class);

        // Route untuk Detail Penjualan (manual dengan 2 parameter)
         Route::get('/detailpenjualan', [DetailPenjualanController::class, 'index'])->name('detailpenjualan.index');
Route::get('/detailpenjualan/create', [DetailPenjualanController::class, 'create'])->name('detailpenjualan.create');
Route::post('/detailpenjualan', [DetailPenjualanController::class, 'store'])->name('detailpenjualan.store');
Route::get('/detailpenjualan/edit', [DetailPenjualanController::class, 'edit'])->name('detailpenjualan.edit');
Route::put('/detailpenjualan/update', [DetailPenjualanController::class, 'update'])->name('detailpenjualan.update');
Route::delete('/detailpenjualan/delete', [DetailPenjualanController::class, 'destroy'])->name('detailpenjualan.destroy');
Route::get('/detailpenjualan/{id}/cetak', [DetailPenjualanController::class, 'cetakInvoice'])->name('detailpenjualan.cetak');
    });

    // OWNER & HEAD SAJA (Barang, Bahan Baku, BOM)
    Route::middleware(['checkrole:Owner,Head'])->group(function () {
        Route::resource('barang', BarangController::class);
        Route::resource('bahan-bakus', BahanBakuController::class);
        
        Route::get('barang/{id}/bom', [BarangBomController::class, 'index'])->name('barang.bom.index');
        Route::get('barang/{id}/bom/create', [BarangBomController::class, 'create'])->name('barang.bom.create');
        Route::post('barang/{id}/bom', [BarangBomController::class, 'store'])->name('barang.bom.store');
        Route::get('barang/{id}/bom/{bahan}/edit', [BarangBomController::class, 'edit'])->name('barang.bom.edit');
        Route::put('barang/{id}/bom/{bahan}', [BarangBomController::class, 'update'])->name('barang.bom.update');
        Route::delete('barang/{id}/bom/{bahan}', [BarangBomController::class, 'destroy'])->name('barang.bom.destroy');
        Route::get('barang/{id}/bom/cetak', [BarangBomController::class, 'cetak'])->name('barang.bom.cetak');
    });

    // SEMUA ROLE (Pembelian & Detail Pembelian)
    Route::middleware(['checkrole:Owner,Admin,Head'])->group(function () {
    Route::resource('pembelian', PembelianController::class);
    
    // {no_invoice} adalah nama parameter URL-nya
    Route::prefix('pembelian/{no_invoice}/detail')->name('pembelian.detail.')->group(function () {
        
        // HUBUNGKAN KE PembelianController@createDetail DI SINI
        Route::get('create', [PembelianController::class, 'createDetail'])->name('create');
        
        // Sisa route detail lainnya tetap ke DetailPembelianController
        Route::post('/',               [DetailPembelianController::class, 'store'])->name('store');
        Route::get('{id_bahan}/edit',  [DetailPembelianController::class, 'edit'])->name('edit');
        Route::put('{id_bahan}',       [DetailPembelianController::class, 'update'])->name('update');
        Route::delete('{id_bahan}',    [DetailPembelianController::class, 'destroy'])->name('destroy');
    });
});

});