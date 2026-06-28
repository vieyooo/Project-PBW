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
        'NO_INVOICE', 'TANGGAL', 'ID_SUPPLIER',
        'NILAI_DPP', 'PPN', 'ONGKOS_KIRIM',
        // 'DISKON', // dihapus
        'TOTAL_INVOICE', 'JUMLAH_HARGA', 'SCAN_NOTA'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'ID_SUPPLIER', 'ID_SUPPLIER');
    }

    public function details()
    {
        return $this->hasMany(DetailPembelian::class, 'NO_INVOICE', 'NO_INVOICE');
    }
}