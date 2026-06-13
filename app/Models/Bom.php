<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    protected $table = 'bom';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ID_BARANG',
        'ID_BAHAN_BAKU',
        'JUMLAH',
    ];

    protected $primaryKey = null;

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'ID_BAHAN_BAKU', 'ID_BAHAN_BAKU');
    }
}