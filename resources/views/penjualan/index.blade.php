@extends('layouts.app')

@section('page-title', 'Data Penjualan')

@section('content')
<style>
    .table-container { background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); overflow: hidden; }
    .action-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px dashed #f1f5f9; flex-wrap: wrap; gap: 16px; }
    .action-header h3 { font-size: 20px; font-weight: 700; color: #0f172a; display: flex; align-items: center; margin: 0; }
    .action-header h3 i { color: #b8860b; margin-right: 12px; font-size: 24px; background: rgba(184, 134, 11, 0.1); padding: 10px; border-radius: 12px; }
    .filter-tabs { display: flex; background: #f1f5f9; padding: 4px; border-radius: 12px; gap: 4px; }
    .filter-tab { padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; color: #64748b; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 6px; }
    .filter-tab:hover { color: #0f172a; }
    .filter-tab.active { background: #ffffff; color: #b8860b; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .btn-primary { background: #b8860b; color: white; border: none; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2); }
    .btn-primary:hover { background: #9a7009; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(184, 134, 11, 0.3); color: white; }
    .limit-selector { display: flex; align-items: center; gap: 8px; background: #f8fafc; padding: 6px 15px; border-radius: 40px; border: 1px solid #e2e8f0; }
    .limit-selector label { font-size: 13px; font-weight: 600; color: #475569; margin: 0; }
    .limit-selector a { color: #b8860b; text-decoration: none; font-weight: 600; padding: 4px 10px; border-radius: 30px; font-size: 13px; transition: all 0.2s ease; }
    .limit-selector a:hover { background: #b8860b; color: white; }
    .limit-selector .active-limit { background: #b8860b; color: white; }
    .table-responsive { overflow-x: auto; border-radius: 12px; border: 1px solid #e2e8f0; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead th { background-color: #b8870bf2; color: #f1f5f9; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; white-space: nowrap; text-align: left; }
    .data-table tbody td { padding: 12px 16px; font-size: 13px; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .data-table tbody tr:hover { background-color: #f8fafc; }
    .id-badge { background: #b8860b; color: #f1f5f9; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; font-family: monospace; display: inline-block; }
    .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; letter-spacing: 0.5px; }
    .badge-lunas { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .badge-belum { background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .action-buttons { display: flex; flex-direction: column; gap: 6px; }
    .btn-action { width: 100%; justify-content: center; padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease; border: none; cursor: pointer; }
    .btn-detail { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .btn-detail:hover { background: #16a34a; color: white; border-color: #16a34a; }
    .btn-edit { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .btn-edit:hover { background: #3b82f6; color: white; border-color: #3b82f6; }
    .btn-delete { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .btn-delete:hover { background: #ef4444; color: white; border-color: #ef4444; }
    .pagination { margin-top: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; }
    .pagination-links { display: flex; gap: 6px; flex-wrap: wrap; }
    .pagination-links a, .pagination-links span { padding: 8px 14px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s ease; border: 1px solid #e2e8f0; background: white; color: #475569; }
    .pagination-links a:hover { background: #b8860b; color: white; border-color: #b8860b; }
    .pagination-links .active-page { background: #b8860b; color: white; border-color: #b8860b; }
    .pagination-info { font-size: 13px; color: #64748b; background: #f8fafc; padding: 6px 16px; border-radius: 30px; border: 1px solid #e2e8f0; }
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state i { font-size: 48px; color: #cbd5e1; margin-bottom: 16px; }
    .alert-success, .alert-error { padding: 12px; border-radius: 12px; margin-bottom: 20px; }
    .alert-success { background: #d1fae5; color: #065f46; }
    .alert-error { background: #fee2e2; color: #991b1b; }
</style>

<div class="table-container">
    <div class="action-header">
        <h3><i class="fas fa-file-invoice-dollar"></i> Data Penjualan</h3>
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div class="filter-tabs">
                <a href="{{ route('penjualan.index', ['status' => 'semua', 'limit' => request('limit', 10)]) }}" class="filter-tab {{ $status_filter == 'semua' ? 'active' : '' }}">
                    <i class="fas fa-list"></i> Semua
                </a>
                <a href="{{ route('penjualan.index', ['status' => 'lunas', 'limit' => request('limit', 10)]) }}" class="filter-tab {{ $status_filter == 'lunas' ? 'active' : '' }}">
                    <i class="fas fa-check-circle"></i> Lunas
                </a>
                <a href="{{ route('penjualan.index', ['status' => 'belum', 'limit' => request('limit', 10)]) }}" class="filter-tab {{ $status_filter == 'belum' ? 'active' : '' }}">
                    <i class="fas fa-exclamation-circle"></i> Belum Lunas
                </a>
            </div>
            <div class="limit-selector">
                <label>Tampilkan:</label>
                <a href="{{ route('penjualan.index', ['limit' => 5, 'status' => $status_filter]) }}" class="{{ request('limit') == 5 ? 'active-limit' : '' }}">5</a>
                <a href="{{ route('penjualan.index', ['limit' => 10, 'status' => $status_filter]) }}" class="{{ request('limit') == 10 ? 'active-limit' : '' }}">10</a>
                <a href="{{ route('penjualan.index', ['limit' => 15, 'status' => $status_filter]) }}" class="{{ request('limit') == 15 ? 'active-limit' : '' }}">15</a>
                <a href="{{ route('penjualan.index', ['limit' => 20, 'status' => $status_filter]) }}" class="{{ request('limit') == 20 ? 'active-limit' : '' }}">20</a>
            </div>
            <a href="{{ route('penjualan.create') }}" class="btn-primary">
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
                    <th>ID Penjualan</th>
                    <th>Tanggal</th>
                    <th>Jatuh Tempo</th>
                    <th>Petugas</th>
                    <th>Pelanggan</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">Total</th>
                    <th class="text-right">Sisa Tagihan</th>
                    <th class="text-center">Status</th>
                    <th>Pesan</th>
                    <th>Terbilang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
@php
    $sortedPenjualan = $penjualans->getCollection()->sortByDesc('ID_PENJUALAN');
@endphp
@forelse($sortedPenjualan as $row)
                <tr>
                    <td><span class="id-badge">{{ $row->ID_PENJUALAN }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($row->TANGGAL)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->JATUH_TEMPO)->format('d/m/Y') }}</td>
                    <td><strong>{{ $row->petugas->NAMA_PETUGAS ?? $row->ID_PETUGAS }}</strong></td>
                    <td><strong>{{ $row->pelanggan->NAMA_PELANGGAN ?? $row->ID_PELANGGAN }}</strong></td>
                    <td class="text-right">Rp {{ number_format($row->SUBTOTAL, 2, ',', '.') }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($row->TOTAL, 2, ',', '.') }}</strong></td>
                    <td class="text-right">Rp {{ number_format($row->SISA_TAGIHAN, 2, ',', '.') }}</td>
                    <td class="text-center">
                        @if($row->SISA_TAGIHAN <= 0)
                            <span class="status-badge badge-lunas"><i class="fas fa-check-circle"></i> Lunas</span>
                        @else
                            <span class="status-badge badge-belum"><i class="fas fa-exclamation-circle"></i> Belum</span>
                        @endif
                    </td>
                    <td>{{ $row->PESAN }}</td>
                    <td><span style="font-size:12px; font-style:italic; color:#475569;">{{ $row->TERBILANG }}</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('detailpenjualan.index', ['id' => $row->ID_PENJUALAN]) }}" class="btn-action btn-detail">
                                <i class="fas fa-list"></i> Detail
                            </a>
                            <a href="{{ route('penjualan.edit', $row->ID_PENJUALAN) }}" class="btn-action btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('penjualan.destroy', $row->ID_PENJUALAN) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('Yakin hapus {{ $row->ID_PENJUALAN }}?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12">
                        <div class="empty-state">
                            <i class="fas fa-search"></i>
                            <h4>Data Tidak Ditemukan</h4>
                            <p>Tidak ada data penjualan yang sesuai dengan filter "<strong>{{ ucfirst($status_filter) }}</strong>".</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($penjualans->total() > 0)
    <div class="pagination">
        <div class="pagination-info">
            <i class="fas fa-database"></i> Menampilkan data {{ $penjualans->firstItem() }} - {{ $penjualans->lastItem() }} dari {{ $penjualans->total() }} penjualan
        </div>
        <div class="pagination-links">
            {{ $penjualans->appends(['limit' => request('limit', 10), 'status' => $status_filter])->links() }}
        </div>
    </div>
    @endif
</div>
@endsection