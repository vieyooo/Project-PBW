@extends('layouts.app')

@section('page-title', 'Data Petugas')

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
    }
    .data-table thead th {
        background-color: #b8870bf2;
        color: #f1f5f9;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        white-space: nowrap;
    }
    .data-table tbody td {
        padding: 12px 16px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
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
    .jabatan-badge {
        background: #e0f2fe;
        color: #0369a1;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
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
/* Tambahan untuk handle SVG jika muncul (optional) */
.pagination-links svg {
    width: 16px;
    height: 16px;
    display: none; /* atau biarkan saja */
}
    
    .pagination-info {
        font-size: 13px;
        color: #64748b;
        background: #f8fafc;
        padding: 6px 16px;
        border-radius: 30px;
    }
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
    @media (max-width: 768px) {
        .action-header { flex-direction: column; align-items: flex-start; }
        .table-container { padding: 16px; }
        .pagination { flex-direction: column; align-items: center; }
    }
</style>

<div class="table-container">
    <div class="action-header">
        <h3><i class="fas fa-user-tie"></i> Data Petugas</h3>
        <div style="display: flex; gap: 12px;">
            <div class="limit-selector">
                <label>Tampilkan:</label>
                <a href="{{ route('petugas.index', ['limit' => 5]) }}" {{ request('limit') == 5 ? 'class=active-limit' : '' }}>5</a>
                <a href="{{ route('petugas.index', ['limit' => 10]) }}" {{ request('limit') == 10 ? 'class=active-limit' : '' }}>10</a>
                <a href="{{ route('petugas.index', ['limit' => 15]) }}" {{ request('limit') == 15 ? 'class=active-limit' : '' }}>15</a>
                <a href="{{ route('petugas.index', ['limit' => 20]) }}" {{ request('limit') == 20 ? 'class=active-limit' : '' }}>20</a>
            </div>
            <a href="{{ route('petugas.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah Petugas
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
                    <th>ID PETUGAS</th>
                    <th>NAMA PETUGAS</th>
                    <th>JABATAN</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @php
    // Ambil koleksi data, urutkan descending berdasarkan ID_PETUGAS
    $sortedPetugas = $petugas->getCollection()->sortByDesc('ID_PETUGAS');
@endphp
@forelse($sortedPetugas as $p)
                <tr>
                    <td><span class="id-badge">{{ $p->ID_PETUGAS }}</span></td>
                    <td><strong>{{ $p->NAMA_PETUGAS }}</strong></td>
                    <td><span class="jabatan-badge">{{ $p->JABATAN }}</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('petugas.edit', $p->ID_PETUGAS) }}" class="btn-action btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('petugas.destroy', $p->ID_PETUGAS) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('Hapus petugas {{ $p->NAMA_PETUGAS }}?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:40px;">Belum ada data petugas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($petugas->total() > 0)
<div class="pagination">
    <div class="pagination-info">
        Menampilkan {{ $petugas->firstItem() }} - {{ $petugas->lastItem() }} dari {{ $petugas->total() }} petugas
    </div>
    {{ $petugas->appends(['limit' => request('limit', 10)])->links('vendor.pagination.custom') }}
</div>
@endif
</div>
@endsection