<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\SupplierController;

Route::middleware(['auth'])->group(function () {
    Route::resource('supplier', SupplierController::class);
});


