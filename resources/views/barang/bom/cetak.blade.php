<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill of Material - {{ $barang->ID_BARANG }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            padding: 20px;
            font-size: 13px;
            line-height: 1.5;
        }
        .bom-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #e2e8f0;
            background: white;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #b8860b;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header-left h1 { color: #b8860b; margin: 0 0 5px 0; font-size: 28px; }
        .header-left p { margin: 0; color: #64748b; font-size: 12px; }
        .header-right { text-align: right; }
        .header-right h2 { margin: 0; font-size: 28px; color: #b8860b; }
        .info-barang { margin-bottom: 30px; }
        .info-barang h3 { margin: 0 0 15px 0; color: #b8860b; font-size: 16px; font-weight: 700; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 6px 0; }
        .info-table td.label { font-weight: 600; color: #64748b; width: 120px; }
        .info-table td.value { font-weight: 600; color: #0f172a; }
        .section-title { font-size: 16px; font-weight: 700; margin: 0 0 15px 0; color: #0f172a; }
        .bom-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .bom-table th { background-color: #b8860b !important; color: white !important; padding: 12px; text-align: left; font-size: 12px; }
        .bom-table td { padding: 12px; border-bottom: 1px solid #f1f5f9; }
        .bom-table th.right, .bom-table td.right { text-align: right; }
        .bom-table th.center, .bom-table td.center { text-align: center; }
        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #b8960e;
            color: #ffffff;
            border: none;
            padding: 13px 28px;
            border-radius: 50px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 4px 16px rgba(184, 134, 11, 0.35);
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            z-index: 1000;
        }
        .print-btn:hover { background: #9a7009; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(184, 134, 11, 0.45); }
        .print-btn:active { transform: translateY(0); }
        @media print {
            .print-btn { display: none; }
            .bom-container { border: none; padding: 0; }
            .bom-table th { background-color: #b8860b !important; color: white !important; }
            .header { border-bottom: 3px solid #b8860b !important; }
        }
        @media (max-width: 768px) {
            .bom-container { padding: 15px; }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="print-btn">CETAK BOM</button>

    <div class="bom-container">
        <div class="header">
            <div class="header-left">
                <h1>VERTUE CONCEPT</h1>
                <p>Jl. Danau Sunter Utara Blok J12 No.6, Sunter Agung, Jakarta Utara</p>
                <p>Telp: 0889 9999 9977 | Email: vertueconcept@gmail.com</p>
            </div>
            <div class="header-right">
                <h2>BILL OF MATERIAL</h2>
            </div>
        </div>

        <div class="info-barang">
            <h3>Informasi Produk</h3>
            <table class="info-table">
                <tr>
                    <td class="label">ID Barang</td>
                    <td class="value">: {{ $barang->ID_BARANG }}</td>
                </tr>
                <tr>
                    <td class="label">Nama Barang</td>
                    <td class="value">: {{ $barang->NAMA_BARANG }}</td>
                </tr>
            </table>
        </div>

        <div class="section-title">Daftar Bahan Baku</div>

        @if($bomData->count() > 0)
            <table class="bom-table">
                <thead>
                    <tr>
                        <th style="width:10%;">ID Bahan</th>
                        <th style="width:35%;">Jenis Bahan</th>
                        <th style="width:10%;" class="center">Jumlah</th>
                        <th style="width:10%;" class="center">Satuan</th>
                        <th style="width:15%;" class="right">Harga Satuan</th>
                        <th style="width:15%;" class="right">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bomData as $item)
                    <tr>
                        <td>{{ $item->ID_BAHAN_BAKU }}
                            @if(!empty($item->KODE))
                                <br><small>{{ $item->KODE }}</small>
                            @endif
                        </td>
                        <td>{{ $item->JENIS }}</td>
                        <td class="center">{{ number_format($item->JUMLAH, 2, ',', '.') }}</td>
                        <td class="center">{{ $item->SATUAN }}</td>
                        <td class="right">Rp {{ number_format($item->HARGA_SATUAN, 0, ',', '.') }}</td>
                        <td class="right">Rp {{ number_format($item->TOTAL_HARGA, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align:center;padding:60px;color:#94a3b8;">
                <h4>Belum Ada Bahan Baku</h4>
                <p>Bill of Material (BOM) untuk produk ini belum diisi.</p>
            </div>
        @endif
    </div>

</body>
</html>