@extends('layouts.app')

@section('page-title', 'Tambah Barang')

@section('content')
<style>
    .form-container {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        padding: 32px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        width: 100%;
        max-width: 700px;
        margin: 0 auto;
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f1f5f9;
    }

    .form-header h3 {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        margin: 0;
    }

    .form-header h3 i {
        color: #b8860b;
        margin-right: 12px;
        font-size: 24px;
        background: rgba(184, 134, 11, 0.1);
        padding: 10px;
        border-radius: 12px;
    }

    .btn-back {
        background: #f1f5f9;
        color: #475569;
        padding: 8px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: #e2e8f0;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
        color: #334155;
    }

    .form-label span {
        color: #ef4444;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: #0f172a;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        transition: all 0.2s;
        outline: none;
    }

    .form-control:focus {
        border-color: #b8860b;
        box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.1);
    }

    .form-control:read-only {
        background-color: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
    }

    .form-actions {
        display: flex;
        gap: 16px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }

    .btn-primary {
        background: #b8860b;
        color: white;
    }

    .btn-primary:hover {
        background: #9a7009;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
    }

    .alert-error {
        background: #fef2f2;
        color: #dc2626;
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 24px;
        border-left: 4px solid #dc2626;
        font-size: 14px;
    }

    small {
        display: block;
        margin-top: 6px;
        color: #94a3b8;
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
        }
        .form-actions {
            flex-direction: column;
        }
        .btn {
            justify-content: center;
        }
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h3><i class="fas fa-plus-circle"></i> Form Tambah Barang</h3>
        <a href="{{ route('barang.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('barang.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">ID Barang</label>
            <input type="text" name="id_barang" class="form-control" value="{{ $id_otomatis }}" readonly>
        </div>

        <div class="form-group">
            <label class="form-label">Nama Barang <span>*</span></label>
            <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Lapis Jok Kulit Full (Mobil Sedan)" required autocomplete="off" value="{{ old('nama_barang') }}">
            <small>Nama produk/layanan yang akan dijual ke pelanggan</small>
        </div>

        <div class="form-group">
            <label class="form-label">Harga Satuan (Rp) <span>*</span></label>
            <input type="number" name="harga_satuan" class="form-control" placeholder="Contoh: 4500000" required autocomplete="off" step="1" value="{{ old('harga_satuan') }}">
            <small>Harga jual per unit barang (isi angka saja)</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Data
            </button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal / Kembali
            </a>
        </div>
    </form>
</div>
@endsection