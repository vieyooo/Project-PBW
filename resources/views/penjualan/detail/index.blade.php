@extends('layouts.app')
@section('page-title', 'Detail Penjualan')

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

    .btn-cetak { background: #1e293b; color: #fff; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; }
    .btn-cetak:hover { background: #0f172a; color: white; }
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
        border: 1px #0f172a;
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
    .data-table tbody tr:hover {
        background-color: #f8fafc;
    }
    
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
    .total-amount {
        font-size: 15px;
    }
    
    .action-buttons { display: flex; flex-direction: column; gap: 6px; align-items: center; }
    .btn-action { width: 100%; justify-content: center; padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease; }
    .btn-edit { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .btn-edit:hover { background: #3b82f6; color: white; }
    .btn-delete { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .btn-delete:hover { background: #ef4444; color: white; border-color: #ef4444; }

    .empty-state { text-align: center; padding: 40px; color: #94a3b8; }
    .empty-state i { font-size: 40px; color: #cbd5e1; margin-bottom: 12px; display: block;}
    
    @media (max-width:768px){ 
        .info-label{ width:100%; display:block; margin-bottom:4px; } 
        .data-table th, .data-table td{ padding:8px 12px; } 
        .section-title { flex-direction: column; align-items: flex-start; gap: 12px; }
        .btn-primary { width: 100%; justify-content: center; }
        .header-actions { width: 100%; justify-content: space-between; }
        .btn-cetak, .btn-back { flex: 1; justify-content: center; margin: 0; }
    }
</style>

<div class="detail-container">
    <div class="detail-header">
        <h3><i class="fas fa-shopping-bag"></i> Detail Penjualan</h3>
        <div class="header-actions">
           <a href="{{ route('detailpenjualan.cetak', $penjualan->ID_PENJUALAN) }}" target="_blank" class="btn-cetak">
    <i class="fas fa-print"></i> Cetak Invoice
</a>
            <a href="{{ route('penjualan.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <div class="info-pembelian">
        <div class="info-row"><span class="info-label">ID PENJUALAN</span><span class="info-value"><strong>{{ $penjualan->ID_PENJUALAN }}</strong></span></div>
        <div class="info-row"><span class="info-label">TANGGAL</span><span class="info-value">{{ date('d M Y', strtotime($penjualan->TANGGAL)) }}</span></div>
        <div class="info-row"><span class="info-label">PELANGGAN</span><span class="info-value">{{ $penjualan->pelanggan->NAMA_PELANGGAN ?? '-' }}</span></div>
        <div class="info-row"><span class="info-label">PETUGAS</span><span class="info-value">{{ $penjualan->petugas->NAMA_PETUGAS ?? '-' }}</span></div>
        <div class="info-row"><span class="info-label">PESAN</span><span class="info-value">{{ $penjualan->PESAN ?? '-' }}</span></div>
    </div>
    
    <div class="section-title">
        <span><i class="fas fa-list-ul"></i> DAFTAR BARANG YANG DIJUAL</span>
        <a href="{{ route('detailpenjualan.create', ['id' => $penjualan->ID_PENJUALAN]) }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah Barang</a>
    </div>
    
    @if(isset($detail) && $detail->count() > 0)
        @php $grand_total = 0; @endphp
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">ID Barang</th>
                        <th style="width: 30%;">Nama Barang</th>
                        <th style="width: 10%; text-align: center;">Qty</th>
                        <th style="width: 15%;">Harga Satuan</th>
                        <th style="width: 20%;">Subtotal</th>
                        <th style="width: 10%; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($detail as $row)
                    @php
                        $grand_total += $row->JUMLAH;
                        $harga_satuan = ($row->QTY > 0) ? ($row->JUMLAH / $row->QTY) : 0;
                    @endphp
                    <tr>
                        <td><strong>{{ $row->ID_BARANG }}</strong></td>
                        <td>{{ $row->barang->NAMA_BARANG ?? '-' }}</td>
                        <td style="text-align: center;">{{ number_format($row->QTY, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($harga_satuan, 0, ',', '.') }}</td>
                        <td><strong>Rp {{ number_format($row->JUMLAH, 0, ',', '.') }}</strong></td>
                        <td>
                            <div class="action-buttons">
                                {{-- PERBAIKAN: Edit menggunakan query string --}}
                                <a href="{{ route('detailpenjualan.edit', ['id_penjualan' => $penjualan->ID_PENJUALAN, 'id_barang' => $row->ID_BARANG]) }}" class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                {{-- PERBAIKAN: Delete menggunakan query string --}}
                                <form action="{{ route('detailpenjualan.destroy', ['id_penjualan' => $penjualan->ID_PENJUALAN, 'id_barang' => $row->ID_BARANG]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('Yakin hapus barang {{ $row->ID_BARANG }}?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4" style="text-align:right;">TOTAL NILAI DETAIL :</td>
                    <td colspan="2" class="total-amount">Rp {{ number_format($grand_total, 0, ',', '.') }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h4>Belum Ada Barang</h4>
            <p>Silakan klik tombol "Tambah Barang" untuk menambahkan rincian penjualan.</p>
        </div>
    @endif
</div>
@endsection