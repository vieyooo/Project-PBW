<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'ID_BARANG';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID_BARANG',
        'NAMA_BARANG',
        'HARGA_SATUAN',
    ];

    public function bom()
    {
        return $this->hasMany(Bom::class, 'ID_BARANG', 'ID_BARANG');
    }
}