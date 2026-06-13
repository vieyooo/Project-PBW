@extends('layouts.app')

@section('page-title', 'Tambah Petugas')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        padding: 24px 32px;
        border: 1px solid #e2e8f0;
    }
    .form-header {
        border-bottom: 2px dashed #f1f5f9;
        margin-bottom: 20px;
        padding-bottom: 12px;
    }
    .form-header h3 {
        font-size: 18px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }
    .form-header h3 i {
        color: #b8860b;
        background: rgba(184,134,11,0.1);
        padding: 8px;
        border-radius: 10px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        color: #334155;
        font-size: 13px;
    }
    .form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #cbd5e1;    /* border abu-abu */
    border-radius: 8px;
    background: #ffffff;           /* background putih, bukan transparan */
    color: #0f172a;                /* teks gelap */
    font-size: 13px;
}
.form-control:focus {
    border-color: #b8860b;
    outline: none;
    box-shadow: 0 0 0 3px rgba(184,134,11,0.1);
}
    
    .form-control[readonly] {
        background: #e2e8f0;
        cursor: not-allowed;
    }
    select.form-control {
        cursor: pointer;
    }
    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
    }
    .btn-primary {
        background: #b8860b;
        color: white;
    }
    .btn-primary:hover {
        background: #9a7009;
        transform: translateY(-1px);
    }
    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        text-decoration: none;
    }
    .btn-secondary:hover {
        background: #e2e8f0;
    }
    .alert-error {
        background: #fef2f2;
        color: #dc2626;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
    }
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    .form-hint {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }
    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .file-input-label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        cursor: pointer;
        font-size: 13px;
        color: #475569;
        transition: 0.2s;
    }
    .file-input-label:hover {
        background: #f1f5f9;
        border-color: #b8860b;
    }
    .file-input-label i {
        color: #b8860b;
    }
    .file-name {
        margin-top: 8px;
        font-size: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .file-name i {
        color: #22c55e;
    }
    .ttd-preview {
        margin-top: 10px;
        max-width: 150px;
        display: none;
    }
    .ttd-preview img {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 5px;
        background: #f8fafc;
    }
    @media (max-width: 640px) {
        .form-actions { flex-direction: column; }
        .btn { justify-content: center; }
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h3><i class="fas fa-user-plus"></i> Tambah Petugas Baru</h3>
    </div>
    @if ($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle"></i> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('petugas.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">ID Petugas</label>
            <input type="text" name="ID_PETUGAS" class="form-control" value="{{ $idOtomatis }}" readonly>
        </div>
        <div class="form-group">
            <label class="form-label">Nama Petugas <span style="color:red;">*</span></label>
            <input type="text" name="NAMA_PETUGAS" class="form-control" required autocomplete="off">
        </div>
        <div class="form-group">
            <label class="form-label">Jabatan <span style="color:red;">*</span></label>
            <select name="JABATAN" class="form-control" required>
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatanOptions as $jab)
                    <option value="{{ $jab }}">{{ $jab }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Tanda Tangan (Maks 2MB)</label>
            <div class="file-input-wrapper">
                <label class="file-input-label" for="ttd-input">
                    <i class="fas fa-upload"></i> Pilih File
                </label>
                <input type="file" name="ttd" id="ttd-input" accept=".jpg,.jpeg,.png" style="display: none;">
            </div>
            <div class="file-name" id="file-name" style="display: none;">
                <i class="fas fa-check-circle"></i> <span id="selected-file"></span>
            </div>
            <div class="ttd-preview" id="ttd-preview">
                <img id="preview-img" src="#" alt="Preview Tanda Tangan">
            </div>
            <div class="form-hint">
                <i class="fas fa-info-circle"></i> Format: JPG, JPEG, PNG. Maksimal 2MB.
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('petugas.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

<script>
    const ttdInput = document.getElementById('ttd-input');
    const fileNameSpan = document.getElementById('selected-file');
    const fileNameDiv = document.getElementById('file-name');
    const previewDiv = document.getElementById('ttd-preview');
    const previewImg = document.getElementById('preview-img');

    if (ttdInput) {
        ttdInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                fileNameSpan.textContent = file.name;
                fileNameDiv.style.display = 'block';
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImg.src = event.target.result;
                    previewDiv.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                fileNameDiv.style.display = 'none';
                previewDiv.style.display = 'none';
            }
        });
    }

    const fileLabel = document.querySelector('.file-input-label');
    if (fileLabel) {
        fileLabel.addEventListener('click', function() {
            if (ttdInput) ttdInput.click();
        });
    }
</script>
@endsection