<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController; // <-- PERIKSA HURUF "I" DAN "C" NYA WAJIB KAPITAL!
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
// ... (Semua import controller kamu di atas biarkan tetap ada) ...

// Rute Publik & Login/Logout
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ========================================================
// ========================================================
// KELOMPOK ROUTE WAJIB LOGIN ('auth')
// ========================================================
Route::middleware(['auth'])->group(function () {

    // --- SEMUA ROLE BISA MASUK ---
    // Owner, Admin, dan Production bisa melihat dashboard
    Route::middleware(['role:Owner,Customer,Production'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // --- BISA DIAKSES OLEH: OWNER DAN ADMIN SAJA ---
    Route::middleware(['role:Owner,Customer'])->group(function () {
        Route::resource('petugas', PetugasController::class);
        Route::resource('pelanggans', PelangganController::class);
        Route::resource('suppliers', SupplierController::class);
        
        Route::resource('penjualan', PenjualanController::class);
        Route::resource('detailpenjualan', DetailPenjualanController::class);
    });

    // --- BISA DIAKSES OLEH: OWNER DAN PRODUCTION SAJA ---
    Route::middleware(['role:Owner,Production'])->group(function () {
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

    // --- BISA DIAKSES OLEH: OWNER, ADMIN, DAN PRODUCTION ---
    Route::middleware(['role:Owner,Customer,Production'])->group(function () {
        Route::resource('pembelian', PembelianController::class);
        
        Route::prefix('pembelian/{no_invoice}/detail')->name('detail-pembelian.')->group(function () {
            Route::get('create',           [DetailPembelianController::class, 'create'])->name('create');
            Route::post('/',               [DetailPembelianController::class, 'store'])->name('store');
            Route::get('{id_bahan}/edit',  [DetailPembelianController::class, 'edit'])->name('edit');
            Route::put('{id_bahan}',       [DetailPembelianController::class, 'update'])->name('update');
            Route::delete('{id_bahan}',    [DetailPembelianController::class, 'destroy'])->name('destroy');
        });
    });

});