<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';
    public $timestamps = false;

    protected $fillable = [
        'ID_PENJUALAN', 'ID_BARANG', 'QTY', 'JUMLAH'
    ];
}