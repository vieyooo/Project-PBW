<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    // Nama tabel di database (sesuai konvensi Laravel: lowercase + plural)
    protected $table = 'suppliers';

    // Primary key custom (bukan 'id' default Laravel)
    protected $primaryKey = 'id_supplier';

    // Primary key bukan integer (karena format SUP-001)
    public $incrementing = false;
    protected $keyType = 'string';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'id_supplier',
        'nama_supplier',
        'alamat',
        'no_telp',
        'fax',
        'pic_supplier',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    /**
     * Supplier memiliki banyak transaksi pembelian
     * (digunakan untuk cek sebelum hapus)
     */
    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'id_supplier', 'id_supplier');
    }

    // ==========================================
    // HELPER: AUTO-GENERATE ID (SUP-001)
    // ==========================================

    /**
     * Generate ID Supplier otomatis berikutnya
     * Contoh: jika max = SUP-005, return SUP-006
     */
    public static function generateId(): string
    {
        $maxId = self::max('id_supplier'); // ambil ID terbesar

        if ($maxId) {
            // Ambil angka dari "SUP-005" → 5
            $urutan = (int) substr($maxId, 4, 3);
            $urutan++;
        } else {
            $urutan = 1;
        }

        return 'SUP-' . sprintf('%03d', $urutan);
    }
}
