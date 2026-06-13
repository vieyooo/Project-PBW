<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $table = 'bahan_baku';
    protected $primaryKey = 'ID_BAHAN_BAKU';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID_BAHAN_BAKU',
        'JENIS',
        'KODE',
        'HARGA_SATUAN',
        'SATUAN',
        'STOK',
    ];
}