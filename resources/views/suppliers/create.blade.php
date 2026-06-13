@extends('layouts.app')

@section('page-title', 'Tambah Supplier')

@section('content')
<style>
    .form-container {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 24px 32px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
    }
    .form-header {
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 2px dashed #f1f5f9;
    }
    .form-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        margin: 0;
    }
    .form-header h3 i {
        color: #b8860b;
        margin-right: 10px;
        font-size: 22px;
        background: rgba(184, 134, 11, 0.1);
        padding: 8px;
        border-radius: 10px;
    }
    .form-group { margin-bottom: 16px; }
    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        font-size: 13px;
        color: #334155;
    }
    .form-label span { color: #ef4444; }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        color: #0f172a;
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        transition: all 0.2s;
        outline: none;
        box-sizing: border-box;
    }
    .form-control:focus {
        border-color: #b8860b;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(184, 134, 11, 0.1);
    }
    .form-control:read-only {
        background-color: #e2e8f0;
        color: #64748b;
        cursor: not-allowed;
        font-weight: 600;
        border-color: #e2e8f0;
    }
    textarea.form-control { min-height: 60px; resize: vertical; }
    .form-row { display: flex; gap: 16px; }
    .form-col { flex: 1; }
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
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
    .btn-secondary:hover { background: #e2e8f0; color: #1e293b; }
    .alert-error {
        background: #fef2f2;
        color: #dc2626;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        border-left: 4px solid #dc2626;
    }
    @media (max-width: 768px) {
        .form-container { padding: 20px; border-radius: 16px; }
        .form-row { flex-direction: column; gap: 0; }
        .form-actions { flex-direction: column; }
        .btn { justify-content: center; }
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h3><i class="fas fa-plus-circle"></i> Form Tambah Supplier</h3>
    </div>

    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">ID Supplier</label>
                    <input type="text" class="form-control" value="{{ $id_otomatis }}" readonly>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Penanggung Jawab (PIC) <span>*</span></label>
                    <input type="text" name="pic_supplier" class="form-control" placeholder="Nama Penanggung Jawab" required autocomplete="off" value="{{ old('pic_supplier') }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Nama Supplier <span>*</span></label>
            <input type="text" name="nama_supplier" class="form-control" placeholder="Contoh: PT. Indo Leather Prima" required autocomplete="off" value="{{ old('nama_supplier') }}">
        </div>

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">No. Telp <span>*</span></label>
                    <input type="text" name="no_telp" class="form-control" placeholder="Contoh: (021) 6123456" required autocomplete="off" value="{{ old('no_telp') }}">
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Fax (Opsional)</label>
                    <input type="text" name="fax" class="form-control" placeholder="Contoh: (021) 6123457" autocomplete="off" value="{{ old('fax') }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Alamat Lengkap <span>*</span></label>
            <textarea name="alamat" class="form-control" placeholder="Masukkan alamat lengkap supplier..." required>{{ old('alamat') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Data
            </button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal / Kembali
            </a>
        </div>
    </form>
</div>
@endsection