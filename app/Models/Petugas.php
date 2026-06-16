<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    // 1. Deklarasi nama tabel aslinya di dbvertue
    protected $table = 'petugas';
    
    // 2. Deklarasi nama kolom primary key aslinya
    protected $primaryKey = 'ID_PETUGAS';
    
    // 3. WAJIB: Kasih tahu Laravel kalau Primary Key kita berbentuk TEKS/STRING (bukan angka)
    protected $keyType = 'string';
    
    // 4. WAJIB: Matikan fitur Auto-Increment (karena kita pakai format PG-1001, bukan angka urut 1, 2, 3)
    public $incrementing = false;
    
    // 5. Matikan fitur timestamps bawaan Laravel (created_at & updated_at) karena tabel kita tidak punya
    public $timestamps = false; 

    // 6. Daftarkan semua kolom agar bisa dibaca dan dimanipulasi oleh Laravel
    protected $fillable = ['ID_PETUGAS', 'NAMA_PETUGAS', 'JABATAN', 'password'];
    
    // 7. Sembunyikan kolom password dari array bawaan, tapi tetap bisa dipakai oleh sistem Auth
    protected $hidden = ['password'];

    /**
     * Beritahu Laravel kalau kolom yang digunakan 
     * sebagai identitas username login adalah NAMA_PETUGAS
     */
    public function username()
    {
        return 'NAMA_PETUGAS';
    }

    /**
     * Beritahu Laravel secara absolut kalau nama kolom 
     * kata sandi di tabel kita bernama 'password' (huruf kecil semua)
     */
    public function getAuthPassword()
    {
        return $this->password;
    }
}