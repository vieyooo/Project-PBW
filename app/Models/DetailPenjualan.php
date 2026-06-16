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

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'ID_PENJUALAN', 'ID_PENJUALAN');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'ID_BARANG', 'ID_BARANG');
    }
}