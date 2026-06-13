@extends('layouts.app')

@section('page-title', 'Data Pelanggan')

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
    }
    .contact-info i {
        width: 16px;
        color: #94a3b8;
        margin-right: 6px;
    }
    .action-buttons {
        display: flex;
        gap: 8px;
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
    }
    .btn-edit {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }
    .btn-edit:hover {
        background: #3b82f6;
        color: white;
    }
    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .btn-delete:hover {
        background: #ef4444;
        color: white;
    }
    .limit-selector {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        padding: 6px 15px;
        border-radius: 40px;
        border: 1px solid #e2e8f0;
    }
    .limit-selector label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }
    .limit-selector a {
        color: #b8860b;
        text-decoration: none;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 13px;
        transition: all 0.2s ease;
    }
    .limit-selector a:hover {
        background: #b8860b;
        color: white;
    }
    .limit-selector .active-limit {
        background: #b8860b;
        color: white;
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
.pagination-links {
    display: flex;
    gap: 8px;
    align-items: center;
}
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
.pagination-links a:hover {
    background: #f1f5f9;
}
.pagination-links .active-page {
    background: #b8860b;
    color: white;
    border-color: #b8860b;
    font-weight: 700;
}
.pagination-links .disabled {
    color: #cbd5e1;
    background: #f8fafc;
    cursor: not-allowed;
}
@media (max-width: 768px) {
    .pagination { flex-direction: column; align-items: flex-start; gap: 12px; }
}
    .alert-success, .alert-error {
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    .alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
    .alert-error { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
</style>

<div class="table-container">
    <div class="action-header">
        <h3><i class="fas fa-user-tag"></i> Data Pelanggan</h3>
        <div style="display: flex; gap: 12px;">
            <div class="limit-selector">
                <label>Tampilkan:</label>
                <a href="{{ route('pelanggans.index', ['limit' => 5]) }}" {{ request('limit') == 5 ? 'class=active-limit' : '' }}>5</a>
                <a href="{{ route('pelanggans.index', ['limit' => 10]) }}" {{ request('limit') == 10 ? 'class=active-limit' : '' }}>10</a>
                <a href="{{ route('pelanggans.index', ['limit' => 15]) }}" {{ request('limit') == 15 ? 'class=active-limit' : '' }}>15</a>
                <a href="{{ route('pelanggans.index', ['limit' => 20]) }}" {{ request('limit') == 20 ? 'class=active-limit' : '' }}>20</a>
            </div>
            <a href="{{ route('pelanggans.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah Pelanggan
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
                <tr><th>ID Pelanggan</th><th>Nama Pelanggan</th><th>Alamat</th><th>Kontak</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($pelanggans as $row)
                <tr>
                    <td><span class="id-badge">{{ $row->ID_PELANGGAN }}</span></td>
                    <td>{{ $row->NAMA_PELANGGAN }}</td>
                    <td>{{ $row->ALAMAT }}</td>
                    <td>
                        <div class="contact-info">
                            <div><i class="fas fa-phone-alt"></i> {{ $row->NO_TELP }}</div>
                            @if($row->FAX && $row->FAX != '-' && $row->FAX != 'NULL')
                                <div><i class="fas fa-fax"></i> {{ $row->FAX }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="nowrap-text">
                        <div class="action-buttons">
                            <a href="{{ route('pelanggans.edit', $row->ID_PELANGGAN) }}" class="btn-action btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('pelanggans.destroy', $row->ID_PELANGGAN) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('Peringatan: Apakah Anda yakin ingin menghapus data pelanggan {{ $row->NAMA_PELANGGAN }}?');">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;">Tidak ada data pelanggan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pelanggans->total() > 0)
<div class="pagination">
    <div class="pagination-info">
        <i class="fas fa-database" style="font-size: 12px; color: #94a3b8;"></i>
        Menampilkan {{ $pelanggans->firstItem() }} - {{ $pelanggans->lastItem() }} dari {{ $pelanggans->total() }} pelanggan
    </div>
    {{ $pelanggans->appends(['limit' => request('limit', 10)])->links('vendor.pagination.custom') }}
</div>
@endif
</div>
@endsection