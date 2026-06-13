<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'NO_INVOICE';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'NO_INVOICE', 'TANGGAL', 'ID_SUPPLIER', 'NILAI_DDP', 'PPN', 'ONGKOS_KIRIM', 'DISKON', 'TOTAL_INVOICE', 'JUMLAH_HARGA', 'SCAN_NOTA'
    ];
}