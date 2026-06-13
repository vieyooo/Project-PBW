<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'ID_PELANGGAN';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID_PELANGGAN', 'NAMA_PELANGGAN', 'ALAMAT', 'NO_TELP', 'FAX'
    ];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'ID_PELANGGAN', 'ID_PELANGGAN');
    }
}