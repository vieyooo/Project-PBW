@extends('layouts.app')

@section('page-title', 'Edit BOM')

@section('content')
<style>
    .form-container {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        padding: 32px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        max-width: 800px;
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
    .form-header h3 { font-size: 24px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 12px; }
    .form-header h3 i { color: #b8860b; font-size: 28px; }

    .btn-back { background: #f1f5f9; color: #475569; padding: 10px 20px; border-radius: 12px; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
    .btn-back:hover { background: #e2e8f0; }

    .info-barang { background: #fef3c7; padding: 20px 24px; border-radius: 16px; margin-bottom: 28px; }
    .info-row { display: flex; align-items: baseline; margin-bottom: 12px; }
    .info-row:last-child { margin-bottom: 0; }
    .info-label { font-weight: 700; color: #64748b; width: 140px; font-size: 14px; }
    .info-value { color: #0f172a; font-weight: 600; font-size: 14px; }
    .info-value strong { color: #b8860b; font-size: 16px; }

    .form-group { margin-bottom: 24px; }
    .form-label { display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 8px; }
    .form-label span { color: #ef4444; }

    .form-control { width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 12px; font-size: 14px; font-family: 'Inter', sans-serif; transition: all 0.2s; background-color: #ffffff; color: #0f172a; }
    .form-control:focus { outline: none; border-color: #b8860b; box-shadow: 0 0 0 3px rgba(184,134,11,0.1); }
    .form-control:read-only { background-color: #f1f5f9; cursor: not-allowed; }

    .form-actions { display: flex; gap: 16px; margin-top: 32px; padding-top: 24px; border-top: 1px solid #f1f5f9; }
    .btn { padding: 12px 24px; border-radius: 12px; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.2s; border: none; }
    .btn-primary { background: #b8860b; color: white; }
    .btn-primary:hover { background: #9a7009; transform: translateY(-2px); }
    .btn-secondary { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .btn-secondary:hover { background: #e2e8f0; }

    .alert-error { background: #fef2f2; color: #dc2626; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #dc2626; font-size: 14px; }

    small { display: block; margin-top: 6px; color: #94a3b8; font-size: 12px; }

    @media (max-width: 768px) {
        .form-container { padding: 20px; }
        .info-label { width: 110px; }
        .form-actions { flex-direction: column; }
        .btn { justify-content: center; }
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h3><i class="fas fa-edit"></i> Edit Bill of Material (BOM)</h3>
        <a href="{{ route('barang.bom.index', $barang->ID_BARANG) }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="info-barang">
        <div class="info-row">
            <span class="info-label">ID BARANG :</span>
            <span class="info-value"><strong>{{ $barang->ID_BARANG }}</strong></span>
        </div>
        <div class="info-row">
            <span class="info-label">NAMA BARANG :</span>
            <span class="info-value">{{ $barang->NAMA_BARANG }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">ID BAHAN :</span>
            <span class="info-value"><strong>{{ $bom->ID_BAHAN_BAKU }}</strong> - {{ $bom->JENIS }}</span>
        </div>
    </div>

    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('barang.bom.update', [$barang->ID_BARANG, $bom->ID_BAHAN_BAKU]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Jumlah <span>*</span></label>
            <input type="number" step="0.01" name="jumlah" class="form-control" value="{{ old('jumlah', $bom->JUMLAH) }}" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Perbarui Data
            </button>
            <a href="{{ route('barang.bom.index', $barang->ID_BARANG) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal / Kembali
            </a>
        </div>
    </form>
</div>
@endsection