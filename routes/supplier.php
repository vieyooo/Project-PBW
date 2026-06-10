<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTE SUPPLIER
|--------------------------------------------------------------------------
| Tambahkan baris ini ke dalam routes/web.php, di dalam middleware 'auth'
|
| Mapping dari PHP Native → Laravel Route:
|   supplier-lihat.php   → GET    /supplier           (index)
|   supplier-tambah.php  → GET    /supplier/create    (create)
|                        → POST   /supplier            (store)
|   supplier-ubah.php    → GET    /supplier/{id}/edit  (edit)
|                        → PUT    /supplier/{id}       (update)
|   supplier-hapus.php   → DELETE /supplier/{id}       (destroy)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::resource('supplier', SupplierController::class);
});
