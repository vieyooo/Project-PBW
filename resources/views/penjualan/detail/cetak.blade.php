<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $penjualan->ID_PENJUALAN }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #C6A43F;
            --dark: #0F172A;
            --gray-light: #F1F5F9;
            --gray-text: #64748B;
        }
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background: #fff;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            line-height: 1.5;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #E2E8F0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid var(--gold);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header-left h1 {
            color: var(--gold);
            margin: 0 0 5px 0;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header-left p { margin: 0; color: var(--gray-text); font-size: 12px; }
        .header-right { text-align: right; }
        .header-right h2 { margin: 0; font-size: 32px; color: var(--gray-text); opacity: 0.3; text-transform: uppercase; }
        .invoice-title { font-size: 18px; font-weight: bold; margin-bottom: 5px; color: var(--dark); }

        .info-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .info-box { width: 48%; }
        .info-box h4 {
            margin: 0 0 10px 0;
            color: var(--gray-text);
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--gray-light);
            padding-bottom: 5px;
        }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 4px 0; vertical-align: top; }
        .info-table td:first-child { width: 120px; font-weight: 600; }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: var(--gold);
            color: #fff;
            padding: 10px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid var(--gray-light);
        }
        .items-table th.right, .items-table td.right { text-align: right; }
        .items-table th.center, .items-table td.center { text-align: center; }

        .summary-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }
        .summary-box { width: 350px; }
        .summary-table { width: 100%; border-collapse: collapse; }
        .summary-table td { padding: 6px 10px; }
        .summary-table td.label { font-weight: 600; color: var(--gray-text); text-align: right; }
        .summary-table td.value { text-align: right; font-weight: 600; width: 120px; }
        .summary-table tr.total-row td {
            font-size: 16px;
            color: var(--dark);
            border-top: 2px solid var(--dark);
            padding-top: 10px;
        }
        .summary-table tr.total-row td.label { color: var(--dark); }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .terbilang-box {
            width: 60%;
            background: var(--gray-light);
            padding: 15px;
            border-radius: 8px;
            align-self: flex-start;
        }
        .terbilang-box h5 { margin: 0 0 5px 0; font-size: 11px; color: var(--gray-text); text-transform: uppercase; }
        .terbilang-box p { margin: 0; font-style: italic; font-weight: 600; text-transform: capitalize; }

        .ttd-box { width: 30%; text-align: center; }
        .ttd-box p { margin: 0; }
        .ttd-space { height: 80px; display: flex; align-items: center; justify-content: center; margin: 5px 0; }
        .ttd-img { max-height: 80px; max-width: 100%; object-fit: contain; }
        .ttd-name { font-weight: 600; text-decoration: underline; }

        .keterangan-bawah { margin-top: 30px; font-size: 11px; color: var(--gray-text); text-align: center; border-top: 1px solid #E2E8F0; padding-top: 15px; }

        @media print {
            body { padding: 0; background: #fff; }
            .invoice-container { border: none; padding: 0; max-width: 100%; }
            .no-print { display: none !important; }
            .items-table th {
                background-color: #C6A43F !important;
                color: #ffffff !important;
            }
            .terbilang-box {
                background-color: #F1F5F9 !important;
            }
        }

        .print-btn-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--gold);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(198,164,63,0.4);
            transition: 0.3s;
            font-family: 'Inter', sans-serif;
        }
        .print-btn-float:hover { background: #A68A2E; transform: translateY(-2px); }
    </style>
</head>
<body>

    <button onclick="window.print()" class="print-btn-float no-print">
        CETAK INVOICE
    </button>

    <div class="invoice-container">
        <div class="header">
            <div class="header-left">
                <h1>VERTUE CONCEPT</h1>
                <p>Jl. Danau Sunter Utara Blok J12 No.6, Sunter Agung, Jakarta Utara</p>
                <p>Telp: 0889 9999 9977 | Email: vertueconcept@gmail.com</p>
            </div>
            <div class="header-right">
                <h2>INVOICE</h2>
                <div class="invoice-title">#{{ $penjualan->ID_PENJUALAN }}</div>
            </div>
        </div>

        <div class="info-container">
            <div class="info-box">
                <h4>Informasi Tagihan</h4>
                <table class="info-table">
                    <tr><td>Tanggal Nota</td><td>: {{ date('d M Y', strtotime($penjualan->TANGGAL)) }}</td></tr>
                    <tr><td>Jatuh Tempo</td><td>: <span style="color:#dc2626; font-weight:600;">{{ date('d M Y', strtotime($penjualan->JATUH_TEMPO)) }}</span></td></tr>
                    <tr><td>Kasir / Petugas</td><td>: {{ $penjualan->petugas->NAMA_PETUGAS ?? '-' }}</td></tr>
                </table>
            </div>
            <div class="info-box">
                <h4>Ditagihkan Kepada</h4>
                <table class="info-table">
                    <tr><td colspan="2" style="font-size:16px;font-weight:700;color:var(--gold);padding-bottom:5px;">{{ $penjualan->pelanggan->NAMA_PELANGGAN ?? 'Pelanggan Umum' }}</td></tr>
                    <tr><td>No. Telepon</td><td>: {{ $penjualan->pelanggan->NO_TELP ?? '-' }}</td></tr>
                    <tr><td>Alamat</td><td>: {{ $penjualan->pelanggan->ALAMAT ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="center" style="width:5%;">No</th>
                    <th>Nama Barang / Deskripsi</th>
                    <th class="center" style="width:10%;">Qty</th>
                    <th class="right" style="width:20%;">Harga Satuan</th>
                    <th class="right" style="width:25%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($detail as $row)
                    @php
                        $harga_satuan = ($row->QTY > 0) ? ($row->JUMLAH / $row->QTY) : 0;
                    @endphp
                    <tr>
                        <td class="center">{{ $no++ }}</td>
                        <td>{{ $row->barang->NAMA_BARANG ?? '-' }}<br><small style="color:var(--gray-text)">ID: {{ $row->ID_BARANG }}</small></td>
                        <td class="center">{{ number_format($row->QTY, 0, ',', '.') }}</td>
                        <td class="right">Rp {{ number_format($harga_satuan, 0, ',', '.') }}</td>
                        <td class="right">Rp {{ number_format($row->JUMLAH, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="center">Tidak ada rincian barang.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="summary-container">
            <div class="summary-box">
                <table class="summary-table">
                    <tr>
                        <td class="label">Subtotal :</td>
                        <td class="value">Rp {{ number_format($penjualan->SUBTOTAL, 0, ',', '.') }}</td>
                    </tr>
                    <!-- BARIS DISKON DIHAPUS -->
                    <tr class="total-row">
                        <td class="label">TOTAL AKHIR :</td>
                        <td class="value">Rp {{ number_format($penjualan->TOTAL, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Sisa Tagihan :</td>
                        <td class="value">Rp {{ number_format($penjualan->SISA_TAGIHAN, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="footer">
            <div class="terbilang-box">
                <h5>Terbilang:</h5>
                <p># {{ $penjualan->TERBILANG ?? '-' }} #</p>
                <div style="margin-top:15px;">
                    <h5>Catatan Penjualan:</h5>
                    <span style="font-size:12px;color:var(--dark);">{{ nl2br($penjualan->PESAN ?? '-') }}</span>
                </div>
            </div>

            <div class="ttd-box">
                <p>Dicetak oleh,</p>
                <div class="ttd-space">
                    @if(!empty($penjualan->petugas->FILE_TTD))
                        <img src="{{ asset('img/ttd/' . $penjualan->petugas->FILE_TTD) }}" alt="Tanda Tangan" class="ttd-img">
                    @endif
                </div>
                <p class="ttd-name">{{ $penjualan->petugas->NAMA_PETUGAS ?? 'Admin' }}</p>
                <p style="font-size:11px;color:var(--gray-text);">Staff Vertue Concept</p>
            </div>
        </div>

        <div class="keterangan-bawah">
            Hasil instalasi interior tidak dapat dikembalikan, namun dilindungi oleh garansi pengerjaan sesuai S&K yang berlaku.<br>
            Terima kasih telah mempercayakan keindahan interior kendaraan Anda kepada Vertue Concept.
        </div>
    </div>

</body>
</html>