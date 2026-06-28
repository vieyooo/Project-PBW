@extends('layouts.app')

@section('content')

@php
    if (!isset($limit)) $limit = 10;
    if (!isset($pembelian)) {
        $pembelian = \App\Models\Pembelian::with('supplier')
            ->orderByDesc('TANGGAL')
            ->paginate($limit);
    }
    
    function format_rupiah($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
@endphp

<style>
    .table-container {
        background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); overflow: hidden;
    }
    .action-header {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px dashed #f1f5f9; flex-wrap: wrap; gap: 16px;
    }
    .action-header h3 {
        font-size: 20px; font-weight: 700; color: #0f172a; display: flex; align-items: center; margin: 0;
    }
    .action-header h3 i {
        color: #b8860b; margin-right: 12px; font-size: 24px; background: rgba(184, 134, 11, 0.1); padding: 10px; border-radius: 12px;
    }
    .btn-primary {
        background: #b8860b; color: white; border: none; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2);
    }
    .btn-primary:hover { background: #9a7009; transform: translateY(-2px); }
    .table-responsive { overflow-x: auto; border-radius: 12px; border: 1px solid #e2e8f0; }
    .data-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; }
    .data-table thead th {
        background-color: #b8870bf2; color: #f1f5f9; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 2px solid #e2e8f0; white-space: nowrap;
    }
    .data-table tbody td {
        padding: 12px 16px; font-size: 13px; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; white-space: nowrap;
    }
    .data-table tbody tr:hover { background-color: #f8fafc; }
    .id-badge { background: #b8860b; color: #f1f5f9; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; font-family: monospace; display: inline-block; }
    .supplier-badge { background: #ede9fe; color: #6d28d9; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
    .text-right { text-align: right !important; }
    .text-center { text-align: center !important; }
    .rupiah-text { font-family: monospace; font-size: 13px; color: #334155; }
    .price-badge { background: #10b981; color: #ffffff; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; font-family: monospace; display: inline-block; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2); }
    .tanggal-text { color: #64748b; font-size: 13px; }
    .action-buttons { display: flex; gap: 6px; align-items: center; flex-wrap: nowrap; }
    .btn-action {
        padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
    }
    .btn-edit { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .btn-edit:hover { background: #3b82f6; color: white; }
    .btn-delete { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .btn-delete:hover { background: #ef4444; color: white; }
    .btn-detail { background: #e6f7e6; color: #2e7d32; border: 1px solid #c8e6c9; }
    .btn-detail:hover { background: #2e7d32; color: white; }
    .btn-scan { background: #fff3e0; color: #b8860b; border: 1px solid #ffd9a5; cursor: pointer; }
    .btn-scan:hover:not([disabled]) { background: #b8860b; color: white; }
    .btn-scan[disabled] { opacity: 0.5; cursor: not-allowed; }
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state i { font-size: 48px; color: #cbd5e1; margin-bottom: 16px; display: block; }
    .limit-selector { display: flex; align-items: center; gap: 8px; background: #f8fafc; padding: 6px 15px; border-radius: 40px; border: 1px solid #e2e8f0; }
    .limit-selector label { font-size: 13px; font-weight: 600; color: #475569; }
    .limit-selector a { color: #b8860b; text-decoration: none; font-weight: 600; padding: 4px 10px; border-radius: 30px; font-size: 13px; transition: all 0.2s ease; }
    .limit-selector a:hover, .limit-selector .active-limit { background: #b8860b; color: white; }
    .pagination { margin-top: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; }
    .pagination-links { display: flex; gap: 6px; flex-wrap: wrap; }
    .pagination-links a, .pagination-links span {
        padding: 8px 14px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 500; border: 1px solid #e2e8f0; background: white; color: #475569;
        font-family: 'Inter', sans-serif;
    }
    .pagination-links a:hover, .pagination-links .active-page { background: #b8860b; color: white; border-color: #b8860b; }
    .pagination-info { font-size: 13px; color: #64748b; background: #f8fafc; padding: 6px 16px; border-radius: 30px; }
</style>

<div class="table-container">
    <div class="action-header">
        <h3><i class="fas fa-file-invoice"></i> Data Pembelian</h3>
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div class="limit-selector">
                <label>Tampilkan:</label>
                @foreach([5,10,15,20] as $l)
                    <a href="?menu=pembelian&limit={{ $l }}&page=1" @class(['active-limit' => $limit == $l])>{{ $l }}</a>
                @endforeach
            </div>
            <a href="{{ route('pembelian.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th class="text-right">Jml Harga</th>
                    <th class="text-right">Nilai DPP</th>
                    <th class="text-right">PPN</th>
                    <th class="text-right">Ongkir</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Scan Nota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembelian as $row)
                    @php
                        $hasScan = !empty($row->SCAN_NOTA) && file_exists(public_path($row->SCAN_NOTA));
                        $imageUrl = $hasScan ? asset($row->SCAN_NOTA) : '';
                    @endphp
                    <tr>
                        <td><span class="id-badge">{{ $row->NO_INVOICE }}</span></td>
                        <td class="tanggal-text">{{ \Carbon\Carbon::parse($row->TANGGAL)->format('d M Y') }}</td>
                        <td><span class="supplier-badge">{{ $row->supplier->NAMA_SUPPLIER ?? '-' }}</span></td>
                        <td class="text-right rupiah-text">{{ format_rupiah($row->JUMLAH_HARGA) }}</td>
                        <td class="text-right rupiah-text">{{ format_rupiah($row->NILAI_DPP ?? 0) }}</td>
                        <td class="text-right rupiah-text">{{ format_rupiah($row->PPN ?? 0) }}</td>
                        <td class="text-right rupiah-text">{{ format_rupiah($row->ONGKOS_KIRIM) }}</td>
                        <td class="text-center"><span class="price-badge">{{ format_rupiah($row->TOTAL_INVOICE) }}</span></td>
                        <td class="text-center">
                            @if($hasScan)
                                <button type="button" class="btn-action btn-scan" onclick="alert('Lihat scan: {{ $imageUrl }}')">
                                    <i class="fas fa-image"></i> Lihat
                                </button>
                            @else
                                <button type="button" class="btn-action btn-scan" disabled>
                                    <i class="fas fa-image"></i> Kosong
                                </button>
                            @endif
                        </td>
                       <td>
    <div class="action-buttons">
        <a href="{{ route('pembelian.show', $row->NO_INVOICE) }}" class="btn-action btn-detail">
            <i class="fas fa-list"></i> Detail
        </a>
        <a href="{{ route('pembelian.edit', $row->NO_INVOICE) }}" class="btn-action btn-edit">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('pembelian.destroy', $row->NO_INVOICE) }}" 
              method="POST" 
              style="display: inline;" 
              onsubmit="return confirm('Hapus pembelian {{ $row->NO_INVOICE }}? Semua riwayat invoice ini akan hilang.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-action btn-delete" style="cursor: pointer;">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </form>
    </div>
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <i class="fas fa-file-invoice"></i>
                                <p>Belum ada data pembelian</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($pembelian->total() > 0)
    <div class="pagination">
        <div class="pagination-info">
            Menampilkan {{ $pembelian->firstItem() }} - {{ $pembelian->lastItem() }} dari {{ $pembelian->total() }} pembelian
        </div>
        <div class="pagination-links">
            @if($pembelian->onFirstPage())
            @else
                <a href="?menu=pembelian&page={{ $pembelian->currentPage() - 1 }}&limit={{ $limit }}">« Prev</a>
            @endif

            @for($i = max(1, $pembelian->currentPage() - 2); $i <= min($pembelian->lastPage(), $pembelian->currentPage() + 2); $i++)
                @if($i == $pembelian->currentPage())
                    <span class="active-page">{{ $i }}</span>
                @else
                    <a href="?menu=pembelian&page={{ $i }}&limit={{ $limit }}">{{ $i }}</a>
                @endif
            @endfor

            @if($pembelian->hasMorePages())
                <a href="?menu=pembelian&page={{ $pembelian->currentPage() + 1 }}&limit={{ $limit }}">Next »</a>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection