<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    protected $table        = 'petugas';
    protected $primaryKey   = 'ID_PETUGAS';
    protected $keyType      = 'string';
    public    $incrementing = false;
    public    $timestamps   = false;

    protected $fillable = [
        'ID_PETUGAS',
        'NAMA_PETUGAS',
        'JABATAN',
        'FILE_TTD',
        'password',
    ];

    protected $hidden = ['password'];

    // =========================================================
    // WAJIB di Laravel 10+ / 12 — Override kontrak Authenticatable
    // =========================================================

    /** Kolom yang dipakai sebagai "username" oleh Auth */
    public function getAuthIdentifierName(): string
    {
        return 'NAMA_PETUGAS';
    }

    /** Nilai username user ini */
    public function getAuthIdentifier(): mixed
    {
        return $this->NAMA_PETUGAS;
    }

    /** Nilai password yang dicocokkan Hash::check() */
    public function getAuthPassword(): string
    {
        return $this->password ?? '';
    }

    /** Nama kolom password — dipakai EloquentUserProvider */
    public function getAuthPasswordName(): string
    {
        return 'password';
    }
}
