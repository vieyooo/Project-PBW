@extends('layouts.app')

@section('page-title', 'Bill of Material')

@section('content')
<style>
    .table-container {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }
    .action-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #f1f5f9;
        flex-wrap: wrap;
        gap: 16px;
    }
    .action-header h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        margin: 0;
    }
    .action-header h3 i {
        color: #b8860b;
        margin-right: 12px;
        font-size: 24px;
        background: rgba(184, 134, 11, 0.1);
        padding: 10px;
        border-radius: 12px;
    }
    .header-actions-right { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
    .btn-primary {
        background: #b8860b;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }
    .btn-primary:hover { background: #9a7009; transform: translateY(-2px); }
    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s;
    }
    .btn-secondary:hover { background: #e2e8f0; }
    .info-barang {
        background: #fef3c7;
        padding: 16px 24px;
        border-radius: 16px;
        margin-bottom: 20px;
    }
    .info-row { display: flex; align-items: baseline; margin-bottom: 8px; }
    .info-row:last-child { margin-bottom: 0; }
    .info-label { font-weight: 700; color: #64748b; width: 140px; font-size: 14px; }
    .info-value { color: #0f172a; font-weight: 600; font-size: 14px; }
    .info-value strong { color: #b8860b; font-size: 16px; }
    .table-responsive {
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
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
        text-align: left;
    }
    .data-table tbody td {
        padding: 12px 16px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .data-table tbody tr:hover { background-color: #f8fafc; }
    .id-badge {
        background: #b8860b;
        color: #f1f5f9;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        font-family: monospace;
        display: inline-block;
        text-align: center;
    }
    .price-badge {
        background: #10b981;
        color: #ffffff;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        font-family: monospace;
        display: inline-block;
        text-align: center;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }
    .action-buttons { display: flex; gap: 6px; flex-wrap: nowrap; align-items: center; }
    .btn-action {
        padding: 6px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        font-family: inherit;
    }
    .btn-edit { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .btn-edit:hover { background: #3b82f6; color: white; border-color: #3b82f6; }
    .btn-delete { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .btn-delete:hover { background: #ef4444; color: white; border-color: #ef4444; }
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state i { font-size: 48px; color: #cbd5e1; margin-bottom: 16px; }
    .empty-state h4 { color: #475569; margin-bottom: 8px; }
    .empty-state p { color: #94a3b8; font-size: 14px; }
    @media (max-width: 768px) {
        .table-container { padding: 16px; }
        .action-header { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="table-container">
    <div class="action-header">
        <h3><i class="fas fa-cubes"></i> Bill of Material (BOM)</h3>
        <div class="header-actions-right">
            <a href="{{ route('barang.bom.cetak', $barang->ID_BARANG) }}" target="_blank" class="btn-secondary">
                <i class="fas fa-print"></i> Cetak BOM
            </a>
            <a href="{{ route('barang.bom.create', $barang->ID_BARANG) }}" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah Bahan
            </a>
            <a href="{{ route('barang.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div class="info-barang">
        <div class="info-row">
            <span class="info-label">ID BARANG :</span>
            <span class="info-value"><strong>{{ $barang->ID_BARANG }}</strong></span>
        </div>
        <div class="info-row">
            <span class="info-label">NAMA BARANG :</span>
            <span class="info-value">{{ $barang->NAMA_BARANG }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">HARGA SATUAN :</span>
            <span class="info-value">Rp {{ number_format($barang->HARGA_SATUAN, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID BAHAN</th>
                    <th>JENIS BAHAN</th>
                    <th style="text-align: center;">JUMLAH</th>
                    <th style="text-align: center;">SATUAN</th>
                    <th style="text-align: right;">HARGA SATUAN</th>
                    <th style="text-align: right;">TOTAL HARGA</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bomData as $item)
                <tr>
                    <td><span class="id-badge">{{ $item->ID_BAHAN_BAKU }}</span></td>
                    <td>{{ $item->JENIS }}</td>
                    <td style="text-align: center;">{{ number_format($item->JUMLAH, 2, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $item->SATUAN }}</td>
                    <td style="text-align: right;"><span class="price-badge">Rp {{ number_format($item->HARGA_SATUAN, 0, ',', '.') }}</span></td>
                    <td style="text-align: right;"><span class="price-badge">Rp {{ number_format($item->JUMLAH * $item->HARGA_SATUAN, 0, ',', '.') }}</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('barang.bom.edit', [$barang->ID_BARANG, $item->ID_BAHAN_BAKU]) }}" class="btn-action btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('barang.bom.destroy', [$barang->ID_BARANG, $item->ID_BAHAN_BAKU]) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('Hapus bahan baku ini dari BOM?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <h4>Belum Ada Bahan Baku</h4>
                            <p>Bill of Material (BOM) untuk produk ini belum diisi. Klik "Tambah Bahan" untuk memulai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection