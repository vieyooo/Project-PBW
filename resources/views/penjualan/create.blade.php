@extends('layouts.app')

@section('page-title', 'Tambah Penjualan')

@section('content')
<style>
    .form-container { background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 24px 32px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); width: 100%; max-width: 900px; margin: 0 auto; }
    .form-header { margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px dashed #f1f5f9; }
    .form-header h3 { font-size: 18px; font-weight: 700; color: #0f172a; display: flex; align-items: center; margin: 0; }
    .form-header h3 i { color: #b8860b; margin-right: 10px; font-size: 22px; background: rgba(184, 134, 11, 0.1); padding: 8px; border-radius: 10px; }
    .form-group { margin-bottom: 16px; }
    .form-label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #334155; }
    .form-label span { color: #ef4444; }
    .form-control, .form-select { width: 100%; padding: 10px 14px; font-family: 'Inter', sans-serif; font-size: 13px; color: #0f172a; background-color: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; transition: all 0.2s; outline: none; }
    .form-control:focus, .form-select:focus { border-color: #b8860b; background-color: #ffffff; box-shadow: 0 0 0 4px rgba(184, 134, 11, 0.1); }
    .form-control:read-only { background-color: #e2e8f0; color: #64748b; cursor: not-allowed; font-weight: 600; border-color: #e2e8f0; }
    textarea.form-control { min-height: 60px; resize: vertical; }
    .form-row { display: flex; gap: 16px; }
    .form-col { flex: 1; }
    .form-actions { display: flex; gap: 12px; margin-top: 20px; padding-top: 16px; border-top: 1px solid #f1f5f9; justify-content: flex-end; }
    .btn { padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.3s ease; border: none; }
    .btn-primary { background: #b8860b; color: white; box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2); }
    .btn-primary:hover { background: #9a7009; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(184, 134, 11, 0.3); }
    .btn-secondary { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .btn-secondary:hover { background: #e2e8f0; color: #1e293b; }
    .alert-error { background: #fef2f2; color: #dc2626; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border-left: 4px solid #dc2626; }
    .input-group { display: flex; align-items: center; }
    .input-group-text { background: #e2e8f0; padding: 10px 14px; border: 1px solid #cbd5e1; border-right: none; border-radius: 8px 0 0 8px; font-size: 13px; font-weight: 600; color: #475569; }
    .input-group .form-control { border-radius: 0 8px 8px 0; }
    @media (max-width: 768px) { .form-row { flex-direction: column; gap: 0; } .form-actions { flex-direction: column; } .btn { justify-content: center; width: 100%; } }
</style>

<div class="form-container">
    <div class="form-header">
        <h3><i class="fas fa-file-invoice-dollar"></i> Form Tambah Penjualan</h3>
    </div>

    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">ID Penjualan</label>
                    <input type="text" name="ID_PENJUALAN" class="form-control" value="{{ $idOtomatis }}" readonly>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Tanggal Transaksi <span>*</span></label>
                    <input type="date" name="TANGGAL" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Jatuh Tempo <span>*</span></label>
                    <input type="date" name="JATUH_TEMPO" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Petugas / Sales <span>*</span></label>
                    <select name="ID_PETUGAS" class="form-select" required>
                        <option value="">-- Pilih Petugas --</option>
                        @foreach($petugas as $p)
                            <option value="{{ $p->ID_PETUGAS }}">{{ $p->ID_PETUGAS }} - {{ $p->NAMA_PETUGAS }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Pelanggan / Customer <span>*</span></label>
                    <select name="ID_PELANGGAN" class="form-select" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggan as $pl)
                            <option value="{{ $pl->ID_PELANGGAN }}">{{ $pl->ID_PELANGGAN }} - {{ $pl->NAMA_PELANGGAN }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Subtotal <span>*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="SUBTOTAL" id="input_subtotal" class="form-control" placeholder="0" required min="0" step="0.01">
                    </div>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Diskon</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="DISKON" id="input_diskon" class="form-control" placeholder="0" value="0" min="0" step="0.01">
                    </div>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Total Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="total" id="input_total" class="form-control" placeholder="0" readonly style="background-color: #e2e8f0;">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col" style="flex: 0.33;">
                <div class="form-group">
                    <label class="form-label">Sisa Tagihan <span>*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="SISA_TAGIHAN" class="form-control" placeholder="0" required min="0" step="0.01">
                    </div>
                </div>
            </div>
            <div class="form-col" style="flex: 0.67;">
                <div class="form-group">
                    <label class="form-label">Pesan / Keterangan Tambahan</label>
                    <textarea name="PESAN" class="form-control" rows="2" placeholder="Tuliskan keterangan detail pesanan..."></textarea>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal / Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Data
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subtotalInput = document.getElementById('input_subtotal');
        const diskonInput = document.getElementById('input_diskon');
        const totalInput = document.getElementById('input_total');

        function calculateTotal() {
            const subtotal = parseFloat(subtotalInput.value) || 0;
            const diskon = parseFloat(diskonInput.value) || 0;
            const total = Math.max(0, subtotal - diskon);
            totalInput.value = total;
        }

        subtotalInput.addEventListener('input', calculateTotal);
        diskonInput.addEventListener('input', calculateTotal);
    });
</script>
@endsection