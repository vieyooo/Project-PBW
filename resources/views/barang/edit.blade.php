@extends('layouts.app')

@section('page-title', 'Edit Barang')

@section('content')
<style>
    /* ======================================== */
    /* THEME GOLD PUTIH - VERTUE CONCEPT */
    /* ======================================== */
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

    .info-barang {
        background: #fef3c7;
        padding: 16px 20px;
        border-radius: 16px;
        margin-bottom: 28px;
    }

    .info-row {
        margin-bottom: 10px;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-label {
        font-weight: 700;
        color: #64748b;
        width: 120px;
        display: inline-block;
        font-size: 14px;
    }

    .info-value {
        color: #0f172a;
        font-weight: 600;
        font-size: 14px;
    }

    .info-value strong {
        color: #b8860b;
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
        color: #b8860b;
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
        background-color: #ffffff;
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
        box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2);
    }

    .btn-primary:hover {
        background: #9a7009;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(184, 134, 11, 0.3);
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .alert-error {
        background: #fef2f2;
        color: #dc2626;
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
        border-left: 4px solid #dc2626;
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
            border-radius: 16px;
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
        <h3><i class="fas fa-edit"></i> Form Edit Barang</h3>
        <a href="{{ route('barang.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="info-barang">
        <div class="info-row">
            <span class="info-label">ID BARANG :</span>
            <span class="info-value"><strong>{{ $data->ID_BARANG }}</strong></span>
        </div>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle"></i> {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('barang.update', $data->ID_BARANG) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Nama Barang <span>*</span></label>
            <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $data->NAMA_BARANG) }}" required autocomplete="off">
            <small>Nama produk/layanan yang akan dijual ke pelanggan</small>
        </div>

        <div class="form-group">
            <label class="form-label">Harga Satuan (Rp) <span>*</span></label>
            <input type="text" name="harga_satuan" class="form-control" value="{{ old('harga_satuan', number_format($data->HARGA_SATUAN, 0, ',', '.')) }}" required autocomplete="off">
            <small>Harga jual per unit barang</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Perbarui Data
            </button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal / Kembali
            </a>
        </div>
    </form>
</div>
@endsection