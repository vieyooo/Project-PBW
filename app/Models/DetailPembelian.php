<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $table = 'detail_pembelian';
    public $timestamps = false;

    protected $fillable = [
        'NO_INVOICE', 'ID_BAHAN_BAKU', 'QTY', 'HARGA_JUAL'
    ];
}