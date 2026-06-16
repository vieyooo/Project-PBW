<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'SUPPLIER';
    protected $primaryKey = 'ID_SUPPLIER';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID_SUPPLIER',
        'NAMA_SUPPLIER',
        'ALAMAT',
        'NO_TELP',
        'FAX',
        'PIC_SUPPLIER',
    ];
      public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'ID_SUPPLIER', 'ID_SUPPLIER');
    }
}