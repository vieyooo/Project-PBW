@extends('layouts.app')

@section('page-title', 'Data Supplier')

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
    .nowrap-text { white-space: nowrap; }
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
    .supplier-name { font-weight: 600; color: #0f172a; }
    .contact-info { font-size: 13px; line-height: 1.5; }
    .contact-info i { width: 16px; color: #94a3b8; margin-right: 6px; }
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
        text-align: center;
        transition: all 0.2s ease;
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
        .action-buttons { flex-direction: row; flex-wrap: wrap; }
        .pagination { flex-direction: column; align-items: flex-start; gap: 12px; }
    }
</style>

<div class="table-container">
    <div class="action-header">
        <h3><i class="fas fa-truck"></i> Data Supplier Bahan Baku</h3>
        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <div class="limit-selector">
                <label>Tampilkan:</label>
                <a href="{{ route('suppliers.index', ['limit' => 5]) }}" {{ request('limit') == 5 ? 'class=active-limit' : '' }}>5</a>
                <a href="{{ route('suppliers.index', ['limit' => 10]) }}" {{ request('limit') == 10 ? 'class=active-limit' : '' }}>10</a>
                <a href="{{ route('suppliers.index', ['limit' => 15]) }}" {{ request('limit') == 15 ? 'class=active-limit' : '' }}>15</a>
                <a href="{{ route('suppliers.index', ['limit' => 20]) }}" {{ request('limit') == 20 ? 'class=active-limit' : '' }}>20</a>
            </div>
            <a href="{{ route('suppliers.create') }}" class="btn-primary">
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
                    <th>ID SUPPLIER</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th>PIC</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
    $sortedSuppliers = $suppliers->getCollection()->sortByDesc('ID_SUPPLIER');
@endphp
@forelse($sortedSuppliers as $s)
                <tr>
                    <td class="nowrap-text"><span class="id-badge">{{ $s->ID_SUPPLIER }}</span></td>
                    <td class="supplier-name">{{ $s->NAMA_SUPPLIER }}</td>
                    <td style="max-width: 300px; line-height: 1.4;">{{ $s->ALAMAT }}</td>
                    <td class="nowrap-text">
                        <div class="contact-info">
                            <div><i class="fas fa-phone-alt"></i> {{ $s->NO_TELP }}</div>
                            @if(!empty($s->FAX) && $s->FAX != '-')
                                <div><i class="fas fa-fax"></i> {{ $s->FAX }}</div>
                            @endif
                        </div>
                    </td>
                    <td style="font-weight: 600">{{ $s->PIC_SUPPLIER }}</td>
                    <td class="nowrap-text">
                        <div class="action-buttons">
                            <a href="{{ route('suppliers.edit', $s->ID_SUPPLIER) }}" class="btn-action btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('suppliers.destroy', $s->ID_SUPPLIER) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('Peringatan: Apakah Anda yakin ingin menghapus data supplier {{ $s->NAMA_SUPPLIER }}?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <h4>Tidak Ada Data Supplier</h4>
                            <p>Data supplier masih kosong. Silakan klik tombol "Tambah Data" untuk memulai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($suppliers->total() > 0)
    <div class="pagination">
        <div class="pagination-info">
            <i class="fas fa-database" style="font-size: 12px; color: #94a3b8;"></i>
            Menampilkan data {{ $suppliers->firstItem() }} - {{ $suppliers->lastItem() }} dari {{ $suppliers->total() }} supplier
        </div>
        {{ $suppliers->appends(['limit' => request('limit', 10)])->links('vendor.pagination.custom') }}
    </div>
    @endif
</div>
@endsection