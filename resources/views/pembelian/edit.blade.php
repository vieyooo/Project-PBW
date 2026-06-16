@extends('layouts.app')

@section('content')

<style>
    body, .form-control, .btn, .form-label, .computed-box, .section-divider {
        font-family: 'Inter', sans-serif;
    }
    .form-container {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 24px 32px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        width: 100%;
        max-width: 780px;
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
        background: rgba(184,134,11,0.1);
        padding: 8px;
        border-radius: 10px;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .form-group { margin-bottom: 20px; }
    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        font-size: 13px;
        color: #334155;
    }
    .form-label .required { color: #ef4444; }
    .form-label .optional { color: #94a3b8; font-weight: 400; font-size: 12px; }
    .form-control {
        width: 100%;
        padding: 10px 14px;
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
        box-shadow: 0 0 0 4px rgba(184,134,11,0.1);
    }
    .form-control[readonly] {
        background-color: #e2e8f0;
        color: #64748b;
        cursor: not-allowed;
        font-weight: 600;
        border-color: #e2e8f0;
    }
    select.form-control { cursor: pointer; }
    .form-hint { font-size: 11px; color: #94a3b8; margin-top: 4px; }
    .section-divider {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #b8860b;
        background: rgba(184,134,11,0.06);
        padding: 8px 14px;
        border-radius: 8px;
        margin-bottom: 16px;
        border-left: 3px solid #b8860b;
    }
    .computed-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 20px;
        font-size: 13px;
    }
    .computed-box p {
        margin: 0 0 6px 0;
        color: #166534;
        display: flex;
        justify-content: space-between;
        font-size: 13px;
    }
    .computed-box p:last-child { margin-bottom: 0; font-weight: 700; font-size: 14px; }
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
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
        font-family: 'Inter', sans-serif;
    }
    .btn-primary {
        background: #b8860b;
        color: white;
        box-shadow: 0 4px 12px rgba(184,134,11,0.2);
    }
    .btn-primary:hover {
        background: #9a7009;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(184,134,11,0.3);
    }
    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .btn-secondary:hover { background: #e2e8f0; color: #1e293b; }
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
    .file-input-label i { color: #b8860b; }
    .file-name {
        margin-top: 8px;
        font-size: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .file-name i { color: #22c55e; }
    .alert-error {
        background: #fef2f2;
        color: #dc2626;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        border-left: 4px solid #dc2626;
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
    @media (max-width: 640px) {
        .form-row { grid-template-columns: 1fr; }
        .form-container { padding: 20px; }
        .form-actions { flex-direction: column; }
        .btn { justify-content: center; }
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h3><i class="fas fa-file-invoice-dollar"></i> Form Edit Pembelian</h3>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('pembelian.update', $pembelian->NO_INVOICE) }}" method="POST"
          id="formPembelian" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="section-divider"><i class="fas fa-info-circle"></i> Informasi Pembelian</div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">No. Invoice</label>
                <input type="text" class="form-control" value="{{ $pembelian->NO_INVOICE }}" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal <span class="required">*</span></label>
                <input type="date" name="tanggal" class="form-control"
                       value="{{ old('tanggal', $pembelian->tanggal) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Supplier <span class="required">*</span></label>
            <select name="id_supplier" class="form-control" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $s)
                    <option value="{{ $s->id_supplier }}"
                        {{ (old('id_supplier', $pembelian->id_supplier) == $s->id_supplier) ? 'selected' : '' }}>
                        {{ $s->nama_supplier }} ({{ $s->id_supplier }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="section-divider"><i class="fas fa-money-bill-wave"></i> Nilai Harga</div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Jumlah Harga (Rp) <span class="required">*</span></label>
                <input type="number" name="jumlah_harga" id="jumlah_harga" class="form-control"
                       value="{{ old('jumlah_harga', $pembelian->jumlah_harga) }}"
                       min="0" step="1" required oninput="hitungOtomatis()">
                <p class="form-hint">Harga barang sebelum ongkos kirim dan diskon.</p>
            </div>
            <div class="form-group">
                <label class="form-label">Ongkos Kirim (Rp) <span class="optional">(opsional)</span></label>
                <input type="number" name="ongkos_kirim" id="ongkos_kirim" class="form-control"
                       value="{{ old('ongkos_kirim', $pembelian->ongkos_kirim) }}"
                       min="0" step="1" oninput="hitungOtomatis()">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Diskon (Rp) <span class="optional">(opsional)</span></label>
                <input type="number" name="diskon" id="diskon" class="form-control"
                       value="{{ old('diskon', $pembelian->diskon) }}"
                       min="0" step="1" oninput="hitungOtomatis()">
            </div>
        </div>

        <!-- KALKULASI OTOMATIS -->
        <div class="computed-box" id="kalkulasiBox">
            <p><span>Jumlah Harga</span>      <span id="show_jumlah">Rp {{ number_format($pembelian->jumlah_harga, 0, ',', '.') }}</span></p>
            <p><span>Nilai DPP (100/111)</span><span id="show_dpp">Rp {{ number_format($pembelian->nilai_dpp, 0, ',', '.') }}</span></p>
            <p><span>PPN 11%</span>            <span id="show_ppn">Rp {{ number_format($pembelian->ppn, 0, ',', '.') }}</span></p>
            <p><span>Ongkos Kirim</span>       <span id="show_ongkir">Rp {{ number_format($pembelian->ongkos_kirim, 0, ',', '.') }}</span></p>
            <p><span>Diskon</span>             <span id="show_diskon">- Rp {{ number_format($pembelian->diskon, 0, ',', '.') }}</span></p>
            <p><span>Total Invoice</span>      <span id="show_total">Rp {{ number_format($pembelian->total_invoice, 0, ',', '.') }}</span></p>
        </div>

        <div class="section-divider"><i class="fas fa-image"></i> Upload Scan Nota</div>
        <div class="form-group">
            <label class="form-label">Scan Nota (Maks 2MB)</label>
            <div class="file-input-wrapper">
                <label class="file-input-label" for="scan-nota-input">
                    <i class="fas fa-upload"></i> Pilih File Scan Nota
                </label>
                <input type="file" name="scan_nota" id="scan-nota-input" accept=".jpg,.jpeg,.png" style="display: none;">
            </div>
            <div class="file-name" id="file-name" style="display: none;">
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
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Perbarui Data
            </button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal / Kembali
            </a>
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
    const diskon = parseFloat(document.getElementById('diskon').value) || 0;

    const dpp   = jumlah * (100 / 111);
    const ppn   = jumlah - dpp;
    const total = (dpp + ppn + ongkir) - diskon;

    document.getElementById('show_jumlah').textContent = formatRupiah(jumlah);
    document.getElementById('show_dpp').textContent    = formatRupiah(dpp);
    document.getElementById('show_ppn').textContent    = formatRupiah(ppn);
    document.getElementById('show_ongkir').textContent = formatRupiah(ongkir);
    document.getElementById('show_diskon').textContent = '- ' + formatRupiah(diskon);
    document.getElementById('show_total').textContent  = formatRupiah(total);
}

document.getElementById('scan-nota-input').addEventListener('change', function() {
    const fileNameEl = document.getElementById('file-name');
    const selectedFileEl = document.getElementById('selected-file');
    const scanPreview = document.getElementById('scan-preview');
    const previewImg = document.getElementById('preview-img');

    if (this.files && this.files[0]) {
        fileNameEl.style.display = 'flex';
        selectedFileEl.textContent = this.files[0].name;

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            scanPreview.style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>

@endsection