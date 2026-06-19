@extends('layouts.app')

@section('content')

<style>
   .form-container {
        max-width: 900px; margin: 0 auto; background: #fff; border-radius: 20px;
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
    .form-row {
        display: grid; grid-template-columns: 1fr 1fr; gap: 16px;
    }
    .form-group { margin-bottom: 20px; }
    .form-label {
        font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block; color: #334155;
    }
    .form-label .required { color: #ef4444; }
    .form-label .optional { color: #94a3b8; font-weight: 400; font-size: 12px; }
    .form-control {
        width: 100%; padding: 10px 14px; font-size: 13px;
        border: 1px solid #cbd5e1; border-radius: 8px; background: #f8fafc;
        color: #000000; /* <--- Diubah di sini (Teks ketikan & dropdown jadi hitam pekat) */
    }
    .form-control:focus {
        border-color: #b8860b; outline: none; box-shadow: 0 0 0 3px rgba(184,134,11,0.1);
    }
    .form-control[readonly] {
        background: #e2e8f0; cursor: not-allowed;
        color: #000000; /* <--- Ditambahkan di sini (Teks input terkunci jadi hitam) */
    }
    
    /* Memaksa semua teks di dalam opsi pilihan dropdown berwarna hitam pekat */
    select.form-control option {
        color: #000000;
    }

    .computed-box {
        background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px;
        padding: 14px 16px; margin-bottom: 20px; font-size: 13px;
    }
    .computed-box p {
        margin: 0 0 4px 0; color: #166534;
        display: flex; justify-content: space-between;
    }
    .computed-box p:last-child { margin: 0; font-weight: 700; }
    .btn {
        padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
        border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
        transition: 0.2s;
    }
    .btn-primary { background: #b8860b; color: white; }
    .btn-primary:hover { background: #9a7009; transform: translateY(-1px); }
    .btn-secondary {
        background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;
    }
    .btn-secondary:hover { background: #e2e8f0; }
    .form-actions {
        display: flex; gap: 12px; margin-top: 24px;
        padding-top: 16px; border-top: 1px solid #f1f5f9;
    }
    .custom-file-upload {
        position: relative; display: inline-block; width: 100%;
    }
    .custom-file-upload input[type="file"] {
        position: absolute; left: 0; top: 0; opacity: 0;
        width: 100%; height: 100%; cursor: pointer; z-index: 2;
    }
    .file-upload-label {
        display: flex; align-items: center; justify-content: space-between;
        background-color: #ffffff; border: 1px solid #d4af37;
        border-radius: 0px; padding: 0.7rem 0.9rem;
        cursor: pointer; transition: 0.2s; font-size: 0.95rem;
        color: #b8860b; font-weight: 500;
    }
    .file-upload-label:hover {
        background-color: #fff8e7; border-color: #c9a03d;
    }
    .scan-preview {
        margin-top: 10px; max-width: 150px; display: none;
    }
    .scan-preview img {
        width: 100%; border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 5px; background: #f8fafc;
    }
    .checkbox-group {
        display: flex; align-items: center; gap: 10px; margin-top: 8px;
    }
    .checkbox-group input[type="checkbox"] {
        width: 16px; height: 16px; cursor: pointer;
    }
    .checkbox-group label {
        cursor: pointer; font-size: 13px; color: #dc2626;
    }
    .alert-error {
        background: #fef2f2; color: #dc2626; padding: 12px; border-radius: 12px; margin-bottom: 20px;
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
        <h3><i class="fas fa-edit"></i> Form Edit Pembelian</h3>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle"></i> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('pembelian.update', $pembelian->NO_INVOICE) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">No. Invoice</label>
                <input type="text" class="form-control" value="{{ $pembelian->NO_INVOICE }}" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal <span class="required">*</span></label>
                <input type="date" name="TANGGAL" class="form-control" value="{{ old('TANGGAL', $pembelian->TANGGAL) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Supplier <span class="required">*</span></label>
            <select name="ID_SUPPLIER" class="form-control" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $s)
                    <option value="{{ $s->ID_SUPPLIER }}"
                        {{ (old('id_supplier', $pembelian->ID_SUPPLIER) == $s->ID_SUPPLIER) ? 'selected' : '' }}>
                        {{ $s->NAMA_SUPPLIER }} ({{ $s->ID_SUPPLIER }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Jumlah Harga (Rp) <span class="required">*</span></label>
                <input type="number" name="JUMLAH_HARGA" id="jumlah_harga" class="form-control"
       value="{{ old('JUMLAH_HARGA', $pembelian->JUMLAH_HARGA) }}"
       min="0" step="1" required oninput="hitungOtomatis()">
            </div>
            <div class="form-group">
                <label class="form-label">Ongkos Kirim (Rp) <span class="optional">(opsional)</span></label>
                <input type="number" name="ONGKOS_KIRIM" id="ongkos_kirim" class="form-control"
       value="{{ old('ONGKOS_KIRIM', $pembelian->ONGKOS_KIRIM) }}" min="0" step="1" oninput="hitungOtomatis()">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Diskon (Rp) <span class="optional">(opsional)</span></label>
            <input type="number" name="DISKON" id="diskon" class="form-control"
       value="{{ old('DISKON', $pembelian->DISKON) }}" min="0" step="1" oninput="hitungOtomatis()">
        </div>

        <div class="computed-box" id="kalkulasiBox">
            <p><span>Jumlah Harga</span> <span id="show_jumlah">Rp {{ number_format($pembelian->JUMLAH_HARGA, 0, ',', '.') }}</span></p>
            <p><span>Nilai DPP (100/111)</span> <span id="show_dpp">Rp {{ number_format($pembelian->NILAI_DPP, 0, ',', '.') }}</span></p>
            <p><span>PPN 11%</span> <span id="show_ppn">Rp {{ number_format($pembelian->PPN, 0, ',', '.') }}</span></p>
            <p><span>Ongkos Kirim</span> <span id="show_ongkir">Rp {{ number_format($pembelian->ONGKOS_KIRIM, 0, ',', '.') }}</span></p>
            <p><span>Diskon</span> <span id="show_diskon">- Rp {{ number_format($pembelian->DISKON, 0, ',', '.') }}</span></p>
            <p><span>Total Invoice</span> <span id="show_total">Rp {{ number_format($pembelian->TOTAL_INVOICE, 0, ',', '.') }}</span></p>
        </div>

        <div class="form-group">
            <label class="form-label">Scan Nota (Maks 2MB)</label>

            @if(!empty($pembelian->SCAN_NOTA) && file_exists(public_path($pembelian->SCAN_NOTA)))
                <div style="margin-bottom:8px; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                    <img src="{{ asset($pembelian->SCAN_NOTA) }}" alt="Scan Nota" style="max-width:100px; border-radius:6px; border:1px solid #e2e8f0;">
                    <span style="font-size:12px; color:#64748b;">{{ basename($pembelian->SCAN_NOTA) }}</span>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" name="hapus_scan" id="hapus_scan" value="1">
                    <label for="hapus_scan">Hapus scan nota</label>
                </div>
            @else
                <div style="color:#94a3b8; font-size:13px; margin-bottom:6px;">Belum ada scan nota.</div>
            @endif

            <div class="custom-file-upload">
                <input type="file" name="scan_nota" accept=".jpg,.jpeg,.png" id="fileScanNota">
                <div class="file-upload-label" id="fileUploadLabel">
                    <span>Pilih File Scan Nota</span>
                    <span id="fileNameDisplay">Belum ada file</span>
                </div>
            </div>
            <div class="scan-preview" id="scanPreview">
                <img id="previewImg" src="#" alt="Preview">
            </div>
            <div class="help-text" style="font-size:0.7rem; color:#8b7a62; margin-top:0.4rem;">
                Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
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

    const dpp = jumlah * (100 / 111);
    const ppn = jumlah - dpp;
    const total = (dpp + ppn + ongkir) - diskon;

    document.getElementById('show_jumlah').textContent = formatRupiah(jumlah);
    document.getElementById('show_dpp').textContent = formatRupiah(dpp);
    document.getElementById('show_ppn').textContent = formatRupiah(ppn);
    document.getElementById('show_ongkir').textContent = formatRupiah(ongkir);
    document.getElementById('show_diskon').textContent = '- ' + formatRupiah(diskon);
    document.getElementById('show_total').textContent = formatRupiah(total);
}

document.addEventListener('DOMContentLoaded', function() {
    hitungOtomatis();
});

const fileInput = document.getElementById('fileScanNota');
const fileNameSpan = document.getElementById('fileNameDisplay');
const scanPreview = document.getElementById('scanPreview');
const previewImg = document.getElementById('previewImg');

if (fileInput) {
    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            fileNameSpan.textContent = fileInput.files[0].name;
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                scanPreview.style.display = 'block';
            };
            reader.readAsDataURL(fileInput.files[0]);
            const hapusScan = document.getElementById('hapus_scan');
            if (hapusScan) hapusScan.checked = false;
        } else {
            fileNameSpan.textContent = 'Belum ada file';
            scanPreview.style.display = 'none';
        }
    });
}

const hapusScan = document.getElementById('hapus_scan');
if (hapusScan) {
    hapusScan.addEventListener('change', function() {
        if (this.checked) {
            if (fileInput) fileInput.value = '';
            fileNameSpan.textContent = 'Belum ada file';
            scanPreview.style.display = 'none';
        }
    });
}
</script>

@endsection