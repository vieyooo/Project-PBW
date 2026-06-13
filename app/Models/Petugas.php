<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';
    protected $primaryKey = 'ID_PETUGAS';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ID_PETUGAS', 'NAMA_PETUGAS', 'JABATAN', 'FILE_TTD'
    ];
}