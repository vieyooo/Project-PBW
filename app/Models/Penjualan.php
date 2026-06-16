<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'ID_PENJUALAN';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID_PENJUALAN', 'TANGGAL', 'JATUH_TEMPO', 'ID_PETUGAS',
        'ID_PELANGGAN', 'SUBTOTAL', 'DISKON', 'TOTAL',
        'SISA_TAGIHAN', 'PESAN', 'TERBILANG'
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'ID_PETUGAS', 'ID_PETUGAS');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'ID_PELANGGAN', 'ID_PELANGGAN');
    }

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'ID_PENJUALAN', 'ID_PENJUALAN');
    }
}