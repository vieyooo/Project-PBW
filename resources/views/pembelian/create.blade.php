@extends('layouts.app')

@section('content')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f8f5f0;
        font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        padding: 2rem 1.5rem;
        color: #2c2418;
    }

    .form-container {
        max-width: 760px;
        margin: 0 auto;
        background: #ffffff;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.02);
        border-radius: 0;
        overflow: hidden;
    }

    .form-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #f0e6d2;
        background: #ffffff;
    }

    .form-header h2 {
        font-size: 1.6rem;
        font-weight: 600;
        color: #b8860b;
        letter-spacing: -0.2px;
        margin: 0;
    }

    .form-body {
        padding: 1.8rem 2rem 2rem 2rem;
    }

    .form-group {
        margin-bottom: 1.6rem;
        display: flex;
        flex-direction: column;
    }

    .form-row {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .form-row .form-group {
        flex: 1;
        min-width: 180px;
    }

    label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #5e4b2b;
        margin-bottom: 0.45rem;
        letter-spacing: 0.3px;
    }

    label .required-star {
        color: #d4af37;
        margin-left: 2px;
    }

    input, select {
        width: 100%;
        padding: 0.7rem 0.9rem;
        font-size: 0.95rem;
        font-family: inherit;
        border: 1px solid #e2d5bd;
        border-radius: 0px;
        background-color: #ffffff;
        transition: 0.2s;
        color: #2c2418;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #d4af37;
        box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
    }

    .custom-file-upload {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .custom-file-upload input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        z-index: 2;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #ffffff;
        border: 1px solid #d4af37;
        border-radius: 0px;
        padding: 0.7rem 0.9rem;
        cursor: pointer;
        transition: 0.2s;
        font-size: 0.95rem;
        color: #b8860b;
        font-weight: 500;
    }

    .file-upload-label span:first-child {
        color: #b8860b;
    }

    .file-upload-label span:last-child {
        color: #8b7a62;
        font-size: 0.85rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 60%;
    }

    .file-upload-label:hover {
        background-color: #fff8e7;
        border-color: #c9a03d;
    }

    .help-text {
        font-size: 0.7rem;
        color: #8b7a62;
        margin-top: 0.4rem;
        line-height: 1.4;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .btn-primary {
        background-color: #d4af37;
        border: none;
        padding: 0.75rem 1.8rem;
        border-radius: 0px;
        font-weight: 700;
        font-size: 0.9rem;
        color: #2c2418;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .btn-primary:hover {
        background-color: #b38f2a;
        color: white;
    }

    .btn-secondary {
        background-color: transparent;
        border: 1px solid #d4af37;
        padding: 0.75rem 1.8rem;
        border-radius: 0px;
        font-weight: 600;
        font-size: 0.9rem;
        color: #b8860b;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-secondary:hover {
        background-color: #fff8e7;
        border-color: #c9a03d;
    }

    @media (max-width: 600px) {
        .form-body { padding: 1.5rem; }
        .form-header { padding: 1rem 1.5rem; }
        .form-header h2 { font-size: 1.4rem; }
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h2>Tambah Pembelian</h2>
    </div>
    <div class="form-body">
        <form id="formTambahPembelian" method="POST" action="{{ route('pembelian.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Baris No Invoice & Tanggal -->
            <div class="form-row">
                <div class="form-group">
                    <label>No. Invoice</label>
                    <input type="text" name="NO_INVOICE" value="{{ old('NO_INVOICE', 'PO-6012') }}"
                           placeholder="No. Invoice" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Tanggal <span class="required-star">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>
            </div>

            <!-- Supplier -->
            <div class="form-group">
                <label>Supplier <span class="required-star">*</span></label>
                <select name="supplier" required>
                    <option value="" disabled selected>-- Pilih Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id_supplier }}"
                            {{ old('supplier') == $supplier->id_supplier ? 'selected' : '' }}>
                            {{ $supplier->id_supplier }} - {{ $supplier->nama_supplier }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jumlah Harga -->
            <div class="form-group">
                <label>Jumlah Harga (Rp) <span class="required-star">*</span></label>
                <input type="text" name="jumlah_harga" placeholder="Contoh: 8000000"
                       value="{{ old('jumlah_harga') }}" inputmode="numeric">
                <div class="help-text">Harga barang sebelum ongkos kirim dan diskon.</div>
            </div>

            <!-- Ongkos Kirim & Diskon -->
            <div class="form-row">
                <div class="form-group">
                    <label>Ongkos Kirim (Rp) (opsional)</label>
                    <input type="text" name="ongkos_kirim" placeholder="0"
                           value="{{ old('ongkos_kirim', '0') }}" inputmode="numeric">
                </div>
                <div class="form-group">
                    <label>Diskon (Rp) (opsional)</label>
                    <input type="text" name="diskon" placeholder="0"
                           value="{{ old('diskon', '0') }}" inputmode="numeric">
                </div>
            </div>

            <!-- Upload Scan Nota -->
            <div class="form-group">
                <label>Scan Nota (Maks 2MB)</label>
                <div class="custom-file-upload">
                    <input type="file" name="scan_nota" accept=".jpg,.jpeg,.png" id="fileScanNota">
                    <div class="file-upload-label" id="fileUploadLabel">
                        <span>Pilih File Scan Nota</span>
                        <span id="fileNameDisplay">Belum ada file</span>
                    </div>
                </div>
                <div class="help-text">
                    Format: JPG, JPEG, PNG. Maksimal 2MB. File akan disimpan di folder img/scan_nota/
                </div>
            </div>

            <!-- Tombol aksi -->
            <div class="button-group">
                <button type="submit" class="btn-primary">Simpan Data</button>
                <button type="button" class="btn-secondary" id="btnBatal">Batal / Kembali</button>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    const fileInput = document.getElementById('fileScanNota');
    const fileNameSpan = document.getElementById('fileNameDisplay');

    if (fileInput && fileNameSpan) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                fileNameSpan.textContent = fileInput.files[0].name;
            } else {
                fileNameSpan.textContent = 'Belum ada file';
            }
        });
    }

    const btnBatal = document.getElementById('btnBatal');
    if (btnBatal) {
        btnBatal.addEventListener('click', function() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                const form = document.getElementById('formTambahPembelian');
                if (form) form.reset();
                const invoiceField = document.querySelector('input[name="NO_INVOICE"]');
                const tglField = document.querySelector('input[name="tanggal"]');
                const ongkirField = document.querySelector('input[name="ongkos_kirim"]');
                const diskonField = document.querySelector('input[name="diskon"]');
                if (invoiceField) invoiceField.value = 'PO-6012';
                if (tglField) tglField.value = '{{ date("Y-m-d") }}';
                if (ongkirField) ongkirField.value = '0';
                if (diskonField) diskonField.value = '0';
                if (fileNameSpan) fileNameSpan.textContent = 'Belum ada file';
                if (fileInput) fileInput.value = '';
                alert('Form telah direset.');
            }
        });
    }

    const form = document.getElementById('formTambahPembelian');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                const maxSize = 2 * 1024 * 1024;
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Harap unggah file JPG, JPEG, atau PNG.');
                    event.preventDefault();
                    return false;
                }
                if (file.size > maxSize) {
                    alert('Ukuran file melebihi 2MB. Silakan pilih file yang lebih kecil.');
                    event.preventDefault();
                    return false;
                }
            }

            const jumlahHarga = document.querySelector('input[name="jumlah_harga"]');
            if (jumlahHarga && !jumlahHarga.value.trim()) {
                alert('Jumlah Harga harus diisi.');
                event.preventDefault();
                return false;
            }

            const supplierSelect = document.querySelector('select[name="supplier"]');
            if (supplierSelect && (!supplierSelect.value || supplierSelect.value === '')) {
                alert('Silakan pilih Supplier terlebih dahulu.');
                event.preventDefault();
                return false;
            }
        });
    }
})();
</script>

@endsection