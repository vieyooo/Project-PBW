@extends('layouts.app')

@section('content')

<style>
    .form-container {
        max-width: 600px; margin: 0 auto; background: #fff; border-radius: 20px;
        border: 1px solid #e2e8f0; padding: 24px 32px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }
    .form-header {
        border-bottom: 2px dashed #f1f5f9; margin-bottom: 20px; padding-bottom: 12px;
    }
    .form-header h3 {
        font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 10px;
        margin: 0;
    }
    .form-header h3 i {
        color: #b8860b; background: rgba(184,134,11,0.1); padding: 8px; border-radius: 10px;
    }
    .form-group { margin-bottom: 20px; }
    .form-label {
        font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block; color: #334155;
    }
    .form-control {
        width: 100%; padding: 10px 14px; font-size: 13px;
        border: 1px solid #cbd5e1; border-radius: 8px; background: #f8fafc;
    }
    .form-control:focus {
        border-color: #b8860b; outline: none; box-shadow: 0 0 0 3px rgba(184,134,11,0.1);
    }
    .form-control[readonly] {
        background: #e2e8f0; cursor: not-allowed;
    }
    .btn {
        padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
        border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
        transition: 0.2s;
    }
    .btn-primary {
        background: #b8860b; color: white;
    }
    .btn-primary:hover {
        background: #9a7009; transform: translateY(-1px);
    }
    .btn-secondary {
        background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;
    }
    .btn-secondary:hover {
        background: #e2e8f0;
    }
    .alert-error {
        background: #fef2f2; color: #dc2626; padding: 12px; border-radius: 12px; margin-bottom: 20px;
    }
    .form-actions {
        display: flex; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1px solid #f1f5f9;
    }
    .form-hint {
        font-size: 11px; color: #94a3b8; margin-top: 4px;
    }
    @media (max-width: 640px) {
        .form-actions { flex-direction: column; }
        .btn { justify-content: center; }
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h3><i class="fas fa-cart-plus"></i> Tambah Bahan Baku ke Pembelian</h3>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle"></i> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('pembelian.detail.store', $noInvoice) }}">
        @csrf

        <div class="form-group">
            <label class="form-label">No. Invoice</label>
            <input type="text" class="form-control" value="{{ $noInvoice }}" readonly>
        </div>

        <div class="form-group">
            <label class="form-label">Pilih Bahan Baku <span style="color:red;">*</span></label>
            <select name="id_bahan" class="form-control" required>
                <option value="">-- Pilih Bahan Baku --</option>
                @foreach($bahanBakus as $b)
                    <option value="{{ $b->id_bahan_baku }}"
                        {{ old('id_bahan') == $b->id_bahan_baku ? 'selected' : '' }}>
                        {{ $b->id_bahan_baku }} - {{ $b->jenis }} ({{ $b->kode }}) - Stok: {{ $b->stok }} {{ $b->satuan }}
                    </option>
                @endforeach
            </select>
            @if($bahanBakus->isEmpty())
                <p class="form-hint" style="color:#dc2626;">Semua bahan baku sudah ditambahkan ke invoice ini.</p>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label">Qty <span style="color:red;">*</span></label>
            <input type="number" name="qty" class="form-control" required min="1"
                   value="{{ old('qty', 1) }}">
            <p class="form-hint">Jumlah bahan baku yang dibeli.</p>
        </div>

        <div class="form-group">
            <label class="form-label">Harga Jual (Rp) <span style="color:red;">*</span></label>
            <input type="number" name="harga_jual" class="form-control" required min="0" step="1000"
                   placeholder="Contoh: 500000" value="{{ old('harga_jual') }}">
            <p class="form-hint">Harga per unit dari supplier.</p>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('pembelian.show', $noInvoice) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection