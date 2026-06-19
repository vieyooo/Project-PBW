@extends('layouts.app')

@section('page-title', 'Bill of Material')

@section('content')
@php
    $totalBiayaBahan = $bomData->sum(function ($item) {
        return $item->JUMLAH * $item->HARGA_SATUAN;
    });
    $biayaProduksi = $totalBiayaBahan * 0.30;
    $hpp = $totalBiayaBahan + $biayaProduksi;
    $hargaJual = $barang->HARGA_SATUAN ?? 0;
    $labaRugi = $hargaJual - $hpp;
    $persentaseLaba = $hpp > 0 ? ($labaRugi / $hpp) * 100 : 0;

    if ($labaRugi > 0) {
        $profitColor = '#059669';
    } elseif ($labaRugi == 0) {
        $profitColor = '#d97706';
    } else {
        $profitColor = '#dc2626';
    }

    $hargaMinimalRekomendasi = $hpp * 1.30;

    function rp($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
@endphp
<style>
    .detail-container {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
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
        background: rgba(184,134,11,0.1);
        padding: 10px;
        border-radius: 12px;
    }
    .btn-back { background: #f1f5f9; color: #475569; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; }
    .btn-back:hover { background: #e2e8f0; }
    .btn-cetak { background: #1e293b; color: #fff; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; }
    .btn-cetak:hover { background: #0f172a; color: white; }
    .header-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

    .info-barang { background: #fef3c7; padding: 20px; border-radius: 12px; margin-bottom: 16px; }
    .info-row { margin-bottom: 10px; }
    .info-label { font-weight: 600; color: #64748b; width: 140px; display: inline-block; font-size: 13px; }
    .info-value { color: #0f172a; font-size: 14px; }

    .section-title { font-size: 15px; font-weight: 700; margin: 24px 0 12px 0; display: flex; justify-content: space-between; align-items: center; }
    .section-title span { color: #b8860b; display: flex; align-items: center; gap: 8px; }

    .btn-primary { background: #b8860b; color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(184,134,11,0.2); }
    .btn-primary:hover { background: #9a7009; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(184,134,11,0.3); color: white; }

    .table-responsive { overflow-x: auto; border-radius: 12px; border: 1px solid #e2e8f0; }
    .data-table { width: 100%; border-collapse: collapse; text-align: left; }
    .data-table thead th { background-color: #b8870bf2; color: #f1f5f9; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border-bottom: 2px solid #e2e8f0; white-space: nowrap; }
    .data-table tbody td { padding: 12px 16px; font-size: 13px; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .data-table tbody tr:hover { background-color: #f8fafc; }

    .action-buttons { display: flex; flex-direction: column; gap: 6px; align-items: center; }
    .btn-action { width: 100%; justify-content: center; padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s ease; border: none; cursor: pointer; font-family: inherit; }
    .btn-edit { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .btn-edit:hover { background: #3b82f6; color: white; }
    .btn-delete { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .btn-delete:hover { background: #ef4444; color: white; border-color: #ef4444; }

    .kode-bahan { font-family: monospace; font-size: 11px; color: #64748b; }
    .empty-state { text-align: center; padding: 40px; color: #94a3b8; }
    .empty-state i { font-size: 40px; color: #cbd5e1; margin-bottom: 12px; display: block; }

    /* ── SUMMARY STRIP (minimalis, tanpa card) ── */
    .summary-strip {
        margin-top: 28px;
        padding-top: 0;
        display: flex;
        justify-content: flex-end;
    }
    .summary-inner {
        width: 100%;
        max-width: 460px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 8px 0;
        border-bottom: 1px dashed #f1f5f9;
        gap: 12px;
    }
    .summary-row:last-of-type {
        border-bottom: none;
    }
    .summary-row .s-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }
    .summary-row .s-value {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
    }
    .summary-divider {
        border: none;
        border-top: 1.5px solid #e2e8f0;
        margin: 6px 0;
    }
    .summary-hpp {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 10px 0;
        gap: 12px;
    }
    .summary-hpp .s-label {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }
    .summary-hpp .s-value {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        white-space: nowrap;
    }
    .summary-laba {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0 4px;
        gap: 12px;
        border-top: 1.5px solid #e2e8f0;
        margin-top: 2px;
    }
    .summary-laba .s-label {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
    }
    .summary-laba .s-value {
        font-size: 17px;
        font-weight: 700;
        white-space: nowrap;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        line-height: 1.3;
    }
    .summary-laba .s-pct {
        font-size: 11px;
        font-weight: 500;
        opacity: 0.75;
    }
    .profit-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.6px;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid;
        margin-top: 10px;
        float: right;
        clear: right;
    }

    .warning-box { background: #fef2f2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 8px; margin-top: 15px; }
    .warning-box h5 { margin: 0 0 8px 0; color: #dc2626; font-size: 13px; }
    .warning-box p { margin: 0; font-size: 12px; color: #7f1d1d; }
    .recommendation-box { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px; border-radius: 8px; margin-top: 15px; }
    .recommendation-box h5 { margin: 0 0 8px 0; color: #1e40af; font-size: 13px; }
    .recommendation-box p { margin: 0; font-size: 12px; color: #1e3a8a; }
    .note-box { background: #fffbeb; border-left: 4px solid #f59e0b; padding: 12px; border-radius: 8px; margin-top: 15px; font-size: 11px; color: #92400e; }

    @media (max-width:768px){
        .info-label{ width:100%; display:block; margin-bottom:4px; }
        .data-table th, .data-table td{ padding:8px 12px; }
        .section-title { flex-direction: column; align-items: flex-start; gap: 12px; }
        .btn-primary { width: 100%; justify-content: center; }
        .header-actions { width: 100%; justify-content: space-between; }
        .btn-cetak, .btn-back { flex: 1; justify-content: center; margin: 0; }
        .summary-strip { justify-content: stretch; }
        .summary-inner { max-width: 100%; }
    }
</style>

<div class="detail-container">
    @if(session('success') === 'tambah')
        <div style="background:#ecfdf5;border-left:4px solid #059669;color:#065f46;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13px;font-weight:600;">
            <i class="fas fa-check-circle"></i> Barang berhasil ditambahkan! Silakan lengkapi Bill of Material (BOM) di bawah ini.
        </div>
    @elseif(session('success'))
        <div style="background:#ecfdf5;border-left:4px solid #059669;color:#065f46;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13px;font-weight:600;">
            <i class="fas fa-check-circle"></i> Bahan baku berhasil ditambahkan ke BOM.
        </div>
    @endif
    <div class="detail-header">
        <h3><i class="fas fa-clipboard-list"></i> Bill of Material (BOM)</h3>
        <div class="header-actions">
            <a href="{{ route('barang.bom.cetak', $barang->ID_BARANG) }}" target="_blank" class="btn-cetak"><i class="fas fa-print"></i> Cetak BOM</a>
            <a href="{{ route('barang.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Barang</a>
        </div>
    </div>

    <div class="info-barang">
        <div class="info-row"><span class="info-label">ID BARANG</span><span class="info-value"><strong>{{ $barang->ID_BARANG }}</strong></span></div>
        <div class="info-row"><span class="info-label">NAMA BARANG</span><span class="info-value">{{ $barang->NAMA_BARANG }}</span></div>
        <div class="info-row"><span class="info-label">HARGA JUAL SAAT INI</span><span class="info-value">{{ rp($hargaJual) }}</span></div>
    </div>

    <div class="section-title">
        <span><i class="fas fa-boxes"></i> DAFTAR BAHAN BAKU</span>
        <a href="{{ route('barang.bom.create', $barang->ID_BARANG) }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah Bahan Baku</a>
    </div>

    @if($bomData->count() > 0)
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:12%;">ID Bahan</th>
                        <th style="width:33%;">Jenis Bahan</th>
                        <th style="width:10%;text-align:center;">Jumlah</th>
                        <th style="width:15%;">Harga Satuan</th>
                        <th style="width:15%;">Total Harga</th>
                        <th style="width:5%;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($bomData as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->ID_BAHAN_BAKU }}</strong>
                            @if(!empty($item->KODE))
                                <br><span class="kode-bahan">{{ $item->KODE }}</span>
                            @endif
                        </td>
                        <td>{{ $item->JENIS }}</td>
                        <td style="text-align:center;">{{ number_format($item->JUMLAH, 2, ',', '.') }}</td>
                        <td>{{ rp($item->HARGA_SATUAN) }}</td>
                        <td><strong>{{ rp($item->JUMLAH * $item->HARGA_SATUAN) }}</strong></td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('barang.bom.edit', [$barang->ID_BARANG, $item->ID_BAHAN_BAKU]) }}" class="btn-action btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('barang.bom.destroy', [$barang->ID_BARANG, $item->ID_BAHAN_BAKU]) }}" method="POST" style="display:inline; width: 100%;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('Yakin hapus bahan baku {{ $item->ID_BAHAN_BAKU }} dari BOM?')"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- SUMMARY STRIP -->
        <div class="summary-strip">
            <div class="summary-inner">
                <div class="summary-row">
                    <span class="s-label">A. Total Biaya Bahan Baku</span>
                    <span class="s-value">{{ rp($totalBiayaBahan) }}</span>
                </div>
                <div class="summary-row">
                    <span class="s-label">B. Biaya Produksi (Jasa + Overhead)</span>
                    <span class="s-value">{{ rp($biayaProduksi) }}</span>
                </div>
                <hr class="summary-divider">
                <div class="summary-hpp">
                    <span class="s-label">C. Harga Pokok Produksi (A + B)</span>
                    <span class="s-value">{{ rp($hpp) }}</span>
                </div>
                <div class="summary-row" style="border-bottom:none;">
                    <span class="s-label">D. Harga Jual Produk</span>
                    <span class="s-value">{{ rp($hargaJual) }}</span>
                </div>
                <div class="summary-laba">
                    <span class="s-label">Keuntungan</span>
                    <span class="s-value" style="color: {{ $profitColor }};">
                        {{ $labaRugi >= 0 ? '+' : '' }}{{ rp($labaRugi) }}
                        <span class="s-pct">({{ number_format($persentaseLaba, 1) }}%)</span>
                    </span>
                </div>

            </div>
        </div>

        @if($labaRugi < 0)
            <div class="warning-box">
                <h5><i class="fas fa-exclamation-triangle"></i> PERINGATAN KRITIS!</h5>
                <p>
                    Harga jual produk ({{ rp($hargaJual) }}) lebih rendah dari Harga Pokok Produksi ({{ rp($hpp) }})
                    sebesar {{ rp(abs($labaRugi)) }}. Anda akan mengalami KERUGIAN sebesar {{ rp(abs($labaRugi)) }} per produk!
                </p>
            </div>
            <div class="recommendation-box">
                <h5><i class="fas fa-lightbulb"></i> Rekomendasi:</h5>
                <p>
                    1. Naikkan harga jual menjadi minimal {{ rp($hargaMinimalRekomendasi) }} (dengan margin 30% dari HPP)<br>
                    2. Kurangi penggunaan bahan baku yang tidak perlu<br>
                    3. Cari supplier dengan harga bahan baku lebih murah<br>
                    4. Efisienkan biaya produksi (jasa, listrik, overhead)
                </p>
            </div>
        @endif

        <div class="note-box" style="margin-top:15px;">
            <i class="fas fa-info-circle"></i> <strong>Informasi:</strong>
            Biaya produksi (Jasa + Overhead) dihitung sebesar 30% dari total biaya bahan baku.
            Anda dapat menyesuaikan nilai ini sesuai dengan kondisi riil usaha.
        </div>

    @else
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h4>Belum Ada Bahan Baku</h4>
            <p>Silakan klik tombol "Tambah Bahan Baku" untuk menambahkan Bill of Material (BOM).</p>
        </div>
    @endif
</div>
@endsection