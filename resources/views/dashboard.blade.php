<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Vertue Concept - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #0f172a; }
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100%; width: 220px;
            background: #ffffff; border-right: 1px solid #e2e8f0;
            transition: all 0.3s ease; z-index: 100;
        }
        .sidebar.collapsed { width: 72px; }
        .sidebar-text { font-weight: bold; transition: opacity 0.2s; white-space: nowrap; }
        .sidebar.collapsed .sidebar-text { opacity: 0; display: none; }
        .sidebar.collapsed .logo h2 { display: none; }
        .sidebar.collapsed .logo-mini { display: flex; }
        .logo { padding: 20px 24px; border-bottom: 1px solid #f1f5f9; }
        .logo h2 { font-size: 20px; font-weight: 700; color: #0f172a; white-space: nowrap; }
        .logo h2 span { color: #b8860b; }
        .logo-mini {
            display: none; justify-content: center; padding: 20px 0;
            font-size: 22px; font-weight: 700; color: #b8860b;
        }
        .nav { padding: 12px 8px; }
        .nav-item { margin-bottom: 4px; border-radius: 12px; transition: all 0.2s; }
        .nav-item.active { background: #f1f5f9; }
        .nav-item a {
            display: flex; align-items: center; gap: 12px; padding: 10px 12px;
            text-decoration: none; color: #475569; font-size: 14px;
            font-weight: 500; border-radius: 10px;
        }
        .nav-item a i { width: 22px; text-align: center; font-size: 18px; color: #94a3b8; }
        .nav-item.active a, .nav-item.active a i { color: #b8860b; }
        .nav-item:hover { background: #f8fafc; }
        
        .main-content { margin-left: 220px; transition: all 0.3s ease; min-height: 100vh; }
        .main-content.expanded { margin-left: 72px; }
        
        .topbar {
            background: #ffffff; padding: 12px 28px;
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 99;
        }
        .toggle-btn { background: none; border: none; font-size: 18px; cursor: pointer; color: #64748b; }
        .page-title { font-size: 18px; font-weight: 600; margin-left: 16px; color: #0f172a; }
        .user { display: flex; align-items: center; gap: 16px; cursor: pointer; padding: 4px 8px; border-radius: 8px; transition: 0.2s; }
        .user:hover { background: #f8fafc; }
        .user-name { font-size: 13px; font-weight: 600; color: #334155; }
        .user-avatar {
            width: 36px; height: 36px; background: #b8860b; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 600; font-size: 14px;
        }
        .user-dropdown { position: relative; }
        .dropdown-menu {
            position: absolute; top: 50px; right: 0; background: white;
            border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 150px; display: none; z-index: 1000; border: 1px solid #e2e8f0;
            padding: 8px;
        }
        .dropdown-menu.show { display: block; animation: fadeIn 0.2s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .dropdown-item {
            display: flex; align-items: center; gap: 10px; padding: 10px 16px;
            text-decoration: none; color: #dc2626; font-size: 13px; font-weight: 600;
            transition: all 0.2s; border-radius: 8px;
        }
        .dropdown-item:hover { background: #fef2f2; }
        
        .content { padding: 24px 28px; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px; }
        .stat-card {
            background: #ffffff; padding: 20px; border-radius: 20px;
            border: 1px solid #e2e8f0; transition: all 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.04); }
        .stat-icon {
            width: 48px; height: 48px; background: #fef3c7; border-radius: 14px;
            display: flex; align-items: center; justify-content: center; margin-bottom: 16px;
        }
        .stat-icon i { font-size: 24px; color: #b8860b; }
        .stat-value { font-size: 28px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
        .stat-label { font-size: 13px; font-weight: 500; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .card {
            background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0;
            padding: 24px; margin-bottom: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .card-header h3 { font-size: 16px; font-weight: 700; color: #0f172a; display: flex; align-items: center; }
        .card-header h3 i { color: #b8860b; margin-right: 8px; background: #fef3c7; padding: 8px; border-radius: 8px;}
        .btn-outline {
            background: none; border: 1px solid #e2e8f0; padding: 6px 14px;
            border-radius: 10px; font-size: 12px; cursor: pointer; color: #64748b; font-weight: 600; transition: all 0.2s; display: inline-flex; gap: 6px; align-items: center;
        }
        .btn-outline:hover { border-color: #b8860b; color: #b8860b; background: #f8fafc; }
        canvas { max-height: 320px; width: 100%; }
        .two-columns { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .customer-row, .transaction-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 14px 0; border-bottom: 1px dashed #e2e8f0;
        }
        .customer-row:last-child, .transaction-row:last-child { border-bottom: none; padding-bottom: 0; }
        .customer-name, .transaction-customer { font-weight: 700; font-size: 14px; color: #0f172a; margin-bottom: 4px; }
        .customer-address, .transaction-date { font-size: 12px; color: #64748b; }
        .customer-status { font-size: 11px; font-weight: 700; color: #10b981; background: #dcfce7; padding: 4px 10px; border-radius: 20px; }
        .transaction-amount { font-weight: 700; font-size: 14px; color: #b8860b; background: #fef3c7; padding: 4px 10px; border-radius: 8px; }
        .footer { text-align: center; padding: 20px 0; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; margin-top: 24px; }
        
        @media (max-width: 1000px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .two-columns { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { left: -260px; width: 260px; }
            .sidebar.mobile-open { left: 0; display: block; box-shadow: 10px 0 20px rgba(0,0,0,0.1); }
            .sidebar.collapsed { width: 260px; }
            .main-content { margin-left: 0; }
            .main-content.expanded { margin-left: 0; }
            .stats-grid { grid-template-columns: 1fr; }
            .content { padding: 16px; }
            .topbar { padding: 12px 16px; }
        }
    </style>
</head>
<body>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<div class="sidebar" id="sidebar">
    <div class="logo"><h2>vertue<span>.</span></h2></div>
    <div class="logo-mini">V<span>.</span></div>
    <div class="nav">
<div class="nav">
    <div class="nav-item {{ Str::contains($menu, 'dashboard') ? 'active' : '' }}">
        <a href="?menu=dashboard"><i class="fas fa-chart-pie"></i><span class="sidebar-text">Dashboard</span></a>
    </div>

    @if(Str::contains(strtolower(Auth::user()->JABATAN), ['customer', 'owner']))
        <div class="nav-item {{ request()->routeIs('petugas.*') || Str::contains($menu, 'petugas') ? 'active' : '' }}">
            <a href="{{ route('petugas.index') }}"><i class="fas fa-user-tie"></i><span class="sidebar-text">Petugas</span></a>
        </div>
        <div class="nav-item {{ request()->routeIs('pelanggans.*') || Str::contains($menu, 'pelanggan') ? 'active' : '' }}">
            <a href="{{ route('pelanggans.index') }}"><i class="fas fa-user-friends"></i><span class="sidebar-text">Pelanggan</span></a>
        </div>
        <div class="nav-item {{ Str::contains($menu, 'supplier') ? 'active' : '' }}">
            <a href="?menu=supplier-lihat"><i class="fas fa-truck"></i><span class="sidebar-text">Supplier</span></a>
        </div>
        <div class="nav-item {{ Str::contains($menu, 'penjualan') ? 'active' : '' }}">
            <a href="?menu=penjualan"><i class="fas fa-file-invoice-dollar"></i><span class="sidebar-text">Penjualan</span></a>
        </div>
    @endif

    @if(Str::contains(strtolower(Auth::user()->JABATAN), ['production', 'owner']))
        <div class="nav-item {{ Str::contains($menu, 'bahanbaku') ? 'active' : '' }}">
            <a href="?menu=bahanbaku-lihat"><i class="fas fa-boxes"></i><span class="sidebar-text">Bahan Baku</span></a>
        </div>
        <div class="nav-item {{ Str::contains($menu, 'barang') ? 'active' : '' }}">
            <a href="?menu=barang-lihat"><i class="fas fa-box"></i><span class="sidebar-text"> Barang / BOM</span></a>
        </div>
    @endif

    <div class="nav-item {{ Str::contains($menu, 'pembelian') ? 'active' : '' }}">
        <a href="?menu=pembelian"><i class="fas fa-shopping-cart"></i><span class="sidebar-text">Pembelian</span></a>
    </div>
</div>
    </div>
        <div style="margin-top:40px; border-top:1px solid #e2e8f0; padding-top:12px;"></div>
        <div class="nav-item">
            <a href="#" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin keluar dari Dashboard?')) { document.getElementById('logout-form').submit(); }">
                <i class="fas fa-sign-out-alt" style="color: #dc2626;"></i>
                <span class="sidebar-text" style="color: #dc2626;">Logout</span>
            </a>
        </div>
    </div>
</div>

<div class="main-content" id="mainContent">
    <div class="topbar">
        <div style="display: flex; align-items: center;">
            <button class="toggle-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
            <span class="page-title">
                @php
                $titles = [
                    'dashboard'        => 'Dashboard Utama',
                    'petugas'          => 'Data Petugas',
                    'petugas-tambah'   => 'Tambah Petugas',
                    'petugas-ubah'     => 'Edit Petugas',
                    'petugas-hapus'    => 'Hapus Petugas',
                    'pelanggan'        => 'Data Pelanggan',
                    'pelanggan-lihat'  => 'Data Pelanggan',
                    'pelanggan-tambah' => 'Tambah Pelanggan',
                    'pelanggan-ubah'   => 'Edit Pelanggan',
                    'pelanggan-hapus'  => 'Hapus Pelanggan',
                    'supplier'         => 'Data Supplier',
                    'supplier-lihat'   => 'Data Supplier',
                    'supplier-tambah'  => 'Tambah Supplier',
                    'supplier-ubah'    => 'Edit Supplier',
                    'supplier-hapus'   => 'Hapus Supplier',
                    'bahanbaku'        => 'Data Bahan Baku',
                    'bahanbaku-lihat'  => 'Data Bahan Baku',
                    'bahanbaku-tambah' => 'Tambah Bahan Baku',
                    'bahanbaku-ubah'   => 'Edit Bahan Baku',
                    'bahanbaku-hapus'  => 'Hapus Bahan Baku',
                    'barang'           => 'Data Barang',
                    'barang-lihat'     => 'Data Barang',
                    'barang-tambah'    => 'Tambah Barang',
                    'barang-ubah'      => 'Edit Barang',
                    'barang-hapus'     => 'Hapus Barang',
                    'barangBOM-lihat'  => 'BOM Barang',
                    'barangBOM-tambah' => 'Tambah BOM',
                    'barangBOM-ubah'   => 'Edit BOM',
                    'barangBOM-hapus'  => 'Hapus BOM',
                    'pembelian'        => 'Data Pembelian',
                    'pembelian-lihat'  => 'Data Pembelian',
                    'pembelian-tambah' => 'Tambah Pembelian',
                    'pembelian-ubah'   => 'Edit Pembelian',
                    'pembelian-hapus'  => 'Hapus Pembelian',
                    'detailpembelian-lihat'  => 'Detail Pembelian',
                    'detailpembelian-tambah' => 'Tambah Detail Pembelian',
                    'detailpembelian-ubah'   => 'Edit Detail Pembelian',
                    'detailpembelian-hapus'  => 'Hapus Detail Pembelian',
                    'penjualan'        => 'Data Penjualan',
                    'penjualan-lihat'  => 'Data Penjualan',
                    'penjualan-tambah' => 'Tambah Penjualan',
                    'penjualan-ubah'   => 'Edit Penjualan',
                    'penjualan-hapus'  => 'Hapus Penjualan',
                    'detailpenjualan-lihat'  => 'Detail Penjualan',
                    'detailpenjualan-tambah' => 'Tambah Rincian Jual',
                    'detailpenjualan-ubah'   => 'Edit Rincian Jual',
                    'detailpenjualan-hapus'  => 'Hapus Rincian Jual',
                ];
                echo $titles[$menu] ?? 'Halaman Tidak Ditemukan';
                @endphp
            </span>
        </div>
        <div class="user-dropdown">
            <div class="user" id="userBtn">
                <span class="user-name">{{ $adminName }}</span>
                <div class="user-avatar">{{ $adminAvatar }}</div>
            </div>
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="#" class="dropdown-item" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin keluar?')) { document.getElementById('logout-form').submit(); }">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        @switch($menu)
            @case('dashboard')
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                        <div class="stat-value">Rp{{ number_format($total_pendapatan/1000000, 1, ',', '.') }}Jt</div>
                        <div class="stat-label">Total Pendapatan</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
                        <div class="stat-value">{{ number_format($total_penjualan) }}</div>
                        <div class="stat-label">Total Transaksi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-value">{{ number_format($total_pelanggan) }}</div>
                        <div class="stat-label">Pelanggan Aktif</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-box"></i></div>
                        <div class="stat-value">{{ number_format($total_barang) }}</div>
                        <div class="stat-label">Katalog Produk</div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-chart-area"></i> Grafik Pendapatan 7 Bulan Terakhir</h3>
                        <div>
                            <button class="btn-outline" onclick="window.print()"><i class="fas fa-print"></i> Cetak Laporan</button>
                        </div>
                    </div>
                    <canvas id="salesChart"></canvas>
                </div>
                
                <div class="two-columns">
                    <div class="card">
                        <div class="card-header"><h3><i class="fas fa-user-plus"></i> Pelanggan Terbaru</h3></div>
                        @if($customers->isNotEmpty())
                            @foreach($customers as $row)
                            <div class="customer-row">
                                <div>
                                    <div class="customer-name">{{ $row->NAMA_PELANGGAN }}</div>
                                    <div class="customer-address">{{ Str::limit($row->ALAMAT ?? '', 40) }}</div>
                                </div>
                                <div class="customer-status"><i class="fas fa-check"></i> Hack</div>
                            </div>
                            @endforeach
                        @else
                            <p style="color: #94a3b8; font-size: 13px; text-align: center; padding: 20px 0;">Belum ada data pelanggan.</p>
                        @endif
                    </div>
                    
                    <div class="card">
                        <div class="card-header"><h3><i class="fas fa-receipt"></i> Transaksi Terakhir</h3></div>
                        @if($transactions->isNotEmpty())
                            @foreach($transactions as $row)
                            <div class="transaction-row">
                                <div>
                                    <div class="transaction-customer">{{ $row->NAMA_PELANGGAN ?? 'Pelanggan Umum' }}</div>
                                    <div class="transaction-date"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($row->TANGGAL)->format('d M Y') }}</div>
                                </div>
                                <div class="transaction-amount">Rp {{ number_format($row->TOTAL, 0, ',', '.') }}</div>
                            </div>
                            @endforeach
                        @else
                            <p style="color: #94a3b8; font-size: 13px; text-align: center; padding: 20px 0;">Belum ada riwayat transaksi.</p>
                        @endif
                    </div>
                </div>

                <script>
                new Chart(document.getElementById('salesChart'), {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($bulan_tampil) !!},
                        datasets: [{
                            label: 'Pendapatan Bersih',
                            data: {!! json_encode($data_penjualan) !!},
                            borderColor: '#b8860b', 
                            backgroundColor: 'rgba(184,134,11,0.08)',
                            borderWidth: 3, 
                            pointBackgroundColor: '#ffffff', 
                            pointBorderColor: '#b8860b',
                            pointBorderWidth: 2,
                            pointRadius: 6, 
                            pointHoverRadius: 8, 
                            fill: true, 
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true, 
                        maintainAspectRatio: true,
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        plugins: { 
                            legend: { display: false }, 
                            tooltip: { 
                                backgroundColor: '#0f172a',
                                titleFont: { size: 14, family: 'Inter' },
                                bodyFont: { size: 14, weight: 'bold', family: 'Inter' },
                                padding: 12,
                                displayColors: false,
                                callbacks: { 
                                    label: ctx => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw) 
                                } 
                            } 
                        },
                        scales: {
                            y: { 
                                beginAtZero: true, 
                                grid: { color: '#f1f5f9', drawBorder: false }, 
                                ticks: { 
                                    font: { family: 'Inter', size: 12 },
                                    color: '#64748b',
                                    callback: val => val >= 1000000 ? 'Rp ' + (val/1000000) + ' Jt' : (val >= 1000 ? 'Rp ' + (val/1000) + ' Rb' : 'Rp ' + val) 
                                } 
                            },
                            x: { 
                                grid: { display: false, drawBorder: false },
                                ticks: { font: { family: 'Inter', size: 12 }, color: '#64748b' }
                            }
                        }
                    }
                });
                </script>
            @break

            @case('petugas')
                <script>window.location.href = "{{ route('petugas.index') }}";</script>
            @break
            @case('petugas-tambah') @include('petugas.petugas-tambah') @break
            @case('petugas-ubah') @include('petugas.petugas-ubah') @break
            @case('petugas-hapus') @include('petugas.petugas-hapus') @break
            
            @case('pelanggan')
            @case('pelanggan-lihat') @include('pelanggan.pelanggan-lihat') @break
            @case('pelanggan-tambah') @include('pelanggan.pelanggan-tambah') @break
            @case('pelanggan-ubah') @include('pelanggan.pelanggan-ubah') @break
            @case('pelanggan-hapus') @include('pelanggan.pelanggan-hapus') @break
            
            @case('supplier')
            @case('supplier-lihat') @include('supplier.supplier-lihat') @break
            @case('supplier-tambah') @include('supplier.supplier-tambah') @break
            @case('supplier-edit')
            @case('supplier-ubah') @include('supplier.supplier-ubah') @break
            @case('supplier-hapus') @include('supplier.supplier-hapus') @break
            
            @case('bahanbaku')
            @case('bahanbaku-lihat') @include('bahanbaku.bahanbaku-lihat') @break
            @case('bahanbaku-tambah') @include('bahanbaku.bahanbaku-tambah') @break
            @case('bahanbaku-edit')
            @case('bahanbaku-ubah') @include('bahanbaku.bahanbaku-ubah') @break
            @case('bahanbaku-hapus') @include('bahanbaku.bahanbaku-hapus') @break
            
            @case('barang')
            @case('barang-lihat') @include('barang.barang-lihat') @break
            @case('barang-tambah') @include('barang.barang-tambah') @break
            @case('barang-edit')
            @case('barang-ubah') @include('barang.barang-ubah') @break
            @case('barang-hapus') @include('barang.barang-hapus') @break
            @case('barangBOM-lihat') @include('barang.barangBOM-lihat') @break
            @case('barangBOM-tambah') @include('barang.barangBOM-tambah') @break
            @case('barangBOM-ubah') @include('barang.barangBOM-ubah') @break
            @case('barangBOM-hapus') @include('barang.barangBOM-hapus') @break
            
         {{-- PEMBELIAN --}}
@case('pembelian') @include('pembelian.pembelian-lihat') @break
@case('pembelian-tambah') @include('pembelian.pembelian-tambah') @break
@case('pembelian-ubah') @include('pembelian.pembelian-ubah') @break
@case('pembelian-hapus') @include('pembelian.pembelian-hapus') @break

{{-- DETAIL PEMBELIAN --}}
@case('detailpembelian-lihat') @include('pembelian.detailpembelian-lihat') @break
@case('detailpembelian-tambah') @include('pembelian.detailpembelian-tambah') @break
@case('detailpembelian-ubah') @include('pembelian.detailpembelian-ubah') @break
@case('detailpembelian-hapus') @include('pembelian.detailpembelian-hapus') @break
            @case('penjualan')
            @case('penjualan-lihat') @include('penjualan.penjualan-lihat') @break
            @case('penjualan-tambah') @include('penjualan.penjualan-tambah') @break
            @case('penjualan-ubah') @include('penjualan.penjualan-ubah') @break
            @case('penjualan-hapus') @include('penjualan.penjualan-hapus') @break
            @case('detailpenjualan-lihat') @include('penjualan.detailpenjualan-lihat') @break
            @case('detailpenjualan-tambah') @include('penjualan.detailpenjualan-tambah') @break
            @case('detailpenjualan-ubah') @include('penjualan.detailpenjualan-ubah') @break
            @case('detailpenjualan-hapus') @include('penjualan.detailpenjualan-hapus') @break

            @default
                <div class="card" style="text-align:center;padding:60px 20px;">
                    <i class="fas fa-folder-open" style="font-size:56px;color:#cbd5e1;margin-bottom:20px;display:block;"></i>
                    <h3 style="font-size:20px;font-weight:700;color:#0f172a;margin-bottom:8px;">Halaman Tidak Ditemukan</h3>
                    <p style="color:#64748b;font-size:14px;">Menu yang Anda cari tidak tersedia atau sedang dalam perbaikan.</p>
                    <a href="?menu=dashboard" class="btn-outline" style="margin-top:20px; background:#b8860b; color:white; border:none; padding:10px 20px;"><i class="fas fa-home"></i> Kembali ke Dashboard</a>
                </div>
        @endswitch

        <div class="footer">Vertue Concept — Interior Mobil Specialist since 2004</div>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const main    = document.getElementById('mainContent');
    const toggle  = document.getElementById('toggleSidebar');
    let collapsed = false;

    toggle.addEventListener('click', () => {
        if (window.innerWidth > 768) {
            collapsed = !collapsed;
            sidebar.classList.toggle('collapsed', collapsed);
            main.classList.toggle('expanded', collapsed);
        } else {
            sidebar.classList.toggle('mobile-open');
        }
    });

    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('mobile-open');
            }
        }
    });

    const userBtn      = document.getElementById('userBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');
    
    userBtn.addEventListener('click', e => { 
        e.stopPropagation(); 
        dropdownMenu.classList.toggle('show'); 
    });
    
    document.addEventListener('click', () => {
        dropdownMenu.classList.remove('show');
    });
</script>
</body>
</html>