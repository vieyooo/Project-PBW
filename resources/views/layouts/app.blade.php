<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertue Concept - @yield('title', 'Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
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
        .footer { text-align: center; padding: 20px 0; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; margin-top: 24px; }
        
        @media (max-width: 768px) {
            .sidebar { left: -260px; width: 260px; }
            .sidebar.mobile-open { left: 0; }
            .main-content { margin-left: 0; }
            .content { padding: 16px; }
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="logo"><h2>vertue<span>.</span></h2></div>
    <div class="logo-mini">V<span>.</span></div>
    <div class="nav">
        <!-- Dashboard: semua role -->
        <div class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}"><i class="fas fa-chart-pie"></i><span class="sidebar-text">Dashboard</span></a>
        </div>

        @php
            $jabatanUser = strtolower(Auth::user()->JABATAN ?? '');
        @endphp

        {{-- OWNER & ADMIN: Petugas, Pelanggan, Supplier --}}
        @if(Str::contains($jabatanUser, ['owner', 'admin']))
            <!-- Petugas -->
            <div class="nav-item {{ request()->routeIs('petugas.*') ? 'active' : '' }}">
                <a href="{{ route('petugas.index') }}"><i class="fas fa-user-tie"></i><span class="sidebar-text">Petugas</span></a>
            </div>

            <!-- Pelanggan -->
            <div class="nav-item {{ request()->routeIs('pelanggans.*') ? 'active' : '' }}">
                <a href="{{ route('pelanggans.index') }}"><i class="fas fa-user-friends"></i><span class="sidebar-text">Pelanggan</span></a>
            </div>

            <!-- Supplier -->
            <div class="nav-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <a href="{{ route('suppliers.index') }}"><i class="fas fa-truck"></i><span class="sidebar-text">Supplier</span></a>
            </div>
        @endif

        {{-- OWNER & HEAD OF PRODUCTION: Bahan Baku, Barang/BOM --}}
        @if(Str::contains($jabatanUser, ['owner', 'production']))
            <!-- Bahan Baku -->
            <div class="nav-item {{ request()->routeIs('bahan-bakus.*') ? 'active' : '' }}">
                <a href="{{ route('bahan-bakus.index') }}"><i class="fas fa-boxes"></i><span class="sidebar-text">Bahan Baku</span></a>
            </div>

            <!-- Barang -->
            <div class="nav-item {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                <a href="{{ route('barang.index') }}"><i class="fas fa-box"></i><span class="sidebar-text">Barang</span></a>
            </div>
        @endif

        {{-- SEMUA ROLE: Pembelian --}}
        <div class="nav-item {{ request()->routeIs('pembelian.*') ? 'active' : '' }}">
            <a href="{{ route('pembelian.index') }}"><i class="fas fa-shopping-cart"></i><span class="sidebar-text">Pembelian</span></a>
        </div>

        {{-- OWNER & ADMIN: Penjualan (di bawah Pembelian) --}}
        @if(Str::contains($jabatanUser, ['owner', 'admin']))
            <div class="nav-item {{ request()->routeIs('penjualan.*') ? 'active' : '' }}">
                <a href="{{ route('penjualan.index') }}">
                    <i class="fas fa-file-invoice-dollar"></i><span class="sidebar-text">Penjualan</span>
                </a>
            </div>
        @endif

        <div style="margin-top:40px; border-top:1px solid #e2e8f0; padding-top:12px;"></div>
        <div class="nav-item">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt" style="color: #dc2626;"></i>
                <span class="sidebar-text" style="color: #dc2626;">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </div>
</div>

<div class="main-content" id="mainContent">
    <div class="topbar">
        <div style="display: flex; align-items: center;">
            <button class="toggle-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
            <span class="page-title">@yield('page-title', 'Dashboard')</span>  {{-- default diubah ke 'Dashboard' --}}
        </div>
        <div class="user-dropdown">
            <div class="user" id="userBtn">
                <span class="user-name">{{ session('nama') ?? 'Admin' }}</span>
                <div class="user-avatar">{{ strtoupper(substr(session('nama') ?? 'A', 0, 1)) }}</div>
            </div>
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        @yield('content')
        <div class="footer">Vertue Concept — Interior Mobil Specialist since 2004</div>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('mainContent');
    const toggle = document.getElementById('toggleSidebar');
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
    const userBtn = document.getElementById('userBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');
    userBtn.addEventListener('click', e => { e.stopPropagation(); dropdownMenu.classList.toggle('show'); });
    document.addEventListener('click', () => { dropdownMenu.classList.remove('show'); });
</script>
</body>
</html>