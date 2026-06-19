@extends('layouts.app')

@section('content')

<style>
    .detail-container {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #f1f5f9;
        flex-wrap: wrap;
        gap: 16px;
    }
    .detail-header h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        margin: 0;
    }
    .detail-header h3 i {
        color: #b8860b;
        margin-right: 12px;
        font-size: 24px;
        background: rgba(184, 134, 11, 0.1);
        padding: 10px;
        border-radius: 12px;
    }
    .btn-back { background: #f1f5f9; color: #475569; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; }
    .btn-back:hover { background: #e2e8f0; }
    .header-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    .info-pembelian { background: #fef3c7; padding: 20px; border-radius: 12px; margin-bottom: 16px; }
    .info-row { margin-bottom: 10px; }
    .info-label { font-weight: 600; color: #64748b; width: 140px; display: inline-block; font-size: 13px; }
    .info-value { color: #0f172a; font-size: 14px; }
    .section-title { font-size: 15px; font-weight: 700; margin: 24px 0 12px 0; display: flex; justify-content: space-between; align-items: center; }
    .section-title span { color: #b8860b; display: flex; align-items: center; gap: 8px; }
    .btn-primary { background: #b8860b; color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2); }
    .btn-primary:hover { background: #9a7009; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(184, 134, 11, 0.3); color: white; }
    .table-responsive { overflow-x: auto; border-radius: 12px; border: 1px solid #e2e8f0; }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .data-table thead th {
        background-color: #b8870bf2;
        color: #f1f5f9;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }
    .data-table tbody td {
        padding: 12px 16px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .data-table tbody tr:hover { background-color: #f8fafc; }
    .total-row {
        background: #b8860b !important;
        color: white !important;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .total-row td {
        color: white !important;
        border-bottom: none !important;
    }
    .total-amount { font-size: 15px; }
    .action-buttons { display: flex; flex-direction: column; gap: 6px; align-items: center; }
    .btn-action { width: 100%; justify-content: center; padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease; }
    .btn-edit { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .btn-edit:hover { background: #3b82f6; color: white; border-color: #3b82f6; }
    .btn-delete { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .btn-delete:hover { background: #ef4444; color: white; border-color: #ef4444; }
    .empty-state { text-align: center; padding: 40px; color: #94a3b8; }
    .empty-state i { font-size: 40px; color: #cbd5e1; margin-bottom: 12px; display: block; }
    @media (max-width:768px){
        .info-label { width:100%; display:block; margin-bottom:4px; }
        .data-table th, .data-table td { padding:8px 12px; }
        .section-title { flex-direction: column; align-items: flex-start; gap: 12px; }
        .btn-primary { width: 100%; justify-content: center; }
        .header-actions { width: 100%; justify-content: space-between; }
    }
</style>

<div class="detail-container">
    <div class="detail-header">
        <h3><i class="fas fa-shopping-cart"></i> Detail Pembelian</h3>
        <div class="header-actions">
            <a href="{{ route('pembelian.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="info-pembelian">
        <div class="info-row">
            <span class="info-label">NO. INVOICE</span>
            <span class="info-value"><strong>{{ $pembelian->NO_INVOICE }}</strong></span>
        </div>
        <div class="info-row">
            <span class="info-label">TANGGAL</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($pembelian->TANGGAL)->format('d M Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">SUPPLIER</span>
            <span class="info-value">{{ $pembelian->supplier->NAMA_SUPPLIER ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">TOTAL INVOICE</span>
            <span class="info-value">Rp {{ number_format($pembelian->TOTAL_INVOICE, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="section-title">
        <span><i class="fas fa-list-ul"></i> DAFTAR BAHAN BAKU YANG DIBELI</span>
        <a href="{{ route('pembelian.detail.create', $pembelian->NO_INVOICE) }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Bahan Baku
        </a>
    </div>

    @if(isset($details) && $details->count() > 0)
        @php $grandTotal = 0; @endphp
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">ID Bahan Baku</th>
                        <th style="width: 10%;">Kode</th>
                        <th style="width: 20%;">Jenis</th>
                        <th style="width: 10%;">Satuan</th>
                        <th style="width: 5%; text-align: center;">Qty</th>
                        <th style="width: 15%;">Harga Jual</th>
                        <th style="width: 15%;">Subtotal</th>
                        <th style="width: 10%; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $row)
                        @php
                            // NAMA KOLOM DIUBAH MENJADI HURUF BESAR: QTY & HARGA_JUAL
                            $subtotal = $row->QTY * $row->HARGA_JUAL;
                            $grandTotal += $subtotal;
                        @endphp
                        <tr>
                            {{-- NAMA KOLOM DIUBAH MENJADI HURUF BESAR: ID_BAHAN_BAKU --}}
                            <td><strong>{{ $row->ID_BAHAN_BAKU }}</strong></td>
                            
                            {{-- MENGAMBIL DARI RELASI BAHAN BAKU JIKA ADA (KODE, JENIS, SATUAN) --}}
                            <td>{{ $row->bahanBaku->KODE ?? $row->KODE ?? '-' }}</td>
                            <td>{{ $row->bahanBaku->JENIS ?? $row->JENIS ?? '-' }}</td>
                            <td>{{ $row->bahanBaku->SATUAN ?? $row->SATUAN ?? '-' }}</td>
                            
                            {{-- NAMA KOLOM DIUBAH MENJADI HURUF BESAR: QTY & HARGA_JUAL --}}
                            <td style="text-align: center;">{{ number_format($row->QTY, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($row->HARGA_JUAL, 0, ',', '.') }}</td>
                            <td><strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('pembelian.detail.edit', [$pembelian->NO_INVOICE, $row->ID_BAHAN_BAKU]) }}"
                                       class="btn-action btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('pembelian.detail.destroy', [$pembelian->NO_INVOICE, $row->ID_BAHAN_BAKU]) }}"
                                          method="POST" style="width:100%;"
                                          onsubmit="return confirm('Yakin hapus item ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="6" style="text-align:right;">TOTAL NILAI DETAIL :</td>
                        <td colspan="2" class="total-amount">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h4>Belum Ada Bahan Baku</h4>
            <p>Silakan klik tombol "Tambah Bahan Baku" untuk menambahkan rincian pembelian.</p>
        </div>
    @endif
</div>

@endsection