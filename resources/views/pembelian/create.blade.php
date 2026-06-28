@extends('layouts.app')

@section('content')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: #f1f5f9;
        padding: 24px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
    }

    .form-container {
        max-width: 900px;
        width: 100%;
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 28px 36px 32px 36px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }

    .form-header {
        margin-bottom: 24px;
    }
    .form-header h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        display: block;
        font-weight: 600;
        font-size: 13px;
        color: #334155;
        margin-bottom: 5px;
    }
    .form-label .required {
        color: #ef4444;
    }
    .form-label .optional {
        color: #94a3b8;
        font-weight: 400;
        font-size: 12px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        color: #000000;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        transition: 0.2s;
        outline: none;
    }
    .form-control:focus {
        border-color: #b8860b;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(184,134,11,0.1);
    }
    .form-control[readonly] {
        background: #e2e8f0;
        color: #000000;
        cursor: not-allowed;
    }
    select.form-control {
        cursor: pointer;
    }
    .form-hint {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .computed-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 20px;
        font-size: 13px;
    }
    .computed-box p {
        margin: 0 0 4px 0;
        color: #166534;
        display: flex;
        justify-content: space-between;
    }
    .computed-box p:last-child {
        margin: 0;
        font-weight: 700;
    }

    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .file-input-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        color: #475569;
        transition: 0.2s;
    }
    .file-input-label:hover {
        background: #f1f5f9;
        border-color: #b8860b;
    }
    .file-name {
        margin-top: 8px;
        font-size: 12px;
        color: #64748b;
        text-align: center;
    }
    .scan-preview {
        margin-top: 10px;
        max-width: 150px;
        display: none;
    }
    .scan-preview img {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 5px;
        background: #f8fafc;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .btn {
        padding: 10px 28px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-primary {
        background: #b8860b;
        color: #fff;
        box-shadow: 0 4px 12px rgba(184,134,11,0.2);
    }
    .btn-primary:hover {
        background: #9a7009;
        transform: translateY(-1px);
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
        padding: 10px 14px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        border-left: 4px solid #dc2626;
    }

    @media (max-width:640px) {
        body { padding: 16px; }
        .form-container { padding: 20px; }
        .form-row { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column; }
        .btn { width: 100%; text-align: center; justify-content: center; }
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h3>Form Tambah Pembelian</h3>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle"></i> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('pembelian.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label">No. Invoice</label>
           <input type="text" name="NO_INVOICE" class="form-control" value="{{ $newNumber }}" readonly>
        </div>

        <div class="form-group">
            <label class="form-label">Tanggal <span class="required">*</span></label>
            <input type="date" name="TANGGAL" class="form-control" value="{{ old('TANGGAL', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Supplier <span class="required">*</span></label>
            <select name="ID_SUPPLIER" class="form-control" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $s)
                    <option value="{{ $s->ID_SUPPLIER }}" {{ old('id_supplier') == $s->ID_SUPPLIER ? 'selected' : '' }}>
                        {{ $s->NAMA_SUPPLIER }} ({{ $s->ID_SUPPLIER }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Jumlah Harga (Rp) <span class="required">*</span></label>
            <input type="number" name="JUMLAH_HARGA" id="jumlah_harga" class="form-control"
       placeholder="Contoh: 8000000" value="{{ old('JUMLAH_HARGA') }}"
       min="0" step="1" required oninput="hitungOtomatis()">
            <div class="form-hint">Harga barang sebelum ongkos kirim dan diskon.</div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Ongkos Kirim (Rp) <span class="optional">(opsional)</span></label>
                <input type="number" name="ONGKOS_KIRIM" id="ongkos_kirim" class="form-control"
       value="{{ old('ONGKOS_KIRIM', '0') }}" min="0" step="1" oninput="hitungOtomatis()">
            </div>
        </div>

        <div class="computed-box" id="kalkulasiBox" style="display:none;">
            <p><span>Jumlah Harga</span> <span id="show_jumlah">Rp 0</span></p>
            <p><span>Nilai DPP (100/111)</span> <span id="show_dpp">Rp 0</span></p>
            <p><span>PPN 11%</span> <span id="show_ppn">Rp 0</span></p>
            <p><span>Ongkos Kirim</span> <span id="show_ongkir">Rp 0</span></p>
            <p><span>Total Invoice</span> <span id="show_total">Rp 0</span></p>
        </div>

        <div class="form-group">
            <label class="form-label">Scan Nota (Maks 2MB)</label>
            <div class="file-input-wrapper">
                <label class="file-input-label" for="scan-nota-input">
                    <i class="fas fa-upload"></i> Pilih File Scan Nota
                </label>
                <input type="file" name="scan_nota" id="scan-nota-input" accept=".jpg,.jpeg,.png" style="display:none;">
            </div>
            <div class="file-name" id="file-name" style="display:none;">
                <i class="fas fa-check-circle"></i> <span id="selected-file"></span>
            </div>
            <div class="scan-preview" id="scan-preview">
                <img id="preview-img" src="#" alt="Preview Scan Nota">
            </div>
            <div class="form-hint">
                <i class="fas fa-info-circle"></i> Format: JPG, JPEG, PNG. Maksimal 2MB. File akan disimpan di folder img/scan_nota/
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
function formatRupiah(angka) {
    return 'Rp ' + Math.round(angka).toLocaleString('id-ID');
}

function hitungOtomatis() {
    const jumlah = parseFloat(document.getElementById('jumlah_harga').value) || 0;
    const ongkir = parseFloat(document.getElementById('ongkos_kirim').value) || 0;

    if (jumlah > 0) {
        const dpp = jumlah * (100 / 111);
        const ppn = jumlah - dpp;
        const total = dpp + ppn + ongkir;

        document.getElementById('show_jumlah').textContent = formatRupiah(jumlah);
        document.getElementById('show_dpp').textContent = formatRupiah(dpp);
        document.getElementById('show_ppn').textContent = formatRupiah(ppn);
        document.getElementById('show_ongkir').textContent = formatRupiah(ongkir);
        document.getElementById('show_total').textContent = formatRupiah(total);
        document.getElementById('kalkulasiBox').style.display = 'block';
    } else {
        document.getElementById('kalkulasiBox').style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    hitungOtomatis();
});

// File input handler
const scanInput = document.getElementById('scan-nota-input');
const fileNameSpan = document.getElementById('selected-file');
const fileNameDiv = document.getElementById('file-name');
const previewDiv = document.getElementById('scan-preview');
const previewImg = document.getElementById('preview-img');

if (scanInput) {
    scanInput.addEventListener('change', function(e) {
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

document.querySelector('.file-input-label').addEventListener('click', function() {
    if (scanInput) scanInput.click();
});
</script>

@endsection