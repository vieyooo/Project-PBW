@extends('layouts.app')

@section('page-title', 'Data Bahan Baku')

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
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2);
    }
    .btn-primary:hover {
        background: #9a7009;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(184, 134, 11, 0.3);
    }
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
    .data-table tbody tr:hover {
        background-color: #f8fafc;
    }
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
    .supplier-name { font-weight: 600; color: #0f172a; }
    .action-buttons {
        display: flex;
        gap: 6px;
        flex-wrap: nowrap;
        align-items: center;
    }
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
        white-space: nowrap;
        border: none;
        cursor: pointer;
        font-family: inherit;
    }
    .btn-edit {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }
    .btn-edit:hover { background: #3b82f6; color: white; border-color: #3b82f6; }
    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .btn-delete:hover { background: #ef4444; color: white; border-color: #ef4444; }
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state i { font-size: 48px; color: #cbd5e1; margin-bottom: 16px; }
    .empty-state h4 { color: #475569; margin-bottom: 8px; }
    .empty-state p { color: #94a3b8; font-size: 14px; }
    .limit-selector {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        padding: 6px 15px;
        border-radius: 40px;
        border: 1px solid #e2e8f0;
    }
    .limit-selector label { font-size: 13px; font-weight: 600; color: #475569; }
    .limit-selector a {
        color: #b8860b;
        text-decoration: none;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 13px;
        transition: all 0.2s ease;
    }
    .limit-selector a:hover { background: #b8860b; color: white; }
    .limit-selector .active-limit { background: #b8860b; color: white; }
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
    .pagination {
        margin-top: 0;
        padding-top: 16px;
        padding-bottom: 4px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        border-top: 1px solid #f1f5f9;
    }
    .pagination-info {
        font-size: 13px;
        color: #64748b;
        background: transparent;
        padding: 0;
        border-radius: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .pagination-links { display: flex; gap: 8px; align-items: center; }
    .pagination-links a, .pagination-links span {
        padding: 8px 14px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        min-width: 36px;
        text-align: center;
    }
    .pagination-links a:hover { background: #f1f5f9; }
    .pagination-links .active-page {
        background: #b8860b;
        color: white;
        border-color: #b8860b;
        font-weight: 700;
    }
    .pagination-links .disabled { color: #cbd5e1; background: #f8fafc; cursor: not-allowed; }
    @media (max-width: 768px) {
        .table-container { padding: 16px; }
        .action-header { flex-direction: column; align-items: flex-start; }
        .data-table thead th, .data-table tbody td { padding: 10px 12px; }
        .action-buttons { flex-wrap: wrap; }
        .pagination { flex-direction: column; align-items: flex-start; gap: 12px; }
    }
</style>

<div class="table-container">
    <div class="action-header">
        <h3><i class="fas fa-boxes"></i> Data Bahan Baku</h3>
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div class="limit-selector">
                <label>Tampilkan:</label>
                <a href="{{ route('bahan-bakus.index', ['limit' => 5]) }}" {{ request('limit') == 5 ? 'class=active-limit' : '' }}>5</a>
                <a href="{{ route('bahan-bakus.index', ['limit' => 10]) }}" {{ request('limit') == 10 ? 'class=active-limit' : '' }}>10</a>
                <a href="{{ route('bahan-bakus.index', ['limit' => 15]) }}" {{ request('limit') == 15 ? 'class=active-limit' : '' }}>15</a>
                <a href="{{ route('bahan-bakus.index', ['limit' => 20]) }}" {{ request('limit') == 20 ? 'class=active-limit' : '' }}>20</a>
            </div>
            <a href="{{ route('bahan-bakus.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 12%;">ID BAHAN</th>
                    <th style="width: 25%;">Jenis</th>
                    <th style="width: 15%;">Kode</th>
                    <th style="width: 15%;">Harga Satuan</th>
                    <th style="width: 10%; text-align: center;">Satuan</th>
                    <th style="width: 8%; text-align: center;">Stok</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bahanBaku as $b)
                <tr>
                    <td><span class="id-badge">{{ $b->ID_BAHAN_BAKU }}</span></td>
                    <td class="supplier-name">{{ $b->JENIS }}</td>
                    <td>{{ $b->KODE }}</td>
                    <td><span class="price-badge">Rp {{ number_format($b->HARGA_SATUAN, 0, ',', '.') }}</span></td>
                    <td style="text-align: center;">{{ $b->SATUAN }}</td>
                    <td style="text-align: center;"><strong>{{ $b->STOK }}</strong></td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('bahan-bakus.edit', $b->ID_BAHAN_BAKU) }}" class="btn-action btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('bahan-bakus.destroy', $b->ID_BAHAN_BAKU) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('Yakin ingin menghapus data bahan baku ini?')">
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
                            <h4>Tidak Ada Data Bahan Baku</h4>
                            <p>Data Bahan Baku masih kosong. Silakan klik tombol "Tambah Data" untuk memulai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bahanBaku->total() > 0)
    <div class="pagination">
        <div class="pagination-info">
            <i class="fas fa-database" style="font-size: 12px; color: #94a3b8;"></i>
            Menampilkan data {{ $bahanBaku->firstItem() }} - {{ $bahanBaku->lastItem() }} dari {{ $bahanBaku->total() }} bahan baku
        </div>
        {{ $bahanBaku->appends(['limit' => request('limit', 10)])->links('vendor.pagination.custom') }}
    </div>
    @endif
</div>
@endsection