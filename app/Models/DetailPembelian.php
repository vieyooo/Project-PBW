<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $table = 'detail_pembelian';
    public $timestamps = false;

    protected $fillable = [
        'NO_INVOICE', 'ID_BAHAN_BAKU', 'QTY', 'HARGA_BELI'
    ];

    // Relasi ke Pembelian
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'NO_INVOICE', 'NO_INVOICE');
    }

    // Relasi ke BahanBaku
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'ID_BAHAN_BAKU', 'ID_BAHAN_BAKU');
    }

    // Accessor subtotal
    public function getSubtotalAttribute()
    {
        return $this->QTY * $this->HARGA_JUAL;
    }
}