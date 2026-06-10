<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    // Mengarahkan Model ke tabel spesifik
    protected $table = 'petugas';

    // Mengatur Primary Key jika bukan 'id'
    protected $primaryKey = 'ID_PETUGAS';

    // Jika tipe Primary Key bukan integer auto-increment (misal: varchar), uncomment ini:
    // protected $keyType = 'string';
    // public $incrementing = false;

    // Jika tabelmu tidak punya kolom created_at & updated_at
    public $timestamps = false; 
}