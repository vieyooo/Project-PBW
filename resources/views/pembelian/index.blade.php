@extends('layouts.app')

@section('content')

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
    .btn-primary:hover {
        background: #9a7009; transform: translateY(-2px);
    }
    .table-responsive { overflow-x: auto; border-radius: 12px; border: 1px solid #e2e8f0; }
    .data-table { width: 100%; border-collapse: collapse; text-align: left; }
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
    .rupiah-diskon { font-family: monospace; font-size: 13px; color: #dc2626; }
    .price-badge { background: #10b981; color: #ffffff; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; font-family: monospace; display: inline-block; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2); }
    .tanggal-text { color: #64748b; font-size: 13px; }
    .action-buttons { display: flex; gap: 6px; align-items: center; flex-wrap: nowrap; }
    .btn-action { padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease; }
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
    .pagination-links a, .pagination-links span { padding: 8px 14px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 500; border: 1px solid #e2e8f0; background: white; color: #475569; }
    .pagination-links a:hover, .pagination-links .active-page { background: #b8860b; color: white; border-color: #b8860b; }
    .pagination-info { font-size: 13px; color: #64748b; background: #f8fafc; padding: 6px 16px; border-radius: 30px; }
    .modal-scan {
        display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .modal-scan-content {
        position: relative; margin: 5% auto; padding: 20px; width: 90%; max-width: 900px; background: white; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); animation: slideDown 0.3s ease;
    }
    @keyframes slideDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .modal-scan-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 16px; }
    .modal-scan-header h4 { margin: 0; font-size: 18px; font-weight: 700; color: #0f172a; }
    .modal-scan-header h4 i { color: #b8860b; margin-right: 8px; }
    .modal-close { background: #f1f5f9; border: none; font-size: 24px; cursor: pointer; color: #64748b; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
    .modal-close:hover { background: #dc2626; color: white; }
    .modal-scan-body { text-align: center; padding: 10px; }
    .modal-scan-body img { max-width: 100%; max-height: 70vh; border-radius: 12px; }
    @media (max-width: 480px) {
        .data-table thead th, .data-table tbody td { padding: 8px 10px; }
        .modal-scan-content { width: 95%; margin: 10% auto; }
    }
    @media (max-width: 768px) {
        .action-header { flex-direction: column; align-items: flex-start; }
        .action-buttons { flex-wrap: wrap; }
    }
</style>

<div class="table-container">
    <div class="action-header">
        <h3><i class="fas fa-file-invoice"></i> Data Pembelian</h3>
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div class="limit-selector">
                <label>Tampilkan:</label>
                @foreach([5,10,15,20] as $l)
                    <a href="{{ route('pembelian.index', array_merge(request()->query(), ['limit' => $l, 'page' => 1])) }}"
                       @class(['active-limit' => $limit == $l])>{{ $l }}</a>
                @endforeach
            </div>
            <a href="{{ route('pembelian.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah Pembelian
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
                    <th class="text-right">Diskon</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Scan Nota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembelian as $row)
                    @php
                        $hasScan = !empty($row->scan_nota) && Storage::disk('public')->exists($row->scan_nota);
                        $imageUrl = $hasScan ? Storage::disk('public')->url($row->scan_nota) : '';
                    @endphp
                    <tr>
                        <td><span class="id-badge">{{ $row->NO_INVOICE }}</span></td>
                        <td class="tanggal-text">{{ \Carbon\Carbon::parse($row->TANGGAL)->format('d M Y') }}</td>
                        <td><span class="supplier-badge">{{ $row->supplier->NAMA_SUPPLIER ?? '-' }}</span></td>
                        <td class="text-right rupiah-text">Rp {{ number_format($row->JUMLAH_HARGA, 0, ',', '.') }}</td>
                        <td class="text-right rupiah-text">Rp {{ number_format($row->NILAI_DPP, 0, ',', '.') }}</td>
                        <td class="text-right rupiah-text">Rp {{ number_format($row->PPN, 0, ',', '.') }}</td>
                        <td class="text-right rupiah-text">Rp {{ number_format($row->ONGKOS_KIRIM, 0, ',', '.') }}</td>
                        <td class="text-right rupiah-diskon">- Rp {{ number_format($row->DISKON, 0, ',', '.') }}</td>
                        <td class="text-center"><span class="price-badge">Rp {{ number_format($row->TOTAL_INVOICE, 0, ',', '.') }}</span></td>
                        <td class="text-center">
                            @if($hasScan)
                                <button type="button" class="btn-action btn-scan"
                                    onclick="openScanModal('{{ $imageUrl }}', '{{ $row->NO_INVOICE }}')">
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
                                <form action="{{ route('pembelian.destroy', $row->NO_INVOICE) }}" method="POST"
                                      style="display:inline;"
                                      onsubmit="return confirm('Hapus pembelian {{ $row->NO_INVOICE }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11">
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
                {{-- tidak ada tombol prev --}}
            @else
                <a href="{{ $pembelian->previousPageUrl() }}">« Prev</a>
            @endif

            @for($i = max(1, $pembelian->currentPage() - 2); $i <= min($pembelian->lastPage(), $pembelian->currentPage() + 2); $i++)
                @if($i == $pembelian->currentPage())
                    <span class="active-page">{{ $i }}</span>
                @else
                    <a href="{{ $pembelian->url($i) }}">{{ $i }}</a>
                @endif
            @endfor

            @if($pembelian->hasMorePages())
                <a href="{{ $pembelian->nextPageUrl() }}">Next »</a>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Modal Scan Nota -->
<div id="modalScan" class="modal-scan">
    <div class="modal-scan-content">
        <div class="modal-scan-header">
            <h4><i class="fas fa-receipt"></i> Scan Nota - <span id="modalInvoice">-</span></h4>
            <button class="modal-close" onclick="closeScanModal()">&times;</button>
        </div>
        <div class="modal-scan-body" id="modalScanBody">
            <div class="no-image">Memuat gambar...</div>
        </div>
    </div>
</div>

<script>
function openScanModal(imageUrl, invoiceNo) {
    const modal = document.getElementById('modalScan');
    const modalInvoice = document.getElementById('modalInvoice');
    const modalBody = document.getElementById('modalScanBody');

    modalInvoice.textContent = invoiceNo;

    if (imageUrl && imageUrl !== '') {
        modalBody.innerHTML = `<img src="${imageUrl}" alt="Scan Nota" style="max-width:100%; max-height:70vh; border-radius:12px;"
            onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\\'no-image\\'><i class=\\'fas fa-file-image\\'></i><p>Gambar tidak dapat dimuat. File mungkin tidak ada.</p></div>';">`;
    } else {
        modalBody.innerHTML = '<div class="no-image"><i class="fas fa-file-image"></i><p>Belum ada scan nota untuk invoice ini.</p></div>';
    }

    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeScanModal() {
    const modal = document.getElementById('modalScan');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

window.onclick = function(event) {
    const modal = document.getElementById('modalScan');
    if (event.target == modal) closeScanModal();
};
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') closeScanModal();
});
</script>

@endsection